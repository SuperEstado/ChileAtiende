<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class RangosEdad extends CI_Controller {

    function __construct() {
        parent::__construct();

        if($this->config->item('ssl'))force_ssl();

        UsuarioBackendSesion::checkLogin();

    }
    
    function index() {
        /*$rangos = Doctrine::getTable('RangoEdad')->findAll();

        $data['title'] = 'Backend - Rangos de Edad';
        $data['content'] = 'backend/rangosedad/index';
        $data['rangos'] = $rangos;

        $this->load->view('backend/template', $data);
         * 
         */
    }
    
    function agregar() {

        $data['title'] = 'Backend - Rangos de Edad';
        $data['content'] = 'backend/rangosedad/agregar';

        $this->load->view('backend/template', $data);
    }

    function editar($idRango) {
        $rango = Doctrine::getTable('RangoEdad')->find($idRango);

        $data['title'] = 'Backend - Rangos de Edad';
        $data['content'] = 'backend/rangosedad/editar';
        $data['rango'] = $rango;

        $this->load->view('backend/template', $data);
    }
    
    function form_agregar() {
        
        $this->form_validation->set_rules('edad_minima', 'Edad Mínima', 'trim|required');
        $this->form_validation->set_rules('edad_maxima', 'Edad Máxima', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $rango = new RangoEdad();
            $rango->edad_minima = $this->input->post('edad_minima');
            $rango->edad_maxima = $this->input->post('edad_maxima');
            $rango->save();

            $this->session->set_flashdata('message', 'Rango creado exitosamente');
            $respuesta->validacion = TRUE;
            $respuesta->redirect = site_url('backend/rangosedad');
        } else {
            $respuesta->validacion = FALSE;
            $respuesta->errores = validation_errors('<p class="error">', '</p>');
        }

          echo json_encode($respuesta);
    }
    
    function form_guardar($idRango) {
        
        $this->form_validation->set_rules('edad_minima', 'Edad Mínima', 'trim|required');
        $this->form_validation->set_rules('edad_maxima', 'Edad Máxima', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $rango = Doctrine::getTable('RangoEdad')->find($idRango);

            $rango->edad_minima = $this->input->post('edad_minima');
            $rango->edad_maxima = $this->input->post('edad_maxima');
            $rango->save();

            $this->session->set_flashdata('message', 'Rango actualizado exitosamente');
            $respuesta->validacion = TRUE;
            $respuesta->redirect = site_url('backend/rangosedad');
        } else {
            $respuesta->validacion = FALSE;
            $respuesta->errores = validation_errors('<p class="error">', '</p>');
        }

          echo json_encode($respuesta);
    }
    
    function borrar($idRango) {
        $rango = Doctrine::getTable('RangoEdad')->find($idRango);
        $rango->delete();
        redirect('backend/rangosedad');
    }
}