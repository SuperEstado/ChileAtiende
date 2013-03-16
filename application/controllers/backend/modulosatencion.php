<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ModulosAtencion extends CI_Controller {

    function __construct() {
        parent::__construct();

        if ($this->config->item('ssl'))
            force_ssl();

        $this->user = UsuarioBackendSesion::usuario();
        UsuarioBackendSesion::checkLogin();
    }

    public function index() {
        if (!($this->user->tieneRol(array('editor', 'aprobador', 'publicador')) )) {
            echo 'No tiene permisos';
            exit;
        }

        $data['title'] = 'Backend - Módulos de atención';
        $data['content'] = 'backend/modulos/index';
        $data['modulos'] = Doctrine::getTable('ModuloAtencion')->findAll();

        $this->load->view('backend/template', $data);
    }
    
    public function editar($id) {
        $modulo = Doctrine::getTable('ModuloAtencion')->find($id);
        
        $data['title'] = 'Backend - Módulo de atención ' . $modulo->descripcion;
        $data['content'] = 'backend/modulos/editar';
        $data['modulo'] = $modulo;
        $data['sectores'] = Doctrine::getTable('Sector')->porComuna();
        $data['servicios'] = Doctrine::getTable('Servicio')->findAll();
        $data['oficinas'] = Doctrine::getTable('Oficina')->findAll();

        $this->load->view('backend/template', $data);
    }
    
    function form_guardar($id) {
        $this->form_validation->set_rules('nro_maquina', 'Número máquina', 'trim|numeric|required');
        $this->form_validation->set_rules('descripcion', 'Descripción', 'trim|required');
        $this->form_validation->set_rules('sector_codigo', 'Sector', 'trim|required');
        $this->form_validation->set_rules('servicio_codigo', 'Servicio', 'trim|required');
        $this->form_validation->set_rules('oficina_id', 'Oficina', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $modulo = Doctrine::getTable('ModuloAtencion')->find($id);

            $modulo->nro_maquina = $this->input->post('nro_maquina');
            $modulo->descripcion = $this->input->post('descripcion');
            $modulo->sector_codigo = $this->input->post('sector_codigo');
            $modulo->servicio_codigo = $this->input->post('servicio_codigo');
            $modulo->oficina_id = $this->input->post('oficina_id');

            $modulo->save();

            $this->session->set_flashdata('message', 'Módulo de atención guardada exitosamente! :)');
            $respuesta->validacion = TRUE;
            $respuesta->redirect = site_url('backend/modulosatencion/');
        } else {
            $respuesta->validacion = FALSE;
            $respuesta->errores = validation_errors('<p class="error">', '</p>');
        }

        echo json_encode($respuesta);
    }
    
    function agregar() {
        $data['title'] = 'Backend - Módulo de atención ';
        $data['content'] = 'backend/modulos/agregar';
        $data['sectores'] = Doctrine::getTable('Sector')->porComuna();
        $data['servicios'] = Doctrine::getTable('Servicio')->findAll();
        $data['oficinas'] = Doctrine::getTable('Oficina')->findAll();

        $this->load->view('backend/template', $data);
    }

    function form_agregar() {
        $this->form_validation->set_rules('nro_maquina', 'Número máquina', 'trim|numeric|required');
        $this->form_validation->set_rules('descripcion', 'Descripción', 'trim|required');
        $this->form_validation->set_rules('sector_codigo', 'Sector', 'trim|required');
        $this->form_validation->set_rules('servicio_codigo', 'Servicio', 'trim|required');
        $this->form_validation->set_rules('oficina_id', 'Oficina', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $modulo = new ModuloAtencion();
            $modulo->nro_maquina = $this->input->post('nro_maquina');
            $modulo->descripcion = $this->input->post('descripcion');
            $modulo->sector_codigo = $this->input->post('sector_codigo');
            $modulo->servicio_codigo = $this->input->post('servicio_codigo');
            $modulo->oficina_id = $this->input->post('oficina_id');

            $modulo->save();

            $this->session->set_flashdata('message', 'Módulo de atención creada exitosamente! :)');
            $respuesta->validacion = TRUE;
            $respuesta->redirect = site_url('backend/modulosatencion/');
        } else {
            $respuesta->validacion = FALSE;
            $respuesta->errores = validation_errors('<p class="error">', '</p>');
        }

        echo json_encode($respuesta);
    }

}
