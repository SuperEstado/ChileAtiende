<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Favoritos extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper("form_helper");
        $this->fichas_por_pagina = 4;
    }

    function index() {

        //Configuracion base
        $data['content'] = 'funcionarios/favoritos';
        $data['title'] = 'Trámites Favoritos';
        $data['on'] = 'listar';
        $data['listar_on'] = "favoritos";
        $data['cookie_favoritos'] = json_decode($this->input->cookie('favoritos'));

        $favoritos = json_decode($this->input->cookie('favoritos'));
        if(is_array($favoritos) && count($favoritos)>0){
            foreach ($favoritos as $favorito) {
                if($favorito){
                    $ficha_maestro = Doctrine::getTable('Ficha')->findOneById($favorito);
                    if($ficha_maestro){
                        $ficha = $ficha_maestro->getVersionPublicada();
                        if($ficha){
                            $data['favoritos'][] = $ficha;
                        }
                    }
                }
            }

        }
        $this->load->view('funcionarios/template', $data);
    }

    function click($id){

        $aux = $this->input->cookie('favoritos');
        $favoritos = json_decode($aux);

        if($favoritos == null || !in_array($id,$favoritos)){
            return $this->add($id,$favoritos);
        }else{
            return $this->delete($id,$favoritos);
        }
    }

    function add($id,$favoritos){
        $favoritos[] = $id;
        return $this->_save($favoritos);
    }

    function delete($id,$favoritos){
        foreach($favoritos as $key => $favorito){
            if($favorito == $id){
                unset($favoritos[$key]);
            }
        }

        $favoritos = explode(",",implode(",",$favoritos));

        return $this->_save($favoritos);
    }

    function _save($favoritos){

        $cookie = array(
            'name' => 'favoritos',
            'value' => json_encode($favoritos),
            'expire' => '315360000'
        );

        $this->input->set_cookie($cookie);

        return TRUE;

    }

}

?>
