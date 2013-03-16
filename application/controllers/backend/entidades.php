<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Entidades extends CI_Controller {
    function __construct() {
        parent::__construct();

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

        $data['title'] = 'Backend - Entidades';
        $data['content'] = 'backend/entidades/index';

        $data['entidades'] = Doctrine::getTable('Entidad')->findAll();
        $nentidades = Doctrine::getTable('Entidad')->count();

        $this->pagination->initialize(array(
            'base_url' => site_url('backend/entidades?order_by=' . $order_by),
            'total_rows' => $nentidades,
            'per_page' => $per_page,
            'first_link' => 'Inicio',
            'last_link' => 'Último'
        ));

        $data['per_page'] = $per_page;
        $data['offset'] = $offset;
        $data['total'] = $nentidades;
        $data['order_by'] = $order_by;

        $this->load->view('backend/template', $data);
    }

    function editar($codigo) {
        $entidad = Doctrine::getTable('Entidad')->find($codigo);

        $data['title'] = 'Backend - Entidad ' . $entidad->nombre;
        $data['content'] = 'backend/entidades/editar';
        $data['entidad'] = $entidad;

        $this->load->view('backend/template', $data);
    }

    function form_guardar($codigo) {
        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $entidad = Doctrine::getTable('Entidad')->find($codigo);

            $entidad->nombre = $this->input->post('nombre');
            $entidad->mision = $this->input->post('mision');
            $entidad->sigla = $this->input->post('sigla');

            $entidad->save();

            $this->session->set_flashdata('message', 'Entidad actualizada exitosamente! :)');
            $respuesta->validacion = TRUE;
            $respuesta->redirect = site_url('backend/entidades/');
        } else {
            $respuesta->validacion = FALSE;
            $respuesta->errores = validation_errors('<p class="error">', '</p>');
        }

        echo json_encode($respuesta);
    }

    function agregar() {
        $data['title'] = 'Backend - Entidad ';
        $data['content'] = 'backend/entidades/agregar';

        $this->load->view('backend/template', $data);
    }

    function form_agregar() {
        $this->form_validation->set_rules('codigo', 'Codigo', 'trim|required');
        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $entidad = new Entidad();

            $entidad->codigo = $this->input->post('codigo');
            $entidad->nombre = $this->input->post('nombre');
            $entidad->mision = $this->input->post('mision');
            $entidad->sigla = $this->input->post('sigla');

            $entidad->save();

            $this->session->set_flashdata('message', 'Entidad creada exitosamente! :)');
            $respuesta->validacion = TRUE;
            $respuesta->redirect = site_url('backend/entidades/');
        } else {
            $respuesta->validacion = FALSE;
            $respuesta->errores = validation_errors('<p class="error">', '</p>');
        }

        echo json_encode($respuesta);
    }
}