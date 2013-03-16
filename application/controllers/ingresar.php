<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ingresar extends CI_Controller {

        function index( $codigo ) {

        $servicio = Doctrine::getTable('Servicio')->find( $codigo );
        $fichas = Doctrine::getTable('Ficha')->findByServicioCodigo( $codigo );

        $data['title'] = $servicio->nombre;
        $data['content'] = 'servicios/ver';
        $data['servicio'] = $servicio;
        $data['fichas'] = $fichas;

        $this->load->view('template', $data);
    }
}