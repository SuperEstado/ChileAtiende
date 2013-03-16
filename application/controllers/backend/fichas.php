<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Fichas extends CI_Controller {

    function __construct() {
        parent::__construct();

        if($this->config->item('ssl'))force_ssl();

        $this->user = UsuarioBackendSesion::usuario();
        UsuarioBackendSesion::checkLogin();
    }

    public function index($estado='',$flujos=FALSE) {
        if (!($this->user->tieneRol(array('editor', 'aprobador', 'publicador')) )) {
            echo 'No tiene permisos';
            exit;
        }

        $offset = $this->input->get('offset') ? $this->input->get('offset') : 0;
        $order_by = $this->input->get('order_by') ? $this->input->get('order_by') : 'f.id ASC';
        $per_page = 30;

        $entidad = UsuarioBackendSesion::getEntidad();
        $servicio = UsuarioBackendSesion::getServicio();

        $titulo = $this->input->post('titulo');
        $publico = $this->input->post('publico');

        $args = array('limit' => $per_page,
                        'offset' => $offset,
                        'order_by' => $order_by,
                        'estado' => $estado,
                        'titulo' => $titulo,
                        'publico' => $publico,
                        'flujos' => $flujos
                    );

        //argumentos para el contador
        $nargs = array('estado' => $estado,
                        'justCount' => TRUE,
                        'titulo' => $titulo,
                        'publico' => $publico,
                        'flujos' => $flujos
                      );

        $fichas = Doctrine::getTable('Ficha')->findMaestros($entidad, $servicio, $args);
        $nfichas = Doctrine::getTable('Ficha')->findMaestros($entidad, $servicio, $nargs);

        $data['title'] = 'Backend - '.( ($flujos)?'Flujos':'Fichas' );
        $data['content'] = 'backend/fichas/index';
        $data['fichas'] = $fichas;
        $data['flujos'] = $flujos;

        $this->pagination->initialize(array(
            'base_url' => site_url('backend/fichas/'.( ($flujos)?'listarflujos':'index' ).'/' . $estado . '?order_by=' . $order_by),
            'total_rows' => $nfichas,
            'per_page' => $per_page,
            'first_link' => 'Inicio',
            'last_link' => 'Último'
        ));

        $data['per_page'] = $per_page;
        $data['offset'] = $offset;
        $data['total'] = $nfichas;
        $data['order_by'] = $order_by;

        $this->load->view('backend/template', $data);
    }

    function listarflujos($estado='') {
        echo $this->index($estado,TRUE);
    }

    public function ver($id,$flujo=FALSE) {
        $ficha = Doctrine::getTable('Ficha')->find($id);
        $etapasvida = Doctrine::getTable('EtapaVida')->findAll();

        if (!$this->user->canAccessServicio($ficha->Servicio->codigo) ||
            !($this->user->tieneRol(array('editor', 'aprobador', 'publicador')))) {
            echo 'No tiene permisos';
            exit;
        }

        $data['ficha'] = $ficha;
        $data['etapasvida'] = $etapasvida;
        $data['flujo'] = $flujo;

        $data['title'] = 'Backend - Ver '.( ($flujo)?'Flujo ':'Ficha ' );
        $data['content'] = 'backend/fichas/ver';

        $this->load->view('backend/template', $data);
    }

    function verflujo($id) {
        echo $this->ver($id,TRUE);
    }

    public function versiones($id, $flujo=FALSE) {
        $ficha = Doctrine::getTable('Ficha')->find($id);

        if (!$this->user->canAccessServicio($ficha->Servicio->codigo) ||
            !($this->user->tieneRol(array('editor', 'aprobador', 'publicador')))) {
            echo 'No tiene permisos';
            exit;
        }

        $data['ficha'] = $ficha;
        $data['flujo'] = $flujo;

        $data['title'] = 'Backend - Ver '.( ($flujo)?'Flujo ':'Ficha ' );
        $data['content'] = 'backend/fichas/versiones';

        $this->load->view('backend/template', $data);
    }

    function versionesflujo($id) {
        echo $this->versiones($id, TRUE);
    }

    public function historial($id, $flujo=FALSE) {
        $ficha = Doctrine::getTable('Ficha')->find($id);

        if (!$this->user->canAccessServicio($ficha->Servicio->codigo) ||
            !($this->user->tieneRol(array('editor', 'aprobador', 'publicador')))) {
            echo 'No tiene permisos';
            exit;
        }

        $data['ficha'] = $ficha;
        $data['flujo'] = $flujo;

        $data['title'] = 'Backend - Ver '.( ($flujo)?'Flujo ':'Ficha ' );
        $data['content'] = 'backend/fichas/historial';

        $this->load->view('backend/template', $data);
    }

    function historialflujo($id) {
        echo $this->historial($id, TRUE);
    }

    public function agregar($flujo=FALSE) {
        if (!($this->user->tieneRol('editor'))) {
            echo 'No tiene permisos';
            exit;
        }

        $servicios = UsuarioBackendSesion::usuario()->getServiciosAccesibles();
        $temas = Doctrine::getTable('Tema')->findAll();
        $etapasvida = Doctrine::getTable('EtapaVida')->findAll();
        $rangos = Doctrine::getTable('RangoEdad')->findAll();
        $generos = Doctrine::getTable('Genero')->findAll();

        $data['title'] = 'Backend - Agregar '.( ($flujo)?'Flujo ':'Ficha ' );
        $data['content'] = 'backend/fichas/agregar';
        $data['servicios'] = $servicios;
        $data['temas'] = $temas;
        $data['etapasvida'] = $etapasvida;
        $data['rangos'] = $rangos;
        $data['generos'] = $generos;
        $data['flujo'] = $flujo;

        $this->load->view('backend/template', $data);
    }

    function agregarflujo() {
        echo $this->agregar(TRUE);
    }

    public function editar($id, $flujo=FALSE) {
        $ficha = Doctrine::getTable('Ficha')->find($id);

        if (!$this->user->canAccessServicio($ficha->Servicio->codigo) ||
            !($this->user->tieneRol('editor') && !$ficha->locked)) {
            echo 'No tiene permisos';
            exit;
        }

        $servicios = UsuarioBackendSesion::usuario()->getServiciosAccesibles();
        $temas = Doctrine::getTable('Tema')->findAll();
        $etapasvida = Doctrine::getTable('EtapaVida')->findAll();
        $generos = Doctrine::getTable('Genero')->findAll();

        $data['title'] = 'Backend - '.( ($flujo)?'Flujo ':'Ficha ' ) . $ficha->titulo;
        $data['content'] = 'backend/fichas/editar';
        $data['ficha'] = $ficha;
        $data['servicios'] = $servicios;
        $data['temas'] = $temas;
        $data['etapasvida'] = $etapasvida;
        $data['generos'] = $generos;
        $data['nombreform'] = ( ($flujo)?'editarflujo_form':'editar_form' );
        $data['flujo'] = $flujo;

        $this->load->view('backend/template', $data);
    }

    function editarflujo($id) {
        echo $this->editar($id, TRUE);
    }

    public function editar_ext($id, $flujo=FALSE) {
        $ficha = Doctrine::getTable('Ficha')->find($id);

        if (!$this->user->canAccessServicio($ficha->Servicio->codigo) ||
            !($this->user->tieneRol('publicador') )) {
            echo 'No tiene permisos';
            exit;
        }

        $servicios = Doctrine::getTable('Servicio')->findAll();
        $temas = Doctrine::getTable('Tema')->findAll();
        $etapasvida = Doctrine::getTable('EtapaVida')->findAll();
        $rangos = Doctrine::getTable('RangoEdad')->findAll();
        $generos = Doctrine::getTable('Genero')->findAll();

        $data['title'] = 'Backend - '.( ($flujo)?'Flujo ':'Ficha ' ) . $ficha->titulo;
        $data['content'] = 'backend/fichas/editar';
        $data['ficha'] = $ficha;
        $data['servicios'] = $servicios;
        $data['temas'] = $temas;
        $data['etapasvida'] = $etapasvida;
        $data['rangos'] = $rangos;
        $data['generos'] = $generos;
        $data['nombreform'] = ($flujo)?'editar_form_extflujo':'editar_form_ext';//'';
        $data['flujo'] = $flujo;

        $data['editar_ext']=TRUE;

        $this->load->view('backend/template', $data);
    }

    function editarflujo_ext($id) {
        echo $this->editar_ext($id, TRUE);
    }

    function agregar_form() {
        if (!($this->user->tieneRol('editor'))) {
            echo 'No tiene permisos';
            exit;
        }
        echo $this->_save_ficha();
    }

    function editar_form($id, $flujo=FALSE) {

        $ficha = Doctrine::getTable('Ficha')->find($id);
        if (!$this->user->canAccessServicio($ficha->Servicio->codigo) ||
            !( ( ($this->user->tieneRol('editor') ? '1' : '0') || $this->user->tieneRol('publicador') )
            && !($ficha->locked) ? '1' : '0' )) {
            echo 'No tiene permisos';
            exit;
        }
        echo ($flujo) ? $this->_save_flujo($id) : $this->_save_ficha($id);
    }

    function editarflujo_form($id) {
        echo $this->editar_flujo($id, TRUE);
    }

    function editar_form_ext($id, $flujo=FALSE) {

        $ficha = Doctrine::getTable('Ficha')->find($id);
        if (!$this->user->canAccessServicio($ficha->Servicio->codigo) ||
            !( $this->user->tieneRol('publicador') )) {
            echo 'No tiene permisos';
            exit;
        }
        echo $this->_save_ficha($id,$flujo);
    }

    function editar_form_extflujo($id){
        echo $this->editar_form_ext($id, TRUE);
    }

    function agregar_flujo() {
        if (!($this->user->tieneRol('editor'))) {
            echo 'No tiene permisos';
            exit;
        }
        echo $this->_save_flujo();
    }

    function editar_flujo($id) {
        $ficha = Doctrine::getTable('Ficha')->find($id);
        if (!$this->user->canAccessServicio($ficha->Servicio->codigo) ||
            !( ( ($this->user->tieneRol('editor') ? '1' : '0') || $this->user->tieneRol('publicador') )
            && !($ficha->locked) ? '1' : '0' )) {
            echo 'No tiene permisos';
            exit;
        }
        echo $this->_save_flujo($id);
    }

    function _save_flujo($id=null) {
        echo $this->_save_ficha($id, TRUE);
    }

    function _save_ficha($id = null, $flujo=FALSE) {

        if ($id) {
            try {
                $ficha = Doctrine::getTable('Ficha')->find($id);
            } catch (Exception $e) {

                $respuesta->validacion = FALSE;
                $respuesta->errores = "<p class='error'>" . $e . "</p>";
                return json_encode($respuesta);
            }
        } else {
            $ficha = new Ficha();
        }

        $this->form_validation->set_rules('titulo', 'Nombre del '.( ($flujo) ? 'flujo' : 'trámite' ) , 'trim|required');
        $this->form_validation->set_rules('objetivo', 'Descripción', 'trim|required');
        $this->form_validation->set_rules('servicio_codigo', 'Servicio', 'required|callback_check_servicio');
        $this->form_validation->set_rules('correlativo', 'Código', 'required|is_natural_no_zero|callback_check_codigo['.$id.']');
        $this->form_validation->set_rules('guia_online_url', 'Guia Online URL', 'trim|prep_url');

        if ($this->form_validation->run() == TRUE) {
            try {
                $comentarios = $this->input->post('comentario');
                $ficha->comentarios = json_encode($comentarios);
                $ficha->destacado = ($this->input->post('destacado')) ? 1 : 0;
                $ficha->correlativo=$this->input->post('correlativo');
                $ficha->titulo = $this->input->post('titulo');
                $ficha->alias = url_title(convert_accented_characters($this->input->post('titulo')), 'dash', TRUE);
                $ficha->objetivo = $this->input->post('objetivo');
                $ficha->beneficiarios = $this->input->post('beneficiarios');
                $ficha->costo = $this->input->post('costo');
                $ficha->vigencia = $this->input->post('vigencia');
                $ficha->marco_legal = $this->input->post('marco_legal');
                $ficha->plazo = $this->input->post('plazo');
                ////corresponde a información relacionada que pertenecía a los campos de ChileClic
                $ficha->cc_observaciones = $this->input->post('cc_observaciones');
                $ficha->doc_requeridos = $this->input->post('doc_requeridos');
                $ficha->guia_online = $this->input->post('guia_online');
                $ficha->guia_online_url = $this->input->post('guia_online_url');
                $ficha->guia_oficina = $this->input->post('guia_oficina');
                $ficha->guia_telefonico = $this->input->post('guia_telefonico');
                $ficha->guia_correo = $this->input->post('guia_correo');
                $ficha->maestro = 1;
                $ficha->servicio_codigo = $this->input->post('servicio_codigo');
                $ficha->genero_id = $this->input->post('genero')?$this->input->post('genero'):NULL;
                $ficha->diagramacion = $this->input->post('diagramacion'); //campo temporal
                $ficha->setRangosEdadFromString($this->input->post('rangos'));
                $ficha->setTemasFromArray($this->input->post('temas'));
                $ficha->setTagsFromArray($this->input->post('tags'));
                $ficha->setHechosVidaFromArray($this->input->post('hechosvida'));
                if( $this->input->post('keywords') )
                    $ficha->keywords = $this->input->post('keywords');
                if( $this->input->post('sic') )
                    $ficha->sic = $this->input->post('sic');
                $ficha->tipo = $this->input->post('tipo'); //1 personas, 2 empresas, 3 ambos
                $ficha->flujo = ($flujo) ? 1 : 0; //0 no flujo, 1 flujo

                $ficha->save();
                $ficha->generarVersion();

                if($id) {
                    $mensaje = ( ($flujo) ? 'Flujo' : 'Trámite' ).' actualizada exitosamente';
                } else {
                    $mensaje = ( ($flujo) ? 'Flujo' : 'Trámite' ).' creado exitosamente';
                }

                $this->session->set_flashdata('message', $mensaje);
                $respuesta->validacion = TRUE;
                $respuesta->redirect = site_url('backend/fichas/'.( ($flujo) ? 'verflujo' : 'ver' ).'/' . $ficha->id);
            } catch (Exception $e) {

                $respuesta->validacion = FALSE;
                $respuesta->errores = "<p class='error'>" . $e . "</p>";
                return json_encode($respuesta);
            }
        } else {
            $respuesta->validacion = FALSE;
            $respuesta->errores = validation_errors('<p class="error">', '</p>');
        }

        return json_encode($respuesta);
    }

    function aprobar($id, $flujo=FALSE) {
        $ficha = Doctrine::getTable('Ficha')->find($id);

        if (!$this->user->canAccessServicio($ficha->Servicio->codigo) ||
            !$this->user->tieneRol('aprobador')) {
            echo 'No tiene permisos';
            exit;
        }

        $ficha->aprobar();

        $aPublicadores = Doctrine::getTable('UsuarioBackend')->tipoUsuarios('publicador');
        //se envia a los usuarios con rol publicador anuncio de ficha para ser revisada.
        $publicadores = '';
        foreach($aPublicadores as $publicador) {
            $publicadores .= $publicador->email.',';
        }

        $this->email->from('chileatiende@chileatiende.gob.cl','ChileAtiende');
        $this->email->to( substr($publicadores, 0, -1) );
        $this->email->subject('Ficha '.$ficha->getCodigo().' para revisión Chile Atiende');
        $txt = ($flujo)?'El flujo ':'La ficha ';
        $this->email->message( $txt.' <a href="'.site_url('backend/fichas/ver/' . $ficha->id).'">'.$ficha->getCodigo().'</a> de '.$ficha->Servicio->nombre.' fue enviada para revisión al equipo Chile Atiende.');

        if( ! $this->email->send() ) {
            $this->session->set_flashdata('message', ( ($flujo)?'El flujo ha sido enviado a revisión pero no se ha notificado via email.':'La ficha ha sido enviada a revisión pero no se ha notificado via email.' ));
        } else {
            $this->session->set_flashdata('message', ( ($flujo)?'El flujo ha sido enviado a revisión.':'La ficha ha sido enviada a revisión.' ));
        }

        redirect('backend/fichas/'.( ($flujo)?'verflujo':'ver' ).'/' . $id);
    }

    function aprobarflujo($id) {
        echo $this->aprobar($id, TRUE);
    }

    function rechazar($id, $flujo=FALSE) {
        $ficha = Doctrine::getTable('Ficha')->find($id);

        if (!$this->user->canAccessServicio($ficha->Servicio->codigo) ||
            !$this->user->tieneRol('publicador')) {
            echo 'No tiene permisos';
            exit;
        }

        $ficha->estado_justificacion = $this->input->post('estado_justificacion');
        $ficha->rechazar();

        $this->session->set_flashdata('message', ( ($flujo)?'El flujo ha sido rechazado.':'La ficha ha sido rechazada.' ).'');

        redirect('backend/fichas/'.( ($flujo)?'verflujo':'ver' ).'/' . $id);
    }

    function rechazarflujo($id) {
        echo $this->rechazar($id, TRUE);
    }

    function publicar($ficha_id, $flujo=FALSE) {
        $ficha = Doctrine::getTable('Ficha')->find($ficha_id);

        if (!$this->user->canAccessServicio($ficha->Servicio->codigo) ||
            !$this->user->tieneRol('publicador')) {
            echo 'No tiene permisos';
            return;
        }

        $ficha->publicar();

        $this->session->set_flashdata('message', ( ($flujo)?'El flujo ha sido publicado exitósamente':'La ficha ha sido publicada exitósamente' ));

        redirect('backend/fichas/'.( ($flujo)?'verflujo':'ver' ).'/' . $ficha_id);
    }

    function publicarflujo($id) {
        echo $this->publicar($id, TRUE);
    }

    function despublicar($ficha_id, $flujo=FALSE) {
        $ficha = Doctrine::getTable('Ficha')->find($ficha_id);

        if (!$this->user->canAccessServicio($ficha->Servicio->codigo) ||
            !$this->user->tieneRol('publicador')) {
            echo 'No tiene permisos';
            return;
        }

        $ficha->despublicar();

        $this->session->set_flashdata('message', ( ($flujo)?'El flujo ha sido despublicado':'La ficha ha sido despublicada' ));

        redirect('backend/fichas/'.( ($flujo)?'verflujo':'ver' ).'/' . $ficha_id);
    }

    function despublicarflujo($id) {
        echo $this->despublicar($id, TRUE);
    }

    function eliminar($ficha_id, $flujo=FALSE) {
        $ficha = Doctrine::getTable('Ficha')->find($ficha_id);

        if (!$this->user->canAccessServicio($ficha->Servicio->codigo) ||
            !($this->user->tieneRol('editor') && !$ficha->publicado)) {
            echo 'No tiene permisos';
            return;
        }

        $ficha->delete();
        redirect('backend/fichas'.(($flujo)?'/listarflujos':''));
    }

    function eliminarflujo($id) {
        echo $this->eliminar($id, TRUE);
    }

    //Chequea que un usuario puede usar este servicio (institucion)
    public function check_servicio($servicio_codigo) {
        if ($this->user->canAccessServicio($servicio_codigo))
            return TRUE;

        $this->form_validation->set_message('check_servicio', 'No tiene permisos para asignar esta institución');
        return FALSE;
    }

    function toptenrating() {

        $fichas = Doctrine::getTable('Ficha')->masVotadas( array('limit' => 10) );

        $data['title'] = 'Backend - Fichas';
        $data['content'] = 'backend/fichas/rating';
        $data['fichas'] = $fichas;

        $this->load->view('backend/template', $data);
    }

    function previsualizar($idFicha, $flujo=FALSE) {

        //$ficha=Doctrine::getTable('Ficha')->find($idFicha);
        $ficha = Doctrine::getTable('Ficha')->findPublicado($idFicha);

        if (!$this->user->canAccessServicio($ficha[0]->Servicio->codigo) ||
            !($this->user->tieneRol(array('editor', 'aprobador', 'publicador')))) {
            echo 'No tiene permisos';
            exit;
        }

        $data['ficha'] = $ficha[0];
        $data['flujo'] = $flujo;

        $data['title'] = 'Backend - Previsualizar ';
        $data['content'] = 'backend/fichas/previsualizar';

        $this->load->view('backend/previsualizar', $data);
    }

    function previsualizarflujo($id) {
        echo $this->previsualizar($id, TRUE);
    }

    function datatable($estado='') {
        $offset = $this->input->get('offset') ? $this->input->get('offset') : 0;
        $order_by = $this->input->get('order_by') ? $this->input->get('order_by') : 'f.id ASC';
        $per_page = 30;

        $entidad = UsuarioBackendSesion::getEntidad();
        $servicio = UsuarioBackendSesion::getServicio();

        $fichas = Doctrine::getTable('Ficha')->findMaestros($entidad, $servicio, array('offset' => $offset,
            'order_by' => $order_by, 'estado' => $estado));

        $aData = array();
        foreach ($fichas as $ficha) {
            $estado0 = '';
            $estado1 = '';
            $estado2 = '';

            $estado0 = $ficha->publicado ? '<span style="display:none">A</span><img src="assets/images/backend/tick.png" alt="Publicado" title="Publicado" />' : anchor("backend/fichas/publicar/" . $ficha->id, '<span style="display:none">B</span><img src="assets/images/backend/cross.png" alt="No Publicado" title="No Publicado" />');

            if (count($ficha->Temas) == 0 || count($ficha->HechosVida) == 0) {
                $estado1 = '<span style="display:none">A</span><a alt="Atención. Esta ficha no tiene asociado un Tema y/o un Hecho de Vida" title="Atención. Esta ficha no tiene asociado un Tema y/o un Hecho de Vida" href="' . site_url('backend/fichas/ver/' . $ficha->id) . '"><img src="assets/images/backend/exclamation.png" /></a>';
            }
            if ($ficha->actualizable) {
                $estado2 = '<span style="display:none">A</span><a alt="Atención. Esta ficha no está publicada en su última versión." title="Atención. Esta ficha no está publicada en su última versión." href="' . site_url('backend/fichas/ver/' . $ficha->id) . '"><img src="assets/images/backend/arrow_join.png" /></a>';
            }

            $aData[] = array(
                'id' => $ficha->id,
                'titulo' => '<a href="' . site_url('backend/fichas/ver/' . $ficha->id) . '">' . $ficha->titulo . '</a>',
                'estado0' => $estado0,
                'estado1' => $estado1,
                'estado2' => $estado2,
                'actualizado' => $ficha->updated_at,
                'acciones' => '<a title="' . $ficha->titulo . '" href="' . site_url('backend/fichas/editar/' . $ficha->id) . '"><img src="assets/images/backend/pencil.png" title="Editar" /></a><a href="' . site_url('backend/fichas/eliminar/' . $ficha->id) . '" onclick="return confirm(\'¿Está seguro que desea eliminar esta Ficha?\')"><img src="assets/images/backend/delete.png" alt="Eliminar" /></a>'
            );
        }
        //debug($aData);
        echo '{ "aaData":' . json_encode($aData) . '}';
    }

    function compara($idFicha, $flujo=FALSE) {
        //$ficha=Doctrine::getTable('Ficha')->find($idFicha);
        $ficha = Doctrine::getTable('Ficha')->find($idFicha);

        if (!$this->user->canAccessServicio($ficha->Servicio->codigo) ||
            !($this->user->tieneRol(array('editor', 'aprobador')))) {
            echo 'No tiene permisos';
            exit;
        }

        $data['ficha'] = $ficha;
        $data['flujo'] = $flujo;

        $data['title'] = 'Backend - Previsualizar ';
        $data['content'] = 'backend/fichas/previsualizar';

        $this->load->view('backend/previsualizar', $data);
    }

    function comparaflujo($id) {
        echo $this->compara($id, TRUE);
    }

    function ajax_ficha_comparar($ficha1_id, $ficha2_id) {

        if($ficha1_id > $ficha2_id){
            $ficha1 = Doctrine::getTable('Ficha')->find($ficha1_id);
            $ficha2 = Doctrine::getTable('Ficha')->find($ficha2_id);
        }else{
            $ficha1 = Doctrine::getTable('Ficha')->find($ficha2_id);
            $ficha2 = Doctrine::getTable('Ficha')->find($ficha1_id);
        }

        if (!$this->user->canAccessServicio($ficha1->Servicio->codigo)
            || !$this->user->canAccessServicio($ficha2->Servicio->codigo)) {
            echo 'No tiene permisos para realizar esta acción.';
            exit;
        }

        $data['left'] = $ficha1;
        $data['right'] = $ficha2;
        $data['title'] = 'Backend - Comparar ' . $ficha1->id . ' < > ' . $ficha2->id;
        $data['content'] = 'backend/fichas/ajax_ficha_comparar';
        //$data['comparacion'] = $dataset1->compareWith($dataset2);

        $this->load->view('backend/comparar', $data);
    }

    function ajax_generar_codigo($servicio_dueno) {
        $proyecto = Doctrine_Query::create()
                        ->from('Ficha p')
                        ->select('MAX(p.correlativo) as max_correlativo')
                        ->where('p.servicio_codigo = ?', $servicio_dueno)
                        ->fetchOne();

        echo $proyecto->max_correlativo + 1;
    }

    function check_codigo($correlativo, $id) {
        $servicio_codigo = $this->input->post('servicio_codigo');
        $borrador = Doctrine::getTable('Ficha')->findOneByServicioCodigoAndCorrelativoAndMaestro($servicio_codigo, $correlativo, 1);
        //print_r($borrador->id);
        if (!$borrador)
            return TRUE;
        if($borrador && $borrador->id==$id)
            return TRUE;

        $this->form_validation->set_message('check_codigo', 'Ya existe una ficha ingresado con ese código.');
        return false;
    }
    
    function stats($idFicha,$flujo=FALSE) {
        $ficha = Doctrine::getTable('Ficha')->find($idFicha);
        
        if (!$this->user->canAccessServicio($ficha->Servicio->codigo) ||
            !($this->user->tieneRol(array('editor', 'aprobador', 'publicador')))) {
            echo 'No tiene permisos';
            exit;
        }

        $fecha = Doctrine_Query::create()
                        ->from('Hit')
                        ->select('MIN(fecha) AS mindate')
                        ->where('ficha_id = ?', $idFicha)
                        ->fetchOne();
        
        $aStats = Doctrine::getTable('Hit')->findByFichaId($idFicha);
        $data = array();
        
        $data['title'] = 'Backend - Estadísticas ';
        $data['content'] = 'backend/fichas/stats';
        $data['stats'] = $aStats;
        $data['fecha'] = $fecha;
        
        $data['ficha'] = $ficha;
        $data['flujo'] = $flujo;
        
        $this->load->view('backend/template', $data);
    }
    
    function statsflujo($idFicha) {
        $this->stats($idFicha,TRUE);
    }

}