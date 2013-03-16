<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Api extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->_check_access();

        $this->load->helper('xml');
    }

    function fichas($codigo=NULL) {        
        $type = $this->input->get('type');
        $callback = $this->input->get('callback');

        if ($codigo === NULL) {
            $query=$this->input->get('query');
            $offset=$this->input->get('pageToken')?base64_decode(urldecode($this->input->get('pageToken'))):0;
            $limit=($this->input->get('maxResults') && $this->input->get('maxResults')<=20)?1*$this->input->get('maxResults'):10;

            $feed->fichas->titulo = 'Listado de Fichas';
            $feed->fichas->tipo = 'chileatiende#fichasFeed';
            
            $options=array();
            if($query)
                $options['filtros']['string']=$query;

            $options['justCount']=TRUE;
            $nresults=Doctrine::getTable('Ficha')->findPublicados($options);

            unset($options['justCount']);
            $options['limit']=$limit;
            $options['offset']=$offset;
            $fichas = Doctrine::getTable('Ficha')->findPublicados($options);

            if($nresults>$limit+$offset)
                $feed->fichas->nextPageToken=urlencode(base64_encode($offset+$limit));

            $feed->fichas->items = NULL;
            foreach ($fichas as $f)
                $feed->fichas->items->ficha[] = $f->toPublicArray();
        } else {
            $codigo=explode('-', $codigo);
            if(count($codigo)!=2) show_404();
            $ficha = Doctrine::getTable('Ficha')->findOneByServicioCodigoAndCorrelativo($codigo[0],$codigo[1]);
            if(!$ficha) show_404();
            $ficha=$ficha->getVersionPublicada();
            if(!$ficha) show_404();
            $feed->ficha = $ficha->toPublicArray();
        }

        if ($type == 'xml') {
            header('Content-type: text/xml');
            echo xml_encode($feed);
        } else {
            header('Content-type: application/json');
            if($callback) echo $callback.'(';
            echo json_encode($feed);
            if($callback) echo ')';
        }
    }

    function servicios($id=NULL, $parameter=NULL){
        $type = $this->input->get('type');
        $callback = $this->input->get('callback');

        if ($id === NULL) {
            $feed->servicios->titulo = 'Listado de Servicios';
            $feed->servicios->tipo = 'chileatiende#serviciosFeed';
            $feed->servicios->items = NULL;

            $servicios = Doctrine::getTable('Servicio')->findConPublicaciones();
            foreach ($servicios as $s)
                $feed->servicios->items->servicio[] = $s->toPublicArray();
        } else {
            $servicio = Doctrine::getTable('Servicio')->find($id);
            if(!$servicio) show_404();
            if($parameter===NULL){         
                $feed->servicio = $servicio->toPublicArray();
            } else if($parameter=='fichas'){
                $feed->fichas->titulo='Listado de Fichas - '.$servicio->nombre;
                $feed->fichas->tipo='chileatiende#fichasFeed';
                $feed->fichas->items = array();
                $fichas=Doctrine::getTable('Ficha')->findFichaOnServicio($id);
                foreach ($fichas as $f)
                    $feed->fichas->items[] = $f->toPublicArray();
            }
        }

        if ($type == 'xml') {
            header('Content-type: text/xml');
            echo xml_encode($feed);
        } else {
            header('Content-type: application/json');
            if($callback) echo $callback.'(';
            echo json_encode($feed);
            if($callback) echo ')';
        }
    }


    function _check_access(){
        $token=$this->input->get('access_token');
        $acceso=Doctrine::getTable('ApiAcceso')->findOneByToken($token);
        if($acceso)
            return;

        show_error('access_token incorrecto',401,'Acceso no autorizado');
        exit;
    }
}