<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Fichas extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function ver($id){

        $data['theme_page'] = "d";
        $data['theme_header'] = "a";

        $ficha = Doctrine::getTable('Ficha')->findPublicado($id);

        if($ficha[0]->titulo) {

            Doctrine::getTable('Hit')->insertaVista($id);

            $data['title'] = $ficha[0]->titulo;
            if($ficha[0]->flujo)
                $data['content'] = 'movil/verflujo';
            else
                $data['content'] = 'movil/verficha';
            $data['vista_ficha'] = true;
            $data['ficha'] = $ficha[0];

        } else {
            redirect('movil/ficha/error/');
        }

        $this->load->view('movil/template', $data);
    }

}
