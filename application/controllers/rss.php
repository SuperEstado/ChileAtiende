<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Rss extends CI_Controller {
	public function index($seccion = 'destacadas'){
		
		switch ($seccion) {
			case 'destacadas':
				$fichas = Doctrine::getTable('Ficha')->MasDestacadas(6);
				$titulo = 'Destacadas';
				break;
			case 'masvistas':
        $fichas = Doctrine::getTable('Ficha')->MasVistas(array('limit' => 6, 'last_week' => true));
        $titulo = 'Mas Vistas';
				break;
		}

		//Prepara la data para enviarla a la vista
		foreach ($fichas as $key => $ficha) {
			$items[$key]->link = base_url() . 'fichas/ver/' . $ficha->maestro_id;
			$items[$key]->titulo = $ficha->titulo;
			$items[$key]->descripcion = prepare_content_ficha($ficha->objetivo);
		}

		$data['items'] = $items;
		$data['titulo'] = 'ChileAtiende - Fichas '.$titulo;
		$data['link'] = base_url();
		$data['descripcion'] = 'Fichas '.$titulo.' de www.chileatiende.cl';

    $this->output->cache($this->config->item('cache'));
    $this->output->set_content_type('application/rss+xml');
    $this->load->view('rss', $data);
	}
	public function destacadas(){
		$this->index('destacadas');
	}
	public function masvistas(){
		$this->index('masvistas');
	}
}
?>