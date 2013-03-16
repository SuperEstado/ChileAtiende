<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sectores extends CI_Controller {

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

        $data['title'] = 'Backend - Sectores';
        $data['content'] = 'backend/sectores/index';

        $data['sectores'] = Doctrine::getTable('Sector')->findAll();
        $nsectores = Doctrine::getTable('Sector')->count();

        $this->pagination->initialize(array(
            'base_url' => site_url('backend/sectores?order_by=' . $order_by),
            'total_rows' => $nsectores,
            'per_page' => $per_page,
            'first_link' => 'Inicio',
            'last_link' => 'Último'
        ));

        $data['per_page'] = $per_page;
        $data['offset'] = $offset;
        $data['total'] = $nsectores;
        $data['order_by'] = $order_by;

        $this->load->view('backend/template', $data);
    }

    function editar($id) {
        $sector = Doctrine::getTable('Sector')->find($id);

        $data['title'] = 'Backend - Oficina ' . $sector->nombre;
        $data['content'] = 'backend/sectores/editar';
        $data['sector'] = $sector;
        $data['sectores'] = Doctrine::getTable('Sector')->findAll();

        $this->load->view('backend/template', $data);
    }

    function form_guardar($id) {
        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required');
        $this->form_validation->set_rules('sector_padre_codigo', 'Sector', 'trim|required');
        $this->form_validation->set_rules('lat', 'Latitud', 'trim|required');
        $this->form_validation->set_rules('lng', 'Longitud', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $sector = Doctrine::getTable('Sector')->find($id);

            $sector->nombre = $this->input->post('nombre');
            $sector->tipo = $this->input->post('tipo');
            $sector->sector_padre_codigo = $this->input->post('sector_padre_codigo');
            $sector->lat = $this->input->post('lat');
            $sector->lng = $this->input->post('lng');

            $sector->save();

            $this->session->set_flashdata('message', 'Sector guardado exitosamente! :)');
            $respuesta->validacion = TRUE;
            $respuesta->redirect = site_url('backend/sectores/');
        } else {
            $respuesta->validacion = FALSE;
            $respuesta->errores = validation_errors('<p class="error">', '</p>');
        }

        echo json_encode($respuesta);
    }

    function agregar() {
        $data['title'] = 'Backend - Sector ';
        $data['content'] = 'backend/sectores/agregar';
        $data['sectores'] = Doctrine::getTable('Sector')->findAll();

        $this->load->view('backend/template', $data);
    }

    function form_agregar() {
        $this->form_validation->set_rules('codigo', 'Código', 'trim|required|numeric');
        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required');
        $this->form_validation->set_rules('sector_padre_codigo', 'Sector', 'trim|required');
        $this->form_validation->set_rules('lat', 'Latitud', 'trim|required');
        $this->form_validation->set_rules('lng', 'Longitud', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $sector = new Sector();
            $sector->codigo = $this->input->post('codigo');
            $sector->nombre = $this->input->post('nombre');
            $sector->tipo = $this->input->post('tipo');
            $sector->sector_padre_codigo = $this->input->post('sector_padre_codigo');
            $sector->lat = $this->input->post('lat');
            $sector->lng = $this->input->post('lng');

            $sector->save();

            $this->session->set_flashdata('message', 'Sector creado exitosamente! :)');
            $respuesta->validacion = TRUE;
            $respuesta->redirect = site_url('backend/sectores/');
        } else {
            $respuesta->validacion = FALSE;
            $respuesta->errores = validation_errors('<p class="error">', '</p>');
        }

        echo json_encode($respuesta);
    }
}