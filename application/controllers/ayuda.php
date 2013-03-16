<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ayuda extends CI_Controller {
    function index() {
        /*
        $data['categorytabs_closed'] = TRUE;
        $data['title'] = 'Ayuda y Preguntas Frecuentes';
        $data['content'] = 'ayuda/index';

        $this->load->view('template', $data);
        */
        redirect('http://info.chileatiende.cl');
    }
}