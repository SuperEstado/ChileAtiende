<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Noticias extends CI_Controller {

    function __construct() {
        parent::__construct();

        if($this->config->item('ssl'))force_ssl();

        UsuarioBackendSesion::checkLogin();

        if(!UsuarioBackendSesion::usuario()->tieneRol('reportero')){
            echo 'No tiene permisos';
            exit;
        }
    }

    function index() {
        
        $per_page = 15;
        $offset = $this->input->get('offset') ? $this->input->get('offset') : 0;
        $order_by = $this->input->get('order_by') ? $this->input->get('order_by') : 'n.id ASC';
        
        $noticias = Doctrine::getTable('Noticia')->todasNoticias( array('limit' => $per_page, 'offset' => $offset, 'order_by' => $order_by) );
        $nnoticias = Doctrine::getTable('Noticia')->todasNoticias( array('justCount' => TRUE) );

        $data['title'] = 'Backend - Noticias';
        $data['content'] = 'backend/noticias/index';
        $data['noticias'] = $noticias;
        
        $this->pagination->initialize(array(
            'base_url' => site_url('backend/noticias/?order_by=' . $order_by),
            'total_rows' => $nnoticias,
            'per_page' => $per_page,
            'first_link' => 'Inicio',
            'last_link' => 'Último'
        ));

        $data['per_page'] = $per_page;
        $data['offset'] = $offset;
        $data['total'] = $nnoticias;
        $data['order_by'] = $order_by;

        $this->load->view('backend/template', $data);
        //$this->output->enable_profiler(TRUE);
    }

    function agregar() {
        $data['title'] = 'Backend - Agregar Noticias';
        $data['content'] = 'backend/noticias/agregar';

        $this->load->view('backend/template', $data);
    }

    function editar($id) {

        $noticia = Doctrine::getTable('Noticia')->find($id);

        $data['title'] = 'Backend - Noticias ' . $noticia->titulo;
        $data['content'] = 'backend/noticias/editar';
        $data['noticia'] = $noticia;

        $this->load->view('backend/template', $data);
    }

    function form_agregar() {

        $this->form_validation->set_rules('titulo', 'Título', 'trim|required');
        //$this->form_validation->set_rules('resumen', 'Resumen', 'trim|required');
        $this->form_validation->set_rules('contenido', 'Contenido', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $noticia = new Noticia();
            $noticia->titulo = $this->input->post('titulo');
            $noticia->alias = url_title(convert_accented_characters($this->input->post('titulo')), 'underscore', TRUE);
            //$noticia->resumen = $this->input->post('resumen');
            $noticia->contenido = $this->input->post('contenido');
            $noticia->publicado = ($this->input->post('publicado')) ? 1 : 0;
            $noticia->foto_descripcion = $this->input->post('foto_descripcion');


            $config['upload_path'] = './uploads/noticias/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '1000';
            $config['max_width'] = '1024';
            $config['max_height'] = '768';
            $config['overwrite'] = TRUE;
            $config['file_name'] = date('YmdHis') . '.' . substr($_FILES['imagen']['name'], -3);

            $this->load->library('upload', $config);

            $msg = 'La noticia <strong>' . $noticia->titulo . '</strong> se creó correctamente';
            $url = 'backend/noticias/index';
            
            if ($_FILES['imagen']['size'] > 0 && !$this->upload->do_upload('imagen')) {
                $msg = 'Error: ' . $this->upload->display_errors();
                $url = 'backend/noticias/agregar';
            } else {
                if ($_FILES['imagen']['size'] > 0 && $noticia->foto) {
                    unlink('./uploads/noticias/' . $noticia->foto);
                    $noticia->foto = $config['file_name'];
                }
                if ($_FILES['imagen']['size'] > 0)
                    $noticia->foto = $config['file_name'];
            
                $noticia->save();
            }
            
            
            
            $this->session->set_flashdata('message', $msg);

            redirect($url);
        }

        $data['title'] = 'Backend - Agregar Noticias';
        $data['content'] = 'backend/noticias/agregar';

        $this->load->view('backend/template', $data);
    }

    function form_guardar($id) {
        $this->form_validation->set_rules('titulo', 'Título', 'trim|required');
        //$this->form_validation->set_rules('resumen', 'Resumen', 'trim|required');
        $this->form_validation->set_rules('contenido', 'Contenido', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $noticia = Doctrine::getTable('Noticia')->find($id);

            $noticia->titulo = $this->input->post('titulo');
            $noticia->alias = url_title(convert_accented_characters($this->input->post('titulo')), 'underscore', TRUE);
            //$noticia->resumen = $this->input->post('resumen');
            $noticia->contenido = $this->input->post('contenido');
            $noticia->publicado = ($this->input->post('publicado')) ? 1 : 0;
            $noticia->foto_descripcion = $this->input->post('foto_descripcion');
            $noticia->created_at = $this->input->post('created_at');

            $config['upload_path'] = './uploads/noticias/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '1000';
            $config['max_width'] = '1024';
            $config['max_height'] = '768';
            $config['overwrite'] = TRUE;
            $config['file_name'] = date('YmdHis') . '.' . substr($_FILES['imagen']['name'], -3);

            $this->load->library('upload', $config);

            $msg = 'La noticia <strong>' . $noticia->titulo . '</strong> se actualizó correctamente';
            $url = 'backend/noticias/index';

            if ($_FILES['imagen']['size'] > 0 && !$this->upload->do_upload('imagen')) {
                $msg = 'Error: ' . $this->upload->display_errors();
                $url = 'backend/noticias/editar/' . $noticia->id;
            } else {
                if ($_FILES['imagen']['size'] > 0 && $noticia->foto) {
                    unlink('./uploads/noticias/' . $noticia->foto);
                    $noticia->foto = $config['file_name'];
                }
                if ($_FILES['imagen']['size'] > 0)
                    $noticia->foto = $config['file_name'];
            }
            
            $noticia->save();


            $this->session->set_flashdata('message', $msg);

            redirect($url);
        }
    }

    function borrar($id) {
        $noticia = Doctrine::getTable('Noticia')->find($id);
        unlink('./uploads/noticias/' . $noticia->foto);
        $noticia->delete();
        redirect('backend/noticias');
    }

}