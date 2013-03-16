<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Redirector extends CI_Controller {
    
    function ver_ficha($chileclic_id){
        $ficha=Doctrine::getTable('Ficha')->findOneByMaestroAndCc_llavevalor(1,$chileclic_id);
        if(!$ficha)
            show_404();
        redirect('http://www.chileatiende.cl/fichas/ver/'.$ficha->id, 'location', 301);
    }
    
    function ver_servicio($sigla){
        $servicio=Doctrine::getTable('Servicio')->findOneBySigla($sigla);
        if(!$servicio)
            show_404();
        redirect('http://www.chileatiende.cl/servicios/ver/'.$servicio->codigo, 'location', 301);
    }
    
    function portada(){
        redirect('http://www.chileatiende.cl', 'location', 301);
    }
}