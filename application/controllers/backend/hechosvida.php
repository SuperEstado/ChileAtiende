<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class HechosVida extends CI_Controller {

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
        
        $per_page = 15;
        $offset = $this->input->get('offset') ? $this->input->get('offset') : 0;
        $order_by = $this->input->get('order_by') ? $this->input->get('order_by') : 'h.nombre ASC';
        
        $hechosvida = Doctrine::getTable('HechoVida')->todosHechos( array('limit' => $per_page, 'offset' => $offset, 'order_by' => $order_by) );
        $nhechosvida = Doctrine::getTable('HechoVida')->todosHechos( array('justCount' => TRUE) );
        
        $etapasvida = Doctrine::getTable('EtapaVida')->findAll();
        
        $data['title'] = 'Backend - Hechos de Vida';
        $data['content'] = 'backend/hechosvida/index';
        $data['hechosvida'] = $hechosvida;
        $data['etapasvida'] = $etapasvida;
        
        $this->pagination->initialize(array(
            'base_url' => site_url('backend/hechosvida/?order_by=' . $order_by),
            'total_rows' => $nhechosvida,
            'per_page' => $per_page,
            'first_link' => 'Inicio',
            'last_link' => 'Último'
        ));

        $data['per_page'] = $per_page;
        $data['offset'] = $offset;
        $data['total'] = $nhechosvida;
        $data['order_by'] = $order_by;

        $this->load->view('backend/template', $data);
    }

    function agregar() {
        $etapasvida = Doctrine::getTable('EtapaVida')->findAll();

        $data['title'] = 'Backend - Agregar Hechos de Vida';
        $data['content'] = 'backend/hechosvida/agregar';
        $data['etapasvida'] = $etapasvida;

        $this->load->view('backend/template', $data);
    }

    function editar($id) {

        $hechovida = Doctrine::getTable('HechoVida')->find($id);
        $etapasvida = Doctrine::getTable('EtapaVida')->findAll();

        $data['title'] = 'Backend - Hechos de Vida ' . $hechovida->nombre;
        $data['content'] = 'backend/hechosvida/editar';
        $data['hecho'] = $hechovida;
        $data['etapasvida'] = $etapasvida;

        $this->load->view('backend/template', $data);
    }

    function form_guardar($id) {
        $hecho = Doctrine::getTable('HechoVida')->find($id);
        if (!UsuarioBackendSesion::usuario()->tieneRol('editor')) {
            echo 'No tiene permisos';
            exit;
        }

        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|callback_is_new');

        if ($this->form_validation->run() == TRUE) {
            $hecho->nombre = $this->input->post('nombre');
            $hecho->descripcion = $this->input->post('descripcion');
            $hecho->setEtapasFromArray($this->input->post('etapas'));
            $hecho->save();

            $this->session->set_flashdata('message', 'Hecho actualizado exitosamente! :)');

            $respuesta->validacion = TRUE;
            $respuesta->redirect = site_url('backend/hechosvida');
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
        
        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|callback_is_new');

        if ($this->form_validation->run() == TRUE) {
            $hecho = new HechoVida();

            $hecho->nombre = $this->input->post('nombre');
            $hecho->descripcion = $this->input->post('descripcion');
            $hecho->setEtapasFromArray($this->input->post('etapas'));
            $hecho->save();

            $this->session->set_flashdata('message', 'Hecho creado exitosamente! :)');
            $respuesta->validacion = TRUE;
            $respuesta->redirect = site_url('backend/hechosvida');
        } else {
            $respuesta->validacion = FALSE;
            $respuesta->errores = validation_errors('<p class="error">', '</p>');
        }

        echo json_encode($respuesta);
    }
    
    function is_new($name){
        
        $etapas = $this->input->post('etapas');
        foreach($etapas as $etapa){
            list($hecho) = Doctrine::getTable('HechoVida')->getEtapaName($etapa,$name);
            if ($hecho && $hecho->nombre == $name){
                $this->form_validation->set_message('is_new', 'Ya existe una ficha con el nombre <strong>'.$name.'</strong> en otra etapa de vida');
                return FALSE;
            }
        }
        return TRUE;
        
    }

    function borrar($hecho_id) {
        $hecho = Doctrine::getTable('HechoVida')->find($hecho_id);

        if (!UsuarioBackendSesion::usuario()->tieneRol('editor')) {
            echo 'No tiene permisos';
            return;
        }

        $hecho->delete();
        redirect('backend/hechosvida');
    }

}