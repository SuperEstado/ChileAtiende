<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Temas extends CI_Controller {
    function __construct() {
        parent::__construct();

        if($this->config->item('ssl'))force_ssl();

        UsuarioBackendSesion::checkLogin();

        if(!UsuarioBackendSesion::usuario()->tieneRol('mantenedor')){
            echo 'No tiene permisos';
            exit;
        }
    }

    function index() {

        $temas = Doctrine::getTable('Tema')->findAll();

        $data['title'] = 'Backend - Temas';
        $data['content'] = 'backend/temas/index';
        $data['temas'] = $temas;

        $this->load->view('backend/template', $data);
    }

    function agregar() {

        $data['title'] = 'Backend - Agregar Tema';
        $data['content'] = 'backend/temas/agregar';

        $this->load->view('backend/template', $data);
    }

    function editar($idTema) {

        $tema = Doctrine::getTable('Tema')->find($idTema);

        $data['title'] = 'Backend - Tema ' . $tema->nombre;
        $data['content'] = 'backend/temas/editar';
        $data['tema'] = $tema;

        $this->load->view('backend/template', $data);
    }

    function borrar($idTema) {

        Doctrine::getTable('Tema')->find($idTema)->delete();

        redirect('backend/temas');
    }

    function form_agregar() {
        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|callback_validaNombre');

        if ($this->form_validation->run() == TRUE) {

            $tema = new Tema();
            $tema->nombre = $this->input->post('nombre');
            $tema->save();

            $this->session->set_flashdata('message', 'Tema agregado exitosamente! :)');
            $respuesta->validacion = TRUE;
            $respuesta->redirect = site_url('backend/temas/');
        } else {
            $respuesta->validacion = FALSE;
            $respuesta->errores = validation_errors('<p class="error">', '</p>');
        }

        echo json_encode($respuesta);
    }

    function form_editar($idTema) {
        $this->form_validation->set_rules('nombre', 'Nombre', "trim|required|callback_validaNombre[$idTema]");

        if ($this->form_validation->run() == TRUE) {

            $tema = Doctrine::getTable('Tema')->find($idTema);
            $tema->nombre = $this->input->post('nombre');
            $tema->save();

            $this->session->set_flashdata('message', 'Tema actualizado exitosamente! :)');
            $respuesta->validacion = TRUE;
            $respuesta->redirect = site_url('backend/temas/');
        } else {
            $respuesta->validacion = FALSE;
            $respuesta->errores = validation_errors('<p class="error">', '</p>');
        }

        echo json_encode($respuesta);
    }
    
    function validaNombre($nombre, $id='') {
        
        if($id) {
            $tema = Doctrine::getTable('Tema')->find($id);
            if($tema) {
                if( strtolower(trim($tema->nombre)) == strtolower(trim($nombre)) )
                    return TRUE;
            }
        }
            
        $tema = Doctrine::getTable('Tema')->findOneByNombre($nombre);
        
        if($tema) {
            $this->form_validation->set_message('validaNombre', 'El nombre del tema ya existe');
            return FALSE;
        }
        
        return TRUE;
    }
}