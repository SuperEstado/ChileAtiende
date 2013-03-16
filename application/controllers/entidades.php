<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Entidades extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->side_panel_limit = 4;
    }

    function ver($codigo, $offset=null) {

        $options['limit'] = $this->side_panel_limit;
        //Obtengo fichas destacadas
        $options['orderBy'] = "destacado DESC, mas_vistos DESC";
        $fichasDestacadas = Doctrine::getTable('Ficha')->findPublicados($options);

        $fichasMasVistas = Doctrine::getTable('Ficha')->MasVistas( array('limit'=>$this->side_panel_limit) );
        $fichasMasVotadas = Doctrine::getTable('Ficha')->MasVotadas( array('limit'=>$this->side_panel_limit) );

        $data['fichasDestacadas'] = $fichasDestacadas;
        $data['fichasMasVistas'] = $fichasMasVistas;
        $data['fichasMasVotadas'] = $fichasMasVotadas;

        $offset = $offset ? $offset : 0;
        $order_by = 'n.publicado_at desc';
        $per_page = 10;

        $entidad = Doctrine::getTable('Entidad')->find($codigo);
        $fichas = Doctrine::getTable('Ficha')->findFichaOnEntidad($codigo, array('limit' => $per_page, 'offset' => $offset));
        $nfichas = Doctrine::getTable('Ficha')->findFichaOnEntidad($codigo, array('justCount' => TRUE));
        $servicios = Doctrine::getTable('Servicio')->findServiciosConFichas($codigo);

        $data['title'] = ''.$entidad->nombre;
        $data['content'] = 'entidades/ver';
        $data['entidad'] = $entidad;
        $data['servicios'] = $servicios;
        $data['fichas'] = $fichas;

        $this->pagination->initialize(array(
            'base_url' => site_url('entidades/ver/'.$codigo.'/'),
            'total_rows' => $nfichas,
            'per_page' => $per_page,
            'first_link' => 'Primero',
            'last_link' => 'Último'
        ));

        $data['base_url'] = site_url('entidades/ver/'.$codigo.'/');
        $data['per_page'] = $per_page;
        $data['offset'] = $offset;
        $data['total'] = $nfichas;
        $data['order_by'] = $order_by;
        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('template', $data);
    }
}