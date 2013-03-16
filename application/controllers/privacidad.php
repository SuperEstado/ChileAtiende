<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Privacidad extends CI_Controller {
    function index() {
        $data['categorytabs_closed'] = TRUE;
        $data['title'] = 'Politica de Privacidad';
        $data['content'] = 'privacidad/index';
        
        $this->load->view('template', $data);
    }
}