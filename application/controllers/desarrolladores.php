<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Desarrolladores extends CI_Controller {

    function __construct() {
        parent::__construct();
        if($this->config->item('ssl'))force_ssl();

        $this->load->helper('xml');
    }

    function index(){
        $data['title']='Documentación';
        $data['content']='desarrolladores/index';
        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('desarrolladores/template',$data);
    }

    function fichas(){
        $data['title']='Fichas';
        $data['content']='desarrolladores/fichas';
        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('desarrolladores/template',$data);
    }

    function fichas_obtener(){
        $data['title']='Fichas: obtener';
        $data['content']='desarrolladores/fichas_obtener';
        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('desarrolladores/template',$data);
    }

    function fichas_listar(){
        $data['title']='Fichas: listar';
        $data['content']='desarrolladores/fichas_listar';
        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('desarrolladores/template',$data);
    }

    function fichas_listarporservicio(){
        $data['title']='Fichas: listarPorServicio';
        $data['content']='desarrolladores/fichas_listarporservicio';
        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('desarrolladores/template',$data);
    }

    function servicios(){
        $data['title']='Servicios';
        $data['content']='desarrolladores/servicios';
        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('desarrolladores/template',$data);
    }

    function servicios_obtener(){
        $data['title']='Servicios: obtener';
        $data['content']='desarrolladores/servicios_obtener';
        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('desarrolladores/template',$data);
    }

    function servicios_listar(){
        $data['title']='Servicios: listar';
        $data['content']='desarrolladores/servicios_listar';
        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('desarrolladores/template',$data);
    }

    function terminosdelservicio(){
        $data['title']='Términos del Servicio';
        $data['content']='desarrolladores/terminosdelservicio';
        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('desarrolladores/template',$data);
    }

    function politicasdeuso(){
        $data['title']='Políticas de Uso';
        $data['content']='desarrolladores/politicasdeuso';
        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('desarrolladores/template',$data);
    }

    function access_token(){
        $this->form_validation->set_rules('email','E-Mail','required|valid_email');
        $this->form_validation->set_rules('nombre','Nombre','required');
        $this->form_validation->set_rules('apellido','Apellidos','required');
        $this->form_validation->set_rules('empresa','Empresa');

        if($this->form_validation->run()==TRUE){
            $api_acceso=Doctrine::getTable('ApiAcceso')->findOneByEmail($this->input->post('email'));

            if(!$api_acceso){
                $api_acceso=new ApiAcceso();
                $api_acceso->email=$this->input->post('email');
                $api_acceso->nombre=$this->input->post('nombre');
                $api_acceso->apellido=$this->input->post('apellido');
                $api_acceso->empresa=$this->input->post('empresa');
                $api_acceso->token=random_string('alnum',16);
                $api_acceso->save();
            }

            $this->email->from('chileatiende@chileatiende.gob.cl','ChileAtiende');
            $this->email->to($api_acceso->email);
            $this->email->subject('ChileAtiende API - Código de Acceso');
            $this->email->message('Tu código de acceso (access_token) es el siguiente: '.$api_acceso->token);
            $this->email->send();
            
            redirect('desarrolladores/access_token_exito');
        }

        $data['title']='Solicitar Código de Acceso';
        $data['content']='desarrolladores/access_token';
        $this->load->view('desarrolladores/template',$data);
    }

    function access_token_exito(){
        $data['title']='Solicitud éxitosa';
        $data['content']='desarrolladores/access_token_exito';
        $this->load->view('desarrolladores/template',$data);
    }

}