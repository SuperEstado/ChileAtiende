<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Servicios extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->side_panel_limit = 4;
    }

    function ver($codigo, $offset=null) {

        $options['limit'] = $this->side_panel_limit;
        //Obtengo fichas destacadas
        $options['orderBy'] = "destacado DESC, mas_vistos DESC";
        $fichasDestacadas = Doctrine::getTable('Ficha')->findPublicados($options);

        $fichasMasVistas = Doctrine::getTable('Ficha')->MasVistas( array( 'limit' => $this->side_panel_limit ) );
        $fichasMasVotadas = Doctrine::getTable('Ficha')->MasVotadas( array( 'limit' => $this->side_panel_limit ) );

        $data['fichasDestacadas'] = $fichasDestacadas;
        $data['fichasMasVistas'] = $fichasMasVistas;
        $data['fichasMasVotadas'] = $fichasMasVotadas;
        //$data['fichasRelacionadas'] = Doctrine::getTable('Ficha')->getRandom();


        $offset = $offset ? $offset : 0;
        $order_by = 'n.publicado_at%20desc';
        $per_page = 10;

        $servicio = Doctrine::getTable('Servicio')->find($codigo);
        //$fichas = Doctrine::getTable('Ficha')->findPublicados();
        //Ordenar por titulo A->Z
        $fichas = Doctrine::getTable('Ficha')->findFichaOnServicio($codigo, array('limit' => $per_page, 'offset' => $offset));
        $nfichas = Doctrine::getTable('Ficha')->findFichaOnServicio($codigo, array('justCount' => TRUE));

        $entidad = $servicio->Entidad;

        $data['categorytabs_closed'] = TRUE;
        $data['title'] = ''.$servicio->nombre;
        $data['content'] = 'servicios/ver';
        $data['servicio'] = $servicio;
        $data['fichas'] = $fichas;
        $data['entidad'] = $entidad;

        $this->pagination->initialize(array(
            'base_url' => site_url('servicios/ver/'.$codigo.'/'),
            'total_rows' => $nfichas,
            'per_page' => $per_page,
            'first_link' => 'Primero',
            'last_link' => 'Último',
            'next_link' => 'Siguiente &gt;',
            'prev_link' => '&lt; Anterior',
            'use_page_numbers' => TRUE,
            'display_pages' => FALSE

        ));

        $data['base_url'] = site_url('servicios/ver/'.$codigo.'/');
        $data['per_page'] = $per_page;
        $data['offset'] = $offset;
        $data['total'] = $nfichas;
        $data['order_by'] = $order_by;

        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('template', $data);
    }

    function directorio() {
        $servicios = Doctrine_Query::create()
                        ->from('Servicio s')
                        ->orderBy('s.nombre')
                        ->execute();
        $servicios = Doctrine::getTable('Servicio')->findConPublicaciones();
        $data['categorytabs_closed'] = TRUE;
        $data['title'] = 'Directorio';
        $data['content'] = 'servicios/directorio';
        $data['servicios'] = $servicios;

        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('template', $data);
    }

}