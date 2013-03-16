<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Oficinas extends CI_Controller {

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

        $data['title'] = 'Backend - Oficinas';
        $data['content'] = 'backend/oficinas/index';

        $data['oficinas'] = Doctrine::getTable('Oficina')->findAll();
        $noficinas = Doctrine::getTable('Oficina')->count();

        $this->pagination->initialize(array(
            'base_url' => site_url('backend/oficinas?order_by=' . $order_by),
            'total_rows' => $noficinas,
            'per_page' => $per_page,
            'first_link' => 'Inicio',
            'last_link' => 'Último'
        ));

        $data['per_page'] = $per_page;
        $data['offset'] = $offset;
        $data['total'] = $noficinas;
        $data['order_by'] = $order_by;

        $this->load->view('backend/template', $data);
    }

    function editar($id) {
        $oficina = Doctrine::getTable('Oficina')->find($id);

        $data['title'] = 'Backend - Oficina ' . $oficina->nombre;
        $data['content'] = 'backend/oficinas/editar';
        $data['oficina'] = $oficina;
        $data['sectores'] = Doctrine::getTable('Sector')->porComuna();
        $data['servicios'] = Doctrine::getTable('Servicio')->findAll();

        $this->load->view('backend/template', $data);
    }

    function form_guardar($id) {
        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required');
        $this->form_validation->set_rules('direccion', 'Dirección', 'trim|required');
        $this->form_validation->set_rules('sector_codigo', 'Sector', 'trim|required');
        $this->form_validation->set_rules('servicio_codigo', 'Servicio', 'trim|required');
        $this->form_validation->set_rules('lat', 'Latitud', 'trim|required');
        $this->form_validation->set_rules('lng', 'Longitud', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $oficina = Doctrine::getTable('Oficina')->find($id);

            $oficina->nombre = $this->input->post('nombre');
            $oficina->direccion = $this->input->post('direccion');
            $oficina->horario = $this->input->post('horario');
            $oficina->telefonos = $this->input->post('telefonos');
            $oficina->fax = $this->input->post('fax');
            $oficina->sector_codigo = $this->input->post('sector_codigo');
            $oficina->servicio_codigo = $this->input->post('servicio_codigo');
            $oficina->lat = $this->input->post('lat');
            $oficina->lng = $this->input->post('lng');
            $oficina->director = $this->input->post('director');


            $oficina->save();

            $this->session->set_flashdata('message', 'Oficina guardada exitosamente! :)');
            $respuesta->validacion = TRUE;
            $respuesta->redirect = site_url('backend/oficinas/');
        } else {
            $respuesta->validacion = FALSE;
            $respuesta->errores = validation_errors('<p class="error">', '</p>');
        }

        echo json_encode($respuesta);
    }

    function agregar() {
        $data['title'] = 'Backend - Oficina ';
        $data['content'] = 'backend/oficinas/agregar';
        $data['sectores'] = Doctrine::getTable('Sector')->porComuna();
        $data['servicios'] = Doctrine::getTable('Servicio')->findAll();

        $this->load->view('backend/template', $data);
    }

    function form_agregar() {
        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required');
        $this->form_validation->set_rules('direccion', 'Dirección', 'trim|required');
        $this->form_validation->set_rules('sector_codigo', 'Sector', 'trim|required');
        $this->form_validation->set_rules('servicio_codigo', 'Servicio', 'trim|required');
        $this->form_validation->set_rules('lat', 'Latitud', 'trim|required');
        $this->form_validation->set_rules('lng', 'Longitud', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $oficina = new Oficina();
            $oficina->nombre = $this->input->post('nombre');
            $oficina->direccion = $this->input->post('direccion');
            $oficina->horario = $this->input->post('horario');
            $oficina->telefonos = $this->input->post('telefonos');
            $oficina->fax = $this->input->post('fax');
            $oficina->sector_codigo = $this->input->post('sector_codigo');
            $oficina->servicio_codigo = $this->input->post('servicio_codigo');
            $oficina->lat = $this->input->post('lat');
            $oficina->lng = $this->input->post('lng');
            $oficina->director = $this->input->post('director');

            $oficina->save();

            $this->session->set_flashdata('message', 'Oficina creada exitosamente! :)');
            $respuesta->validacion = TRUE;
            $respuesta->redirect = site_url('backend/oficinas/');
        } else {
            $respuesta->validacion = FALSE;
            $respuesta->errores = validation_errors('<p class="error">', '</p>');
        }

        echo json_encode($respuesta);
    }
}