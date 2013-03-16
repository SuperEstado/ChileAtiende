<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sectores extends CI_Controller {

    public function ajax_get_info($sector_id) {

        $sector=Doctrine::getTable('Sector')->find($sector_id);

        echo json_encode($sector->toArray());

    }


    

}