<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Chileatiende extends CI_Controller {

    function __construct() {
        parent::__construct();

    }

    function index(){
        redirect(site_url(), 'location', 300);
    }
}