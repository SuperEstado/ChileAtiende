<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Configuraciones extends CI_Controller {

    function __construct() {
        parent::__construct();

        if($this->config->item('ssl'))force_ssl();

        UsuarioBackendSesion::checkLogin();
        
        if (!UsuarioBackendSesion::usuario()->tieneRol('mantenedor')) {
            echo 'No tiene permisos';
            exit;
        }
    }
    
    function index() {
        
        $data['title'] = 'Backend - Configuración';
        $data['content'] = 'backend/configuracion/index';
        $data['msj'] = '';
        
        $data['descripcion'] = Doctrine::getTable('Configuracion')->find('descripcion') ? Doctrine::getTable('Configuracion')->find('descripcion')->valor : '';
        $data['keywords'] = Doctrine::getTable('Configuracion')->find('keywords') ? Doctrine::getTable('Configuracion')->find('keywords')->valor : '';
        $data['autor'] = Doctrine::getTable('Configuracion')->find('autor') ? Doctrine::getTable('Configuracion')->find('autor')->valor : '';
        $data['cache'] = Doctrine::getTable('Configuracion')->find('cache') ? Doctrine::getTable('Configuracion')->find('cache')->valor : '';
        
        $this->load->view('backend/template', $data);
    }
    
    function form_guardar() {
        
        $this->form_validation->set_rules('cache', 'Caché', 'trim|numeric');
        
        if ($this->form_validation->run() == TRUE) {
            foreach($this->input->post() as $key => $val) {
                if(Doctrine::getTable('Configuracion')->find($key)) {
                    $configuracion = Doctrine::getTable('Configuracion')->find($key);
                    $configuracion->delete();
                }
                $conf = new Configuracion();
                $conf->parametro = $key;
                $conf->valor = strip_tags($val);
                $conf->save();
            }

            $data['descripcion'] = Doctrine::getTable('Configuracion')->find('descripcion') ? Doctrine::getTable('Configuracion')->find('descripcion')->valor : '';
            $data['keywords'] = Doctrine::getTable('Configuracion')->find('keywords') ? Doctrine::getTable('Configuracion')->find('keywords')->valor : '';
            $data['autor'] = Doctrine::getTable('Configuracion')->find('autor') ? Doctrine::getTable('Configuracion')->find('autor')->valor : '';
            $data['cache'] = Doctrine::getTable('Configuracion')->find('cache') ? Doctrine::getTable('Configuracion')->find('cache')->valor : '';
            /*
            $data['title'] = 'Backend - Configuración ';
            $data['content'] = 'backend/configuracion/index';
            $data['msj'] = 'Configuración actualizada';
            $this->load->view('backend/template', $data);
            */
            $this->session->set_flashdata('message', 'Configuración actualizada!');
            $respuesta->validacion = TRUE;
            $respuesta->redirect = site_url('backend/configuraciones/');
            
        } else {
            $respuesta->validacion = FALSE;
            $respuesta->errores = validation_errors('<p class="error">', '</p>');
        }
        
        echo json_encode($respuesta);
    
    }
}