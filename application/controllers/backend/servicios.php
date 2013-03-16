<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Servicios extends CI_Controller {

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
        $offset = $this->input->get('offset') ? $this->input->get('offset') : 0;
        $order_by = $this->input->get('order_by') ? $this->input->get('order_by') : 's.codigo ASC';
        $per_page = 30;
        
        $entidad = UsuarioBackendSesion::getEntidad();
        $servicio = UsuarioBackendSesion::getServicio();

        $servicios = Doctrine::getTable('Servicio')->findServicios($entidad, $servicio, array('limit' => $per_page, 'offset' => $offset, 'order_by' => $order_by));
        $nservicios = Doctrine::getTable('Servicio')->findServicios($entidad, $servicio, array('justCount' => TRUE));

        $data['title'] = 'Backend - Servicios';
        $data['content'] = 'backend/servicios/index';
        $data['servicios'] = $servicios;

        $this->pagination->initialize(array(
            'base_url' => site_url('backend/servicios?order_by=' . $order_by),
            'total_rows' => $nservicios,
            'per_page' => $per_page,
            'first_link' => 'Inicio',
            'last_link' => 'Último'
        ));

        $data['per_page'] = $per_page;
        $data['offset'] = $offset;
        $data['total'] = $nservicios;
        $data['order_by'] = $order_by;

        $this->load->view('backend/template', $data);
        //$this->output->enable_profiler(TRUE);
    }

    function editar($codigo) {
        $servicio = Doctrine::getTable('Servicio')->find($codigo);
        $entidades = Doctrine::getTable('Entidad')->findAll();

        $data['title'] = 'Backend - Servicio ' . $servicio->nombre;
        $data['content'] = 'backend/servicios/editar';
        $data['servicio'] = $servicio;
        $data['entidades'] = $entidades;

        $this->load->view('backend/template', $data);
    }

    function form_guardar($codigo) {

        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required');
        $this->form_validation->set_rules('mision', 'Misión', 'trim|required');
        $this->form_validation->set_rules('entidad_codigo', 'Entidad', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $servicio = Doctrine::getTable('Servicio')->find($codigo);

            $servicio->nombre = $this->input->post('nombre');
            $servicio->sigla = $this->input->post('sigla');
            $servicio->url = $this->input->post('url');
            $servicio->responsable = $this->input->post('responsable');
            $servicio->entidad_codigo = $this->input->post('entidad_codigo');
            $servicio->mision = $this->input->post('mision');

            $servicio->save();

            $this->session->set_flashdata('message', 'Servicio guardado exitosamente! :)');
            $respuesta->validacion = TRUE;
            $respuesta->redirect = site_url('backend/servicios/');
        } else {
            $respuesta->validacion = FALSE;
            $respuesta->errores = validation_errors('<p class="error">', '</p>');
        }

        echo json_encode($respuesta);
    }

    function agregar() {

        $entidades = Doctrine::getTable('Entidad')->findAll();

        $data['title'] = 'Backend - Servicio ';
        $data['content'] = 'backend/servicios/agregar';
        $data['entidades'] = $entidades;

        $this->load->view('backend/template', $data);
    }

    function form_agregar() {
        $this->form_validation->set_rules('codigo', 'Código', 'trim|required|min_length[5]|max_length[8]|callback_valida_codigo');
        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required');
        $this->form_validation->set_rules('mision', 'Misión', 'trim|required');
        $this->form_validation->set_rules('entidad_codigo', 'Entidad', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $servicio = new Servicio();

            $servicio->codigo = $this->input->post('codigo');
            $servicio->nombre = $this->input->post('nombre');
            $servicio->sigla = $this->input->post('sigla');
            $servicio->url = $this->input->post('url');
            $servicio->responsable = $this->input->post('responsable');
            $servicio->entidad_codigo = $this->input->post('entidad_codigo');
            $servicio->mision = $this->input->post('mision');

            $servicio->save();

            $this->session->set_flashdata('message', 'Servicio agregado exitosamente! :)');
            $respuesta->validacion = TRUE;
            $respuesta->redirect = site_url('backend/servicios/');
        } else {
            $respuesta->validacion = FALSE;
            $respuesta->errores = validation_errors('<p class="error">', '</p>');
        }

        echo json_encode($respuesta);
    }

    function borrar($codigo) {
        if (!(UsuarioBackendSesion::usuario()->tieneRol('mantenedor') )) {
            echo 'No tiene permisos';
            return;
        }

        $servicio = Doctrine::getTable('Servicio')->find($codigo);

        $servicio->delete();
        redirect('backend/servicios');
    }
    
    function valida_codigo($codigo) {
        
        if(count(explode(' ', $codigo)) == 2) {
            $this->form_validation->set_message('valida_codigo', 'El campo Código no debe tener espacio');
            return FALSE;
        }
        
        $servicio = Doctrine::getTable('Servicio')->find($codigo);
        if($servicio) {
            $this->form_validation->set_message('valida_codigo', 'El campo Código ya existe');
            return FALSE;
        }
        
        return TRUE;
        
    }
    

}