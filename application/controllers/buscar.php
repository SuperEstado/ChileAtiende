<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Buscar extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->fichas_por_pagina = 10; //usado en fichas y funcion ajax_listar_fichas
        $this->load->helper("form_helper");
    }

    function index() {
        $this->fichas();
    }

    function fichas() {
        
        $this->load->library("textHighlight");

        $data['fichas'] = $data['temas'] = $data['instituciones'] = array();
        $data['categorytabs_closed'] = TRUE;
        $hecho = $tema = $string = null;
        $block_search = FALSE;
        $data['needles'] = array();
        $filtro_temas = $filtro_instituciones = array();
        $options_total = array();
        $options_ficha = array();

        /*
         * FILTRO
         */

        /*
         * CONFIGURO BUSQUEDA
         */
        if ($this->input->get_post('buscar') || $this->input->get_post("search_btn")) {

            $string = leave_alpha_numerical(html_entity_decode($this->input->get_post('buscar')));

            //Guardo la busqueda realizada en log
            $log = new SearchLog();
            $log->search_query = $this->input->post("buscar");
            $log->search_query_parsed = $string;
            $log->save();

            if ($string == ""){
                $block_search = TRUE;
            }

            $options_total['filtros']['string'] = $string;
            $options_ficha['filtros']['string'] = $string;
            //needles son los terminos a destacar en el resultado, en caso de buscar strings.
            $this->load->helper("file");
            $stopwords = explode("\n", read_file("./application/config/stopwords.txt"));
            $data['needles'] = array_diff(explode(" ", $string), $stopwords); 
            
        }

        if ($this->input->get_post('hecho')) {

            $hecho = $this->input->get_post('hecho');
            
            if(!$this->form_validation->is_natural($hecho))
                return;
            
            $options_total['filtros']['hecho'] = $hecho;
            $options_ficha['filtros']['hecho'] = $hecho;
            $data['hecho'] = Doctrine::getTable('HechoVida')->findOneBy('id', $hecho);
        }
        
        if ($this->input->get_post('etapa')) {

            $etapa = $this->input->get_post('etapa');
            
            if(!$this->form_validation->is_natural($etapa))
                return;
            
            //$options_total['filtros']['etapa'] = $etapa;
            //$options_ficha['filtros']['etapa'] = $etapa;
            $data['etapa'] = Doctrine::getTable('EtapaVida')->findOneBy('id', $etapa);
        }

        if ($this->input->get_post('temas')) {
            
            $temas=$this->input->get_post('temas');
            
            if(!preg_match('/^\d+(,\d+)*$/', $temas))
               return;
            
            //if (is_array($temas))
            //    $filtro_temas = ($this->input->get_post('temas')) ? $this->input->get_post('temas') : array();
            //else
                $filtro_temas = explode(",", $temas); //desde paginacion
        }
        //debug($filtro_temas);

        //Reviso si hay Instituciones en el filtro
        if ($this->input->get_post('instituciones')) {
            
            $instituciones=$this->input->get_post('instituciones');
            
            if(!preg_match('/^\w+(,\w+)*$/', $instituciones))
               return;
            
            //if (is_array($this->input->get_post('instituciones'))){
            //    $filtro_instituciones = ($this->input->get_post('instituciones')) ? $this->input->get_post('instituciones') : array();
            //}else{
                $filtro_instituciones = explode(",", $instituciones); //desde paginacion
            //}
        }
        
        if ($this->input->get_post('edad')) {
            
            $edad=$this->input->get_post('edad');
            
            if(!$this->form_validation->is_natural($edad))
                return;
            
            $options_ficha['filtros']['edad'] = $edad;
            $options_total['filtros']['edad'] = $edad;
            $data['edad'] = $edad;

        }

        if ($this->input->get_post('genero')) {
            
            $genero=$this->input->get_post('genero');
                    
            if(!$this->form_validation->is_natural($genero))
                return;
            
            $data['genero'] = $genero;
            $options_ficha['filtros']['genero'] = $genero;
            $options_total['filtros']['genero'] = $genero;
        }

        $found_something = (isset($options_total) && count($options_total)) || isset($filtro_temas) || isset($filtro_instituciones);
        //debug(($found_something)?"si":"no");

        /*
         * OBTENGO RESULTADOS
         */
        if ($found_something && !$block_search) {


            //Busqueda para obtener el total de elementos
            if (is_array($filtro_temas) && count($filtro_temas)) {
                if (count($filtro_temas) > 1 || $filtro_temas[0] != "") {
                    $options_total['filtros']['temas'] = $filtro_temas;
                    $options_ficha['filtros']['temas'] = $filtro_temas;
                    foreach($filtro_temas as $tema_id){
                        try{
                            $t = Doctrine::getTable('Tema')->findOneBy('id', $tema_id);
                            if($t) $data['f_temas'][] = $t->nombre;
                        }catch(Exception $e){
                            echo "";
                        }
                    }
                }
            }
            
            if (is_array($filtro_instituciones) && count($filtro_instituciones)) {
                if (count($filtro_instituciones) > 1 || $filtro_instituciones[0] != "") {
                    $options_total['filtros']['servicios'] = $filtro_instituciones;
                    $options_ficha['filtros']['servicios'] = $filtro_instituciones;
                }
            }

            $options_total['justIds'] = True;
            $total_fichas_set = Doctrine::getTable('Ficha')->findPublicados($options_total);
            $total_fichas = 0;
            if($total_fichas_set){
                foreach($total_fichas_set as $ficha){
                    $total_fichas++;
                }
            }
            
            $data = array_merge($data, paginacion($total_fichas, $this->fichas_por_pagina, $this->input->get_post('page'), $this->input->get_post('prev'), $this->input->get_post('next')));
            
            if ($total_fichas > 0) {

                //Busqueda solo con los resultados de la pagina
                $options_ficha['limit'] = $this->fichas_por_pagina;
                $options_ficha['offset'] = $data['offset'];

                $data['fichas'] = Doctrine::getTable('Ficha')->findPublicados($options_ficha);
                
                $set_de_fichas = array();
                if($total_fichas_set){
                    foreach($total_fichas_set as $ficha){
                        $set_de_fichas[] = $ficha->id;
                    }
                }
                
                $set_de_fichas = implode(",", $set_de_fichas);
                
                $data['temas'] = Doctrine::getTable('Tema')->findTemasBusqueda($set_de_fichas);
                $data['instituciones'] = Doctrine::getTable('Servicio')->findServiciosBusqueda($set_de_fichas);
                
            } else {

                $data['no_results'] = TRUE;
            }
            //Cargo las variables de la vista
            //Variables hidden
            $data['hidden_string'] = ($string) ? $string : NULL;
            $data['hidden_hecho'] = ($this->input->get_post('hecho')) ? $this->input->get_post('hecho') : NULL;
            $data['hidden_filter_temas'] = $filtro_temas;
            $data['hidden_filter_servicios'] = $filtro_instituciones;
        } else {
            $data['no_results'] = TRUE;
            $data = array_merge($data, paginacion(0, $this->fichas_por_pagina, $this->input->get_post('page'), $this->input->post('prev'), $this->input->post('next')));
        }

        $data['opciones'] = $options_total;
        $data['filtro_temas'] = $filtro_temas;
        $data['filtro_instituciones'] = $filtro_instituciones;

        $data['title'] = 'Resultados de Búsqueda';
        $data['content'] = 'busqueda/resultado';
        $data['string_busqueda'] = $string;
        $this->load->view('template', $data);
    }

    function listar_fichas() {


        //Order By
        $oby = ($this->input->get_post("order_by")) ? $this->input->get_post("order_by") : "mas_vistos";
        $oby = $this->_order_by_filter($oby);
        $otype = ($this->input->get_post("order_type")) ? $this->input->get_post("order_type") : "ASC";
        $options_ficha['orderBy'] = $oby . " " . $otype;

        $options_ficha['justCount'] = True;
        $total_fichas = Doctrine::getTable('Ficha')->findPublicados($options_ficha);
        unset($options_ficha['justCount']);

        //Paginacion
        $page_handler = paginacion($total_fichas, $this->fichas_por_pagina, $this->input->get_post('page'), $this->input->get_post('prev'), $this->input->get_post('next'));
        $options_ficha['limit'] = $this->fichas_por_pagina;
        $options_ficha['offset'] = $page_handler['offset'];

        //obtengo data
        if ($total_fichas > 0) {
            $fichas = Doctrine::getTable('Ficha')->findPublicados($options_ficha);
        } else {
            $fichas = array();
        }

        $data['fichas'] = $fichas;
        $data['needles'] = array();
        $data = array_merge($data, $page_handler); //Le paso los parametros de la paginacion a data
        $data['title'] = 'Resultados de Búsqueda';
        $data['content'] = 'busqueda/resultado';
        $this->load->view('template', $data);
    }

    function _order_by_filter($order_by) {
        //Filtro para palabras especiales con mapeo a un campo
        switch ($order_by) {
            case "titulo":
                $order_by = "f.titulo";
                break;
            default:
                break;
        }
        return $order_by;
    }

}

?>