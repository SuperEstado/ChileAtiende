<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cuenta extends CI_Controller {

    function __construct() {
        parent::__construct();

        if($this->config->item('ssl'))force_ssl();

        UsuarioBackendSesion::checkLogin();
    }

    function index() {
        $CI = & get_instance();
        $usuarioId = $CI->session->userdata('usuario_id');

        $usuario = Doctrine::getTable('UsuarioBackend')->find($usuarioId);

        $data['title'] = 'Backend - Usuarios Backend';
        $data['content'] = 'backend/cuenta/index';
        $data['usuario'] = $usuario;

        $this->load->view('backend/template', $data);
    }

    function form_actualizar($idUsuario) {
        $this->form_validation->set_rules('nombres', 'Nombres', 'trim|required');
        $this->form_validation->set_rules('apellidos', 'Apellidos', 'trim|required');
        if($this->input->post('password')) {
            $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[confirm_password]');
            $this->form_validation->set_rules('confirm_password', 'Confirmar', 'trim|required');
        }

        if ($this->form_validation->run() == TRUE) {
            $usuario = Doctrine::getTable('UsuarioBackend')->find($idUsuario);
            $usuario->nombres = $this->input->post('nombres');
            $usuario->apellidos = $this->input->post('apellidos');

            if ($this->input->post('password'))
                $usuario->password = $this->input->post('password');
            
            $usuario->save();

            $this->session->set_flashdata('message', 'Datos actualizados exitosamente');

            $respuesta->validacion = TRUE;
            $respuesta->redirect = site_url('backend/cuenta/index/');
        } else {
            $respuesta->validacion = FALSE;
            $respuesta->errores = validation_errors('<p class="error">', '</p>');
        }

        echo json_encode($respuesta);
    }

}

?>
