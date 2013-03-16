<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Empresas extends CI_Controller {

    public function index() {

        $empresas=Doctrine::getTable('ChileclicTipo')->find(2);

        $data['empresas']=$empresas;

        $data['perfil']='empresas';
        $data['title'] = 'Portada Empresas';
        $data['content'] = 'empresas/index';
        

        
        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('template', $data);
    }

    public function subtemas($id){
        $subtema=Doctrine::getTable('ChileclicSubtema')->find($id);

        $this->session->set_flashdata('subtema', $subtema->id."#".$subtema->nombre);
        
        $fichas= Doctrine_Query::create()
            ->from('Ficha f, f.Maestro m ,m.ChileclicSubtemas s')
            ->andWhere('f.maestro=0 and f.publicado=1 and s.id=?',$id)
            ->execute();


        $data['subtema'] = $subtema;
        $data['fichas'] = $fichas;

        $data['perfil'] = 'empresas';
        $data['title'] = 'Portada Empresas';
        $data['content'] = 'empresas/subtemas';

        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('template', $data);
    }
    

}