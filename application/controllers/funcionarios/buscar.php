<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Buscar extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper("form_helper");
        $this->fichas_por_pagina = 4;
    }

    function index() {

        //Configuracion base
        $data['content'] = 'funcionarios/resultado';
        $data['title'] = 'Busqueda de trámites';
        $data['on'] = 'buscar';
        $data['cookie_favoritos'] = json_decode($this->input->cookie('favoritos'));

        //Se realiza una busqueda
        if($this->input->post('terminos_de_busqueda')){

            //Limpio el string
            $string = $this->input->post('terminos_de_busqueda');
            $string = leave_alpha_numerical(html_entity_decode($string));

            if($string){

                //Seteo la configuracion de busqueda para el modelo de doctrine
                $options_total['filtros']['string'] = $string;
                $options_ficha['filtros']['string'] = $string;

                //configuracion de la paginacion
                $pagina_actual = $this->input->get_post('page');
                $prev = $this->input->get_post('prev');
                $next = $this->input->get_post('next');
                $options_total['justCount'] = TRUE;

                //Obtengo total de resultados y asigno variables de la paginacion
                $total_fichas = Doctrine::getTable('Ficha')->findPublicados($options_total);
                $data = array_merge($data,paginacion($total_fichas,$this->fichas_por_pagina,$pagina_actual,$prev,$next));

                //Obtengo las fichas
                if($total_fichas>0){

                    //Busqueda solo con los resultados de la pagina
                    $options_ficha['limit'] = $this->fichas_por_pagina;
                    $options_ficha['offset'] = $data['offset']; //esto sale de la funcion paginacion un poco mas arriba

                    $data['fichas'] = Doctrine::getTable('Ficha')->findPublicados($options_ficha);

                }

                $data['terminos_de_busqueda'] = $string;
            }
            
        }

        $this->load->view('funcionarios/template',$data);
    }

}

?>
