<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Widget extends CI_Controller {

    function index() {

        $data['title'] = 'ChileAtiende en tu sitio';
        $data['content'] = 'widget/index';
        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('template', $data);
    }
    
    function urls(){
        $data['servicios']=Doctrine::getTable('Servicio')->findServiciosConFichas();
        
        $data['title'] = 'ChileAtiende en tu sitio';
        $data['content'] = 'widget/urls';
        $this->output->cache($this->config->item('cache'));
        $this->load->view('template', $data);
    }

}