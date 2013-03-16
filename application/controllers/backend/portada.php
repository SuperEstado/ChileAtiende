<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Portada extends CI_Controller {

    function __construct() {
        parent::__construct();

        if ($this->config->item('ssl'))
            force_ssl();

        UsuarioBackendSesion::checkLogin();
    }

    public function index() {
        $data['title'] = 'Portada Backend';
        $data['content'] = 'backend/portada/index';

        //$this->output->cache(1);
        $this->load->view('backend/template', $data);
    }

    public function topten($tipo) {
        header('Content-Disposition: attachment; filename="topten_' . $tipo . '_' . date('dmY') . '.csv"');
        header('Content-type: text/csv');

        switch ($tipo) {
            case 'votadas':
                $options['fields'] = 'maestro_id, titulo';

                $query = Doctrine::getTable('Ficha')->MasVotadas($options);
                $aData = $query;

                //armamos el archivo
                echo 'id;maestro_id;titulo;rating;nro votos' . "\r\n";
                foreach ($aData as $data) {
                    echo $data->id . ';' . $data->maestro_id . ';' . $data->titulo . ';' . $data->rating . ';' . $data->nrating . "\r\n";
                }

                break;
            case 'vistas':
                $options['fields'] = 'maestro_id, titulo';

                $query = Doctrine::getTable('Ficha')->MasVistas($options);
                $aData = $query;

                //armamos el archivo
                echo 'id;maestro_id;titulo;total' . "\r\n";
                foreach ($aData as $data) {
                    echo $data->id . ';' . $data->maestro_id . ';' . $data->titulo . ';' . $data->total . "\r\n";
                }

                break;
            case 'servicios':
                $query = Doctrine::getTable('Ficha')->findNroFichasOnServicios();
                $aData = $query;

                //armamos el archivo
                echo 'servicio;nro_fichas' . "\r\n";
                foreach ($aData as $data) {
                    echo $data->Servicio->nombre . ';' . $data->cnt . "\r\n";
                }

                break;
            case 'masbuscados':
                $query = Doctrine::getTable('SearchLog')->getMasBuscados();
                $aData = $query;

                //armamos el archivo
                echo 'frase;nro_busquedas' . "\r\n";
                foreach ($aData as $data) {
                    echo $data->search_query . ';' . $data->cnt . "\r\n";
                }

                break;
        }
    }

}
