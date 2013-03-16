<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Noticias extends CI_Controller {

    function index() {
        $offset = $this->input->get('offset') ? $this->input->get('offset') : 0;
        $order_by = $this->input->get('order_by') ? $this->input->get('order_by') : 'n.created_at desc';
        $per_page = 15;

        $noticias = Doctrine::getTable('Noticia')->publicados(array('limit' => $per_page, 'offset' => $offset, 'order_by' => $order_by));
        $nnoticias = Doctrine::getTable('Noticia')->publicados(array('justCount' => TRUE));
        $data['categorytabs_closed'] = TRUE;
        $data['title'] = 'Noticias';
        $data['content'] = 'noticias/index';
        $data['noticias'] = $noticias;

        $this->pagination->initialize(array(
            'base_url' => site_url('noticias?order_by=' . $order_by),
            'total_rows' => $nnoticias,
            'per_page' => $per_page,
        ));

        $data['per_page'] = $per_page;
        $data['offset'] = $offset;
        $data['total'] = $nnoticias;
        

        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('template', $data);
    }

    function ver($alias) {
        $noticia = Doctrine::getTable('Noticia')->findOneByAlias($alias);

        if ($noticia) {

            $data['title'] = 'Noticia - ' . $noticia->titulo;
            $data['content'] = 'noticias/ver';
            $data['noticia'] = $noticia;
            $data['categorytabs_closed'] = TRUE;
            //habilitamos el cache
            $this->output->cache($this->config->item('cache'));
            $this->load->view('template', $data);
        } else {
            redirect('noticias/');
        }
    }

    function rss($per_page = 6) {
        header("Content-Type: application/xml; charset=UTF-8");
        $offset = 0;
        $per_page = $per_page;

        $noticias = Doctrine::getTable('Noticia')->publicados(array('order_by' => 'created_at desc', 'limit' => $per_page));


				//Prepara la data para enviarla a la vista
				foreach ($noticias as $key => $noticia) {
					$items[$key]->link = base_url() . 'noticias/ver/' . $noticia->alias;
					$items[$key]->titulo = $noticia->titulo;
					$items[$key]->descripcion = $noticia->contenido;
				}

				$data['items'] = $items;
				$data['titulo'] = 'ChileAtiende - Noticias';
				$data['link'] = base_url().'noticias/';
				$data['descripcion'] = 'Noticias de www.chileatiende.cl';

		    $this->output->cache($this->config->item('cache'));
		    $this->output->set_content_type('application/rss+xml');
		    $this->load->view('rss', $data);
    }

}