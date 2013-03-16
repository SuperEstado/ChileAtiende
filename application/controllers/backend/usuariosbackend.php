<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class UsuariosBackend extends CI_Controller {

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
        
        $per_page = 9999;
        $offset = $this->input->get('offset') ? $this->input->get('offset') : 0;
        $order_by = $this->input->get('order_by') ? $this->input->get('order_by') : 'ub.id ASC';
        
        $usuarios = Doctrine::getTable('UsuarioBackend')->todosUsuarios( array('limit' => $per_page, 'offset' => $offset, 'order_by' => $order_by) );
        $nusuarios = Doctrine::getTable('UsuarioBackend')->todosUsuarios( array('justCount' => TRUE) );

        //$usuarios = Doctrine::getTable('UsuarioBackend')->findAll();

        $data['title'] = 'Backend - Usuarios Backend';
        $data['content'] = 'backend/usuariosbackend/index';
        $data['usuarios'] = $usuarios;
        
        $this->pagination->initialize(array(
            'base_url' => site_url('backend/usuariosbackend/?order_by=' . $order_by),
            'total_rows' => $nusuarios,
            'per_page' => $per_page,
            'first_link' => 'Inicio',
            'last_link' => 'Último'
        ));

        $data['per_page'] = $per_page;
        $data['offset'] = $offset;
        $data['total'] = $nusuarios;
        $data['order_by'] = $order_by;

        $this->load->view('backend/template', $data);
    }

    function agregar() {

        $servicios = Doctrine::getTable('Servicio')->findAll();
        $roles = Doctrine::getTable('Rol')->findAll();

        $data['title'] = 'Backend - Agregar Usuario';
        $data['content'] = 'backend/usuariosbackend/agregar';
        $data['servicios'] = $servicios;
        $data['roles'] = $roles;

        $this->load->view('backend/template', $data);
    }

    function editar($idUsuario) {

        $usuario = Doctrine::getTable('UsuarioBackend')->find($idUsuario);
        $servicios = Doctrine::getTable('Servicio')->findAll();
        $roles = Doctrine::getTable('Rol')->findAll();

        $data['title'] = 'Backend - Usuario ' . $usuario->nombres;
        $data['content'] = 'backend/usuariosbackend/editar';
        $data['usuario'] = $usuario;
        $data['servicios'] = $servicios;
        $data['roles'] = $roles;

        $this->load->view('backend/template', $data);
    }

    function borrar($idUsuario) {

        $usuario = Doctrine::getTable('UsuarioBackend')->find($idUsuario);
        $usuario->delete();
        redirect('backend/usuariosbackend');
    }

    function form_agregar() {
        $this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email|callback_valida_existe_usuario');
        $this->form_validation->set_rules('nombres', 'Nombres', 'trim|required');
        $this->form_validation->set_rules('servicio_codigo', 'Servicio', 'required');
        $this->form_validation->set_rules('rol', 'Rol', 'required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[confirm_password]');
        $this->form_validation->set_rules('confirm_password', 'Confirmar', 'trim|required');

        if ($this->form_validation->run() == TRUE) {

            $usuario = new UsuarioBackend();
            $usuario->email = $this->input->post('email');
            $usuario->nombres = $this->input->post('nombres');
            $usuario->apellidos = $this->input->post('apellidos');
            $usuario->ministerial = $this->input->post('ministerial') ? 1 : 0;
            $usuario->interministerial = $this->input->post('interministerial') ? 1 : 0;
            $usuario->setServiciosFromArray($this->input->post('servicio_codigo'));
            $usuario->password = $this->input->post('password');
            $usuario->activo = $this->input->post('activo') ? 1 : 0;
            $usuario->setRolesFromArray($this->input->post('rol'));
            $usuario->save();

            $this->session->set_flashdata('message', 'Usuario actualizado exitosamente! :)');
            $respuesta->validacion = TRUE;
            $respuesta->redirect = site_url('backend/usuariosbackend/');
        } else {
            $respuesta->validacion = FALSE;
            $respuesta->errores = validation_errors('<p class="error">', '</p>');
        }

        echo json_encode($respuesta);
    }

    function form_editar($idUsuario) {
        
        $this->form_validation->set_rules('nombres', 'Nombres', 'trim|required');
        $this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email');
        $this->form_validation->set_rules('servicio_codigo', 'Servicio', 'required');
        $this->form_validation->set_rules('rol', 'Rol', 'required');
        if($this->input->post('password')) {
            $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[confirm_password]');
            $this->form_validation->set_rules('confirm_password', 'Confirmar', 'trim|required');
        }

        if ($this->form_validation->run() == TRUE) {

            $usuario = Doctrine::getTable('UsuarioBackend')->find($idUsuario);
            $usuario->email = $this->input->post('email');
            $usuario->nombres = $this->input->post('nombres');
            $usuario->apellidos = $this->input->post('apellidos');
            $usuario->ministerial = $this->input->post('ministerial') ? 1 : 0;
            $usuario->interministerial = $this->input->post('interministerial') ? 1 : 0;
            $usuario->setServiciosFromArray($this->input->post('servicio_codigo'));
            if($this->input->post('password'))
                $usuario->password = $this->input->post('password');
            $usuario->activo = $this->input->post('activo') ? 1 : 0;
            $usuario->setRolesFromArray($this->input->post('rol'));
            $usuario->save();

            $this->session->set_flashdata('message', 'Usuario actualizado exitosamente! :)');
            $respuesta->validacion = TRUE;
            
            $url = 'backend/usuariosbackend/';
            $order_by = ( $this->input->post('order_by') ) ? str_replace(' ', '%20', $this->input->post('order_by')) : '';
            $offset = ( $this->input->post('offset') ) ? str_replace(' ', '%20', $this->input->post('offset')) : '';
            
            if(isset($order_by) || isset($offset))
                $url = 'backend/usuariosbackend?order_by='.$order_by.'&offset='.$offset;
            
            $respuesta->redirect = site_url($url);
        } else {
            $respuesta->validacion = FALSE;
            $respuesta->errores = validation_errors('<p class="error">', '</p>');
        }

        echo json_encode($respuesta);

    }
    
    function valida_existe_usuario($email) {
        
        $usuario = Doctrine::getTable('UsuarioBackend')->findOneByEmail($email);
        if($usuario) {
            $this->form_validation->set_message('valida_existe_usuario', 'El email '.$email.' ya existe');
            return FALSE;
        }
        
        return TRUE;
    }

}