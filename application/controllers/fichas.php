<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Fichas extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->side_panel_limit = 4;
    }


    function ver($id) {

        //$ficha = Doctrine::getTable('Ficha')->find($id);
        list($ficha) = Doctrine::getTable('Ficha')->findPublicado($id);
        if($ficha->titulo) {

            /*Para el caso del breadcumb*/
            $data['subtema'] = "";
            if($this->session->flashdata('subtema')){
                $data['subtema'] = $this->session->flashdata('subtema');
                $this->session->flashdata('subtema');
            }

            $options['limit'] = $this->side_panel_limit;
            //Obtengo fichas destacadas
            $options['orderBy'] = "destacado DESC, mas_vistos DESC"; //Warning
            $fichasDestacadas = Doctrine::getTable('Ficha')->findPublicados($options);
            $fichasMasVistas = Doctrine::getTable('Ficha')->MasVistas( array('limit'=>$this->side_panel_limit, 'last_week'=>true) );
            $fichasMasVotadas = Doctrine::getTable('Ficha')->MasVotadas(array( 'limit' => $this->side_panel_limit ) );

            $data['fichasDestacadas'] = $fichasDestacadas;
            $data['fichasMasVistas'] = $fichasMasVistas;
            $data['fichasMasVotadas'] = $fichasMasVotadas;
            //$data['fichasRelacionadas'] = Doctrine::getTable('Ficha')->getRandom();

            //Obtengo todas las fichas
            //$fichas = Doctrine::getTable('Ficha')->findPublicados()->toArray();

            //Guardo variables
            $data['categorytabs_closed'] = TRUE;
            $data['title'] = ''.$ficha->titulo;
            $data['content'] = 'fichas/ver';
            $data['ficha'] = $ficha;

            if($ficha->tipo == 2) $data['perfil'] = "empresas";

            //$data['fichas'] = $fichas;

        } else {
            redirect('fichas/error/');
        }

        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('template', $data);
    }

    function ajax_inserta_visita($id){
        //Guardo la visita
        Doctrine::getTable('Hit')->insertaVista($id);
    }

    function imprimir($id) {

        $ficha = Doctrine::getTable('Ficha')->find($id);

        $data['title'] = 'Imprimir - '.$ficha->titulo;
        $data['content'] = 'fichas/imprimir';
        $data['ficha'] = $ficha;

        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('print', $data);
    }

    public function ajax_get_evaluaciones_stats($ficha_id) {
        $ficha = Doctrine::getTable('Ficha')->find($ficha_id);

        $evaluaciones = $ficha->getEstadisticaEvaluaciones()->toArray();
        $evaluaciones['canEvaluar'] = $this->_can_evaluar($ficha_id);

        echo json_encode($evaluaciones);
    }

    function _can_evaluar($ficha_id){
        $ficha=Doctrine::getTable('Ficha')->find($ficha_id);

        $evaluados=json_decode($this->input->cookie('evaluados'));

        if(!$evaluados || !in_array($ficha->id, $evaluados))
            return TRUE;

        return FALSE;
    }

}