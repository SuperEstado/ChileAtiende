<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Portada extends CI_Controller {

    public function index($modulo=FALSE) {

        $data = $this->_load_common_data();
        $dataMeta = $this->_load_meta();
        $data['tab_tema'] = TRUE;
        
        $data['slide'] = 'front';
        $data['title'] = 'Portada';
        $data['content'] = 'portada/slider';

        if (isset($modulo) && ($modulo)) {
            $data["display_mod_atencion"] = true;
            $data["modulos"] = Doctrine::getTable('ModuloAtencion')->ModulosOrdenados();
        }

        //Obtiene las ultimas noticias del portal
        $data['noticias'] = Doctrine::getTable('Noticia')->ultimasNoticias(array('limit' => 3));

        $data = array_merge($data, $dataMeta);
        
        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('template', $data);
    }

    function etapas() {

        $data = $this->_load_common_data();

        $data['etapas'] = Doctrine_Query::create()->from('EtapaVida')->orderBy('orden asc')->execute();
        //$hechos = Doctrine_Query::create()->from('HechoVida h, h.EtapasVida e')->where('e.orden = 1')->limit(3)->execute();
        //$hechos = Doctrine_Query::create()->from('HechoVida h, h.EtapasVida e')->where('e.id= 4 AND h.Fichas.id>0')->execute();
        //$data['hechos'] = $hechos;

        $data['slide'] = 'etapas';
        $data['title'] = 'Etapas';
        $data['content'] = 'portada/slider';

        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('template', $data);
    }

    function temas() {
        $data = $this->_load_common_data();

        $data['generos'] = Doctrine::getTable("Genero")->findAll();
        $temas = Doctrine_Query::create()->from('Tema t, t.Fichas f')->where('f.id>0')->groupBy('nombre')->execute();
        $data['temas'] = $temas;

        $data['slide'] = 'temas';
        $data['title'] = 'Temas';
        $data['content'] = 'portada/slider';

        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('template', $data);
    }

    public function modulo() {
        echo $this->index(TRUE);
    }
    
    public function sitemap($mobile=false) {
        ini_set("memory_limit","128M");
        
        $options['limit'] = 0;
        $options['offset'] = 0;
        
        $publicadas = Doctrine::getTable('Ficha')->findPublicados($options);
        /*
        $publicadas = Doctrine_Query::create()
                        ->from('Ficha')
                        ->where('maestro=1 AND publicado=1')
                        ->execute(array(), Doctrine_Core::HYDRATE_ON_DEMAND);
        */
        $aData["publicadas"] = $publicadas;
        
        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        if($mobile)
            $this->load->view('sitemapmobile', $aData);
        else
            $this->load->view('sitemap', $aData);
    }
    
    function sitemapmobile() {
        $this->sitemap(true);
    }

    function _load_common_data() {

        $fichas_por_pagina = 4;
        $options['limit'] = $fichas_por_pagina;

        $fichasMasVistas = Doctrine::getTable('Ficha')->MasVistas(array('limit' => $fichas_por_pagina, 'last_week' => true));
        $fichasDestacadas = Doctrine::getTable('Ficha')->MasDestacadas(4);

        $data['oficinas'] = Doctrine::getTable('Oficina')->findByServicioCodigo('AL005');
        $data['comunas'] = Doctrine_Query::create()
                ->from('Sector s, s.Oficinas o')
                ->select('s.*, COUNT(o.id) noficinas')
                ->where('s.tipo="comuna"')
                ->having('noficinas > 0')
                ->groupBy('s.codigo')
                ->orderBy('s.nombre asc')
                ->execute();

        $data['fichasMasVistas'] = $fichasMasVistas;
        $data['fichasDestacadas'] = $fichasDestacadas;
        return $data;
    }
    
    function _load_meta() {
        $descripcion = Doctrine::getTable('Configuracion')->find('descripcion')->valor;
        $keywords = Doctrine::getTable('Configuracion')->find('keywords')->valor;
        $autor = Doctrine::getTable('Configuracion')->find('autor')->valor;
        
        $data["descripcion"] = $descripcion;
        $data["keywords"] = $keywords;
        $data["autor"] = $autor;
        
        return $data;
    }

}