<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Evaluaciones extends CI_Controller {

    public function evaluar($ficha_id) {
        if (!$this->_can_evaluar($ficha_id)) {
            echo 'No puede votar';
            exit;
        }

        $this->form_validation->set_rules('rating', 'Rating', 'required|numeric');

        if ($this->form_validation->run() == TRUE) {
            $evaluacion = new Evaluacion();
            $evaluacion->rating = $this->input->post('rating');
            $evaluacion->Ficha = Doctrine::getTable('Ficha')->find($ficha_id);
            $evaluacion->save();

            //Actualizamos la cookie para que no vuelva a votar
            $evaluados = json_decode($this->input->cookie('evaluados'));
            if (!$evaluados || !in_array($evaluacion->Ficha->id, $evaluados)) {
                $evaluados[] = $evaluacion->Ficha->id;
                $cookie = array(
                    'name' => 'evaluados',
                    'value' => json_encode($evaluados),
                    'expire' => '3153600'
                );
            }

            $this->input->set_cookie($cookie);
        } else {
            echo validation_errors();
        }
    }

    function _can_evaluar($ficha_id) {
        $ficha = Doctrine::getTable('Ficha')->find($ficha_id);

        $evaluados = json_decode($this->input->cookie('evaluados'));

        if (!$evaluados || !in_array($ficha->id, $evaluados))
            return TRUE;

        return FALSE;
    }

}
