<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class EtapasVida extends CI_Controller {
    function __construct() {
        parent::__construct();

        if($this->config->item('ssl'))force_ssl();

        UsuarioBackendSesion::checkLogin();

        if (!UsuarioBackendSesion::usuario()->tieneRol('reportero')) {
            echo 'No tiene permisos';
            exit;
        }
    }

    function index() {
        $etapasvida = Doctrine::getTable('EtapaVida')->findAll();

        $data['title'] = 'Backend - Etapas de Vida';
        $data['content'] = 'backend/etapasvida/index';
        $data['etapasvida'] = $etapasvida;

        $this->load->view('backend/template', $data);
        //$this->output->enable_profiler(TRUE);
    }
    
    function agregar() {
        
        $data['title'] = 'Backend - Agregar Etapas de Vida';
        $data['content'] = 'backend/etapasvida/agregar';
        
        $this->load->view('backend/template', $data);
    }

    function editar($id) {

        $etapavida = Doctrine::getTable('EtapaVida')->find($id);

        $data['title'] = 'Backend - Etapas de Vida ' . $etapavida->nombre;
        $data['content'] = 'backend/etapasvida/editar';
        $data['etapa'] = $etapavida;

        $this->load->view('backend/template', $data);
    }
    
    function form_guardar($id) {
        $etapa = Doctrine::getTable('EtapaVida')->find($id);
        if (!UsuarioBackendSesion::usuario()->tieneRol('editor')) {
            echo 'No tiene permisos';
            exit;
        }

        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $etapa->nombre = $this->input->post('nombre');
            $etapa->descripcion = $this->input->post('descripcion');
            $etapa->save();

            $this->session->set_flashdata('message', 'Etapa actualizada exitosamente! :)');

            $respuesta->validacion = TRUE;
            $respuesta->redirect = site_url('backend/etapasvida');
        } else {
            $respuesta->validacion = FALSE;
            $respuesta->errores = validation_errors('<p class="error">', '</p>');
        }

        echo json_encode($respuesta);
    }
    
    function form_agregar() {
        if (!(UsuarioBackendSesion::usuario()->tieneRol('editor'))) {
            echo 'No tiene permisos';
            exit;
        }

        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $etapa = new EtapaVida();

            $etapa->nombre = $this->input->post('nombre');
            $etapa->descripcion = $this->input->post('descripcion');
            $etapa->save();

            $this->session->set_flashdata('message', 'Etapa creada exitosamente! :)');
            $respuesta->validacion = TRUE;
            $respuesta->redirect = site_url('backend/etapasvida');
        } else {
            $respuesta->validacion = FALSE;
            $respuesta->errores = validation_errors('<p class="error">', '</p>');
        }

        echo json_encode($respuesta);
    }
    
    function borrar($etapa_id) {
        $etapa = Doctrine::getTable('EtapaVida')->find($etapa_id);

        if (!UsuarioBackendSesion::usuario()->tieneRol('editor')) {
            echo 'No tiene permisos';
            return;
        }

        $etapa->delete();
        redirect('backend/etapasvida');
    }
}