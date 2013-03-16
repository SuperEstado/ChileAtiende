<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Oficinas extends CI_Controller {

    public function ajax_load_infowindow($oficina_id) {

        $oficina=Doctrine::getTable('Oficina')->find($oficina_id);
        $data['oficina']=$oficina;

        $this->load->view('oficinas/ajax_load_infowindow', $data);
    }


    public function index($field='',$order='',$offset=0) {
        $options = array();
        $options['offset'] = $offset ? $offset : 0;
        $options['order_by'] = $field ? $field.' '.$order : 'o.sector_codigo ASC';
        $options['limit'] = 40;

        $oficinas = Doctrine::getTable('Oficina')->allOficinas($options);
        $noficinas = Doctrine::getTable('Oficina')->allOficinas(array('justCount'=>TRUE));

        $data['oficinas'] = $oficinas;
        $data['title'] = 'Oficinas';
        $data['content'] = 'oficinas/index';

        $orderby = $field ? $field.'/'.$order : 'o.sector_codigo/ASC';

        $this->pagination->initialize(array(
            'base_url' => site_url('oficinas/index/' . $orderby),
            'total_rows' => $noficinas,
            'per_page' => $options['limit'],
            'first_link' => 'Inicio',
            'last_link' => 'Último'
        ));

        $data['base_url'] = site_url('oficinas/index/' . $orderby);
        $data['per_page'] = $options['limit'];
        $data['offset'] = $options['offset'];
        $data['total'] = $noficinas;
        $data['order_by'] = $options['order_by'];

        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('template', $data);
    }

    function exporta($formato) {
        header('Content-Disposition: attachment; filename="oficinas-chileatiende.'.$formato.'"');
        header('Content-type: text/'.$formato);
        $query = Doctrine::getTable('Oficina')->findAll();
        echo $query->exportTo($formato);
    }

    function exportacsv() {
        $query = Doctrine::getTable('Oficina')->findAll();
        $aOficinas = $query->toArray();

        array_to_csv($aOficinas, 'oficinas-chileatiende.csv');
    }

}