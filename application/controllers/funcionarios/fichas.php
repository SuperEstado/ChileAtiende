<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Fichas extends CI_Controller {

    //Cuando veo la lista desde busqueda por texto
    function tver($id) {
        $data['on'] = 'buscar';
        $this->ver($id,$data);
    }

    //Cuando veo la ficha desde alguna lista
    function lver($id){
        $data['on'] = 'listar';
        $this->ver($id,$data);
    }

    //Metodo que busca el id y obtiene los datos de la ficha (o cartilla)
    function ver($id,$data=array()){

        $ficha = Doctrine::getTable('Ficha')->findPublicado($id);

        if($this->input->get('mail')){

            $data['mail'] = $this->input->get('mail');
            $data['comentarios'] = $this->input->get('comentarios');
            $data['url'] = base_url()."fichas/ver/".$ficha->maestro_id;
            $data['ficha'] = $ficha;

            $this->email->from('chileatiende@modernizacion.gob.cl','ChileAtiende');
            $this->email->to($data['mail'],'camilo.lopez.a@gmail.com','fmancini.cl@gmail.com, eduardoaguayo@gmail.com, marceloperezantivilo@gmail.com, marcelo@unreal.cl');
            $this->email->subject('Detalles sobre ficha '.$ficha->titulo);
            $this->email->message($this->load->view('mails/funcionarios',$data,TRUE));
            unset($data);
            $data['mail_stat'] = $this->email->send();

        }

        if($ficha[0]->titulo) {

            Doctrine::getTable('Hit')->insertaVista($id);

            $data['title'] = ''.$ficha[0]->titulo;
            $data['content'] = 'funcionarios/ficha';
            $data['vista_ficha'] = true;
            $data['ficha'] = $ficha[0];
            $data['cookie_favoritos'] = json_decode($this->input->cookie('favoritos'));

        } else {
            redirect('funcionarios/ficha/error/');
        }

        $this->load->view('funcionarios/template', $data);

    }

}
?>