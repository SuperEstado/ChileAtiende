<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Hechos extends CI_Controller {

    function __construct() {
        parent::__construct();
    }


    function ver($etapa_id,$hecho_id) {
        $data['etapa']=Doctrine::getTable('EtapaVida')->find($etapa_id);
        $data['hecho'] = Doctrine::getTable('HechoVida')->find($hecho_id);

        $options['filtros']['hecho'] = $hecho_id;
        $data['fichas'] = Doctrine::getTable('Ficha')->findPublicados($options);


        $data['theme_page'] = "d";
        $data['theme_header'] = "a";
        $data['title'] = $data['hecho']->nombre;
        $data['content'] = 'movil/verhecho';


        $this->load->view('movil/template', $data);
    }

}
