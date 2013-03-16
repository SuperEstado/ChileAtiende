<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Autenticacion extends CI_Controller {
    public function  __construct() {
        parent::__construct();

        if($this->config->item('ssl'))force_ssl();
    }



    public function login() {

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_verificaUsuario');
        $this->form_validation->set_rules('password', 'Contrase&ntilde;a', 'required');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run() == TRUE) {

            redirect('backend/portada');
        }

        $this->load->view('backend/autenticacion/login');
    }

    function verificaUsuario() {
        $usuario = Doctrine::getTable('UsuarioBackend')->findOneByEmail($this->input->post('email'));
        
        if( isset($usuario) && $usuario && $usuario->activo ) {
            if( UsuarioBackendSesion::login($this->input->post('email'),$this->input->post('password')) )
                return true;
        }
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_message('verificaUsuario', 'Usuario y/o Contrase&ntilde;a incorrecta');
        
        return false;
    }

    function logout() {
        UsuarioBackendSesion::logout();
        redirect('backend/autenticacion/login');
    }

    function forgot_password() {
        $this->form_validation->set_rules('email', 'E-Mail', 'required|callback_check_existe_usuario');

        if ($this->form_validation->run() == TRUE) {
            $email=$this->input->post('email');
            $usuario=Doctrine::getTable('UsuarioBackend')->findOneByEmail($email);

            $encrypted_email=base64_encode($email);
            $this->email->from('datos@modernizacion.gob.cl');
            $this->email->to($email);
            $this->email->subject('Reestablecimiento de contraseña');
            $this->email->message('Estimado(a) '.$usuario->nombres.' se ha hecho una solicitud de recuperación de contraseña, para confirmar su identidad haga click en el enlace que se indica a continuación y le enviaremos su contraseña. Si ud. no ha hecho esta solicitud ignore o elimine este mensaje.<br />'.site_url('autenticacion/reset_password/'.$encrypted_email));
            $this->email->send();

            $this->session->set_flashdata('message', 'Se ha enviado un mensaje a la dirección de correo electrónico indicada con instrucciones para restaurar su contraseña.');
            redirect('backend/autenticacion/login');
        }

        $this->load->view('backend/autenticacion/forgot_password');
    }

    function reset_password($encrypted_email) {
        $email=  base64_decode($encrypted_email);
        $usuario = Doctrine::getTable('UsuarioBackend')->find($email);
        $newpassword = strtolower(random_string('alnum', 8));
        $usuario->password = $newpassword;
        $usuario->save();

        $this->email->from('datos@modernizacion.gob.cl');
        $this->email->to($usuario->email);
        $this->email->subject('Reestablecimiento de contraseña');
        $this->email->message('Estimado(a) '.$usuario->nombres.' su solicitud de recuperación de contraseña ha concluido exitosamente. Su contraseña es: ' . $newpassword);
        $this->email->send();

        $this->session->set_flashdata('message', 'Contraseña Activada. se le ha enviado un correo electrónico con su contraseña.');
        redirect('autenticacion/login');
    }

    function check_existe_usuario($email) {
        //echo $email;
        $usuario = Doctrine::getTable('UsuarioBackend')->findOneByEmail($email);
        //print_r($usuario);
        if ($usuario)
            return TRUE;

        $this->form_validation->set_message('check_existe_usuario', 'E-Mail incorrecto.');
        return FALSE;
    }

    function check_password($password){
        $email=$this->input->post('email');
        $administrador=Doctrine::getTable('UsuarioBackend')->findOneByEmail($email);

        $administrador_input=new Usuario();
        $administrador_input->password=$password;
        
        if($administrador && $administrador->password==$administrador_input->password)
            return TRUE;

        $this->form_validation->set_message('check_password','Usuario y/o contraseña incorrecta.');
        return false;
        
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
