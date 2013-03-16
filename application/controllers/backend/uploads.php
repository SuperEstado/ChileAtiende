<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'application/third_party/file-uploader.php';

class Uploads extends CI_Controller {

    function __construct() {
        parent::__construct();

        if ($this->config->item('ssl'))
            force_ssl();

        UsuarioBackendSesion::checkLogin();

        if (!UsuarioBackendSesion::usuario()->tieneRol('mantenedor')) {
            echo 'No tiene permisos';
            exit;
        }
    }

    public function index() {
        $data['title'] = 'Backend - Uploads';
        $data['content'] = 'backend/uploads/index';

        $this->load->view('backend/template', $data);
    }

    function subirArchivo() {
        // list of valid extensions, ex. array("jpeg", "xml", "bmp")
        $allowedExtensions = array('jpeg', 'png', 'gif', 'jpg');
        // max file size in bytes
        $sizeLimit = 2 * 1024 * 1024;

        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload('assets/uploads/');

        // to pass data through iframe you will need to encode all html tags
        echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
    }

}