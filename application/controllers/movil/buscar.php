<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Buscar extends CI_Controller {

    function __construct() {

        parent::__construct();
        $this->load->helper("form_helper");
        $this->fichas_por_pagina = 100;

    }

    function index() {

        //Configuracion base
        $data['title'] = 'Búsqueda de trámites';
        $data['on'] = 'buscar';

        $cookie = array(
            'name' => 'movil',
            'value' => '1',
            'expire' => '3153600'
        );
        $this->input->set_cookie($cookie);

        //Se realiza una busqueda
        if($this->input->post('buscar')){

            $data['theme_page'] = "c";
            $data['theme_header'] = "a";

            $data['content'] = 'movil/verresultado';
            //Limpio el string
            $string = $this->input->post('buscar');
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

                    $data['fichas_busqueda'] = Doctrine::getTable('Ficha')->findPublicados($options_ficha);

                }

                $data['buscar'] = $string;
            }

        }else{

            $data['theme_page'] = "d";
            $data['theme_header'] = "a";

            $data['content'] = 'movil/home';
            $data['no_back'] = TRUE;
            //Seteo la configuracion de busqueda para el modelo de doctrine
            $options_destacados['orderBy'] = 'destacado DESC';
            $options_mas_vistos['limit'] = $options_destacados['limit'] = 5;

            //Obtengo total de resultados y asigno variables de la paginacion
            $data['fichas_mas_vistas'] = Doctrine::getTable('Ficha')->MasVistas( array('limit'=>5) );
            $data['fichas_destacadas'] = Doctrine::getTable('Ficha')->MasDestacadas(3);
        }

        $this->load->view('movil/template', $data);
    }

}

?>
