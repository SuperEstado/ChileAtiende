<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contacto extends CI_Controller {
    public function index() {
        $data['title'] = 'Contacto';
        $data['content'] = 'contacto/ver';

        $this->load->view('template', $data);
    }

    function enviaramigo() {
        $data['title'] = 'Contacto';
        $data['content'] = 'contacto/enviaramigo';

        $this->load->view('template', $data);
    }

    function enviaemailamigo() {
        $this->form_validation->set_rules('nombres','Nombres','required');
        //$this->form_validation->set_rules('apellido_paterno','Apellido Paterno','required');
        $this->form_validation->set_rules('email','Correo Electrónico','required|valid_email');
        //datos amigo
        $this->form_validation->set_rules('nombres_a','Nombres','required');
        //$this->form_validation->set_rules('apellido_paterno_a','Apellido Paterno','required');
        $this->form_validation->set_rules('email_a','Correo Electrónico','required|valid_email');

        if($this->form_validation->run()==TRUE){
            $contacto->nombres=$this->input->post('nombres');
            //$contacto->apellido_paterno=$this->input->post('apellido_paterno');
            //$contacto->apellido_materno=$this->input->post('apellido_materno');
            $contacto->email=$this->input->post('email');
            $contacto->comentarios=$this->input->post('comentarios');
            //datos amigo
            $contacto->nombres_a=$this->input->post('nombres_a');
            //$contacto->apellido_paterno_a=$this->input->post('apellido_paterno_a');
            //$contacto->apellido_materno_a=$this->input->post('apellido_materno_a');
            $contacto->email_a=$this->input->post('email_a');

            $data['contacto']=$contacto;

            $this->email->from('chileatiende@chileatiende.gob.cl','ChileAtiende');
            $this->email->to($contacto->email_a);
            $this->email->subject($contacto->nombres_a.' tu amigo '.$contacto->nombres);
            $this->email->message($this->load->view('mails/amigo',$data,TRUE));
            $this->email->send();

            $respuesta->redirect=$this->input->server('HTTP_REFERER');
            $respuesta->validacion=TRUE;
        }else{
            $respuesta->validacion=FALSE;
            $respuesta->errores='<p class="alert">Los campos marcados con * son obligatorios</p>';
        }

        echo json_encode($respuesta);
    }


}
