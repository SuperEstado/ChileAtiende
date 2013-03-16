<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class iframe extends CI_Controller{
    
    function __construct() {
        parent::__construct();
    }
    
    function index($id){

        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        $this->session->set_userdata('oficina', $id);
        redirect('funcionarios/');
        
    }
    
}

?>
