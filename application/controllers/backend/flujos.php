<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Flujos extends CI_Controller {

    function __construct() {
        parent::__construct();

        if($this->config->item('ssl'))force_ssl();

        UsuarioBackendSesion::checkLogin();
        
        if (!(UsuarioBackendSesion::usuario()->tieneRol('editor'))) {
            echo 'No tiene permisos';
            exit;
        }
    }

    function index() {
        $offset = $this->input->get('offset') ? $this->input->get('offset') : 0;
        $order_by = $this->input->get('order_by') ? $this->input->get('order_by') : 'f.titulo ASC';
        $per_page = 30;

        $flujos = Doctrine::getTable('Flujo')->getFlujos(array('limit' => $per_page, 'offset' => $offset));
        $nflujos = Doctrine::getTable('Flujo')->getFlujos(array('justCount' => TRUE));

        $data['title'] = 'Backend - Flujos';
        $data['content'] = 'backend/flujos/index';
        $data['flujos'] = $flujos;

        $this->pagination->initialize(array(
            'base_url' => site_url('backend/flujos?order_by=' . $order_by),
            'total_rows' => $nflujos,
            'per_page' => $per_page,
            'first_link' => 'Inicio',
            'last_link' => 'Último'
        ));

        $data['per_page'] = $per_page;
        $data['offset'] = $offset;
        $data['total'] = $nflujos;
        $data['order_by'] = $order_by;

        $this->load->view('backend/template', $data);
    }

    function agregar() {
        
        $data['title'] = 'Backend - Flujos';
        $data['content'] = 'backend/flujos/agregar';

        $this->load->view('backend/template', $data);
    }

    function editar($idFlujo) {
        $flujo = Doctrine::getTable('Flujo')->find($idFlujo);

        $data['title'] = 'Backend - Flujos';
        $data['content'] = 'backend/flujos/editar';
        $data['flujo'] = $flujo;

        $this->load->view('backend/template', $data);
    }

    function agregar_form() {
        if (!(UsuarioBackendSesion::usuario()->tieneRol('editor'))) {
            echo 'No tiene permisos';
            exit;
        }

        $this->form_validation->set_rules('titulo', 'Título', 'trim|required');
        $this->form_validation->set_rules('descripcion', 'Descripción', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $flujo = new Flujo();

            $flujo->titulo = $this->input->post('titulo');
            $flujo->alias = convert_accented_characters($this->input->post('titulo'));
            $flujo->descripcion = $this->input->post('descripcion');
            $flujo->save();

            $this->session->set_flashdata('message', 'Flujo creado exitosamente! :)');
            
            $respuesta->validacion = TRUE;
            $respuesta->redirect = site_url('backend/flujos');
        } else {
            $respuesta->validacion = FALSE;
            $respuesta->errores = validation_errors('<p class="error">', '</p>');
        }

        echo json_encode($respuesta);
        
    }

    function editar_form($idFlujo) {
        if (!(UsuarioBackendSesion::usuario()->tieneRol('editor'))) {
            echo 'No tiene permisos';
            exit;
        }

        $this->form_validation->set_rules('titulo', 'Título', 'trim|required');
        $this->form_validation->set_rules('descripcion', 'Descripción', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $flujo = Doctrine::getTable('Flujo')->find($idFlujo);

            $flujo->titulo = $this->input->post('titulo');
            $flujo->alias = convert_accented_characters($this->input->post('titulo'));
            $flujo->descripcion = $this->input->post('descripcion');
            $flujo->save();

            $this->session->set_flashdata('message', 'Flujo actualizado exitosamente! :)');
            
            $respuesta->validacion = TRUE;
            $respuesta->redirect = site_url('backend/flujos');
        } else {
            $respuesta->validacion = FALSE;
            $respuesta->errores = validation_errors('<p class="error">', '</p>');
        }

        echo json_encode($respuesta);
    }

    function borrar($idFlujo) {
        $flujo = Doctrine::getTable('Flujo')->find($idFlujo);
        $flujo->delete();
        redirect('backend/flujos');
    }

}