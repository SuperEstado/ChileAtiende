<?php

class Backend extends CI_Controller {

    function __construct() {
        parent::__construct();

        if($this->config->item('ssl'))force_ssl();

        UsuarioBackendSesion::checkLogin();
    }

    function ajax_get_servicios($entidad_codigo) {
        //$servicios = Doctrine::getTable('Entidad')->find($entidad_codigo)->Servicios;
        $servicios = UsuarioBackendSesion::usuario()->getServiciosAccesibles($entidad_codigo);
        echo json_encode($servicios->toArray());
    }

    function change_institucion() {
        //Pendiente
        //Validar que el servicio y entidad que recibes, tu tienes permiso para acceder a el.
        $this->form_validation->set_rules('servicio_codigo', 'Servicio', 'required');
        $this->form_validation->set_rules('entidad_codigo', 'Entidad', 'required');
        if ($this->form_validation->run() == TRUE) {
            UsuarioBackendSesion::setEntidad($this->input->post('entidad_codigo'));
            UsuarioBackendSesion::setServicio($this->input->post('servicio_codigo'));
            //UsuarioBackendSesion::setTitulo($this->input->post('titulo'));
            redirect($this->input->server('HTTP_REFERER'));
        }
    }

}