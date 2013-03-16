<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mantenimiento extends CI_Controller {

    function __construct() {
        parent::__construct();

        if($this->config->item('ssl'))force_ssl();

        UsuarioBackendSesion::checkLogin();

        if (!UsuarioBackendSesion::usuario()->tieneRol('mantenedor')) {
            echo 'No tiene permisos';
            exit;
        }
    }

    function index() {

        $data['title'] = 'Mantenimiento';
        $data['content'] = 'backend/mantenimiento/index';
        $this->load->view('backend/template', $data);
    }

    //Les genera una primera version a los proyectos que no tienen una. (Proyectos que fueron
    //cargados directo por BD y no por el sistema)
    function generar_versiones() {
        //ini_set('memory_limit', '512M');

        $fichas = Doctrine_Query::create()
            ->from('Ficha p, p.Versiones v')
            ->select('p.id, COUNT(v.id) as nversiones')
            ->groupBy('p.id')
            ->having('nversiones = 0')
            ->where('p.maestro = 1')
            ->setHydrationMode(Doctrine::HYDRATE_ON_DEMAND)
            ->execute();

        //print_r($proyectos->toArray());
        //exit;

        foreach ($fichas as $p)
            $p->generarVersion();

        $this->session->set_flashdata('message', 'Generador de versiones finalizado con éxito.');
        redirect('backend/mantenimiento');
    }

    //Funcion que toma todas las fichas maestro, y les asigna un correlativo por servicio.
    //Con esto se pueden generar los codigos de tramite de la forma: servicio-correlativo
    //Ej: AA001-1
    //Nota: Quitar el $this->actAs('Timestampable') en el modelo Ficha, para que no se actualizen los timestamps.
    function generar_correlativos(){
        ini_set('memory_limit', '1024M');

        $servicios=Doctrine::getTable('Servicio')->findAll();
        foreach($servicios as $s){
            $correlativo=1;
            foreach($s->Fichas as $f){
                if($f->maestro){
                    $f->correlativo=$correlativo;
                    $f->save();
                    foreach($f->Versiones as $v){
                        $v->correlativo=NULL;
                        $v->save();
                    }
                    $correlativo++;
                }
            }
        }
    }

    /* Asistente que pérmite exportar xml de ChileClic
     */

    function wizard() {
        $entidad = UsuarioBackendSesion::getEntidad();
        $servicio = UsuarioBackendSesion::getServicio();

        $servicios = Doctrine::getTable('Servicio')->findServicios($entidad, $servicio, array());

        $usuarios = Doctrine::getTable('UsuarioBackend')->todosUsuarios(array('activos' => 1));

        $data['title'] = 'Wizard';
        $data['content'] = 'backend/mantenimiento/wizard';
        $data['usuarios'] = $usuarios;
        $data['servicios'] = $servicios;

        $this->load->view('backend/template', $data);
    }

    function wizard_paso01_path() {
        //mala onda! tengo un notice que no logré eliminar, así que hice la pillería de deshabilitar todos los errores XD
        //hay que revisar esto del notice para que quede más optimo el codigo.
        //error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $ruta = $this->input->post('path');

        $db_origen = $this->input->post('db_origen');
        $db_destino = $this->input->post('db_destino');

        $db_user = $this->input->post('user');
        $db_pass = $this->input->post('pass');

        $this->connect($db_user, $db_pass, $db_destino);

        $usuario = ($_POST['usuario']) ? $_POST['usuario'] : '3'; //id 3 corresponde al usuario administrador
        $sel_institucion = ($_POST['institucion']) ? $_POST['institucion'] : '';
        $fecha = date('Y-m-d H:i:s');
        $error = '';

        $file_exceptions = array('.', '..', 'chileclic-tramite-xhtml.xsl', 'doewa.xsl', 'tramites.xml');

        if ($gestor = opendir($ruta)) {

            while (false !== ($archivo = readdir($gestor))) {

                if (!in_array($archivo, $file_exceptions)) {

                    $xml = $this->xmlParser($ruta, $archivo);

                    //obtenemos el codigo sgs
                    $query_inst = "SELECT codigo_sgs FROM chileclic141011.institucion WHERE codigo LIKE '" . $xml['codigo'] . "'";
                    $res = $this->get($query_inst);
                    $codigo_sgs = $res['codigo_sgs'];

                    //si no obtenemos el codigo, no insertamos y arrojamos un alerta para revisar manualmente
                    if ($codigo_sgs) {
                        //verificamos si la institucion seleccionada, corresponde con la institucion del xml
                        if (empty($sel_institucion) || $sel_institucion == $codigo_sgs) {

                            /* SE GENERA MAESTRO CON DATOS BASE */

                            //se genera la primera version en la DB de las fichas traidas desde ChileClic

                            $insert_maestro = Array(
                                "maestro" => 1,
                                "publicado" => 1,
                                "publicado_at" => "NULL",
                                "locked" => 0,
                                "estado" => "NULL",
                                "estado_justificacion" => "NULL",
                                "actualizable" => "NULL",
                                "destacado" => 0,
                                "rating" => "NULL",
                                "genero_id" => "NULL",
                                "comentarios" => " '' ",
                                "tipo" => 0,
                                "fichacol" => " '' ",
                                "servicio_codigo" => "'$codigo_sgs'",
                                "diagramacion" => 1,
                                "created_at" => "'$fecha'",
                                "updated_at" => "'$fecha'"
                            );

                            $q_insert_padre = "INSERT INTO " . $db_destino . ".ficha ";
                            $q_insert_padre .= "(" . implode(",", array_keys($insert_maestro)) . ")";
                            $q_insert_padre .= " VALUES ";
                            $q_insert_padre .= "(" . implode(",", $insert_maestro) . ")";

                            $this->execute($q_insert_padre);
                            $id_padre = mysql_insert_id();

                            $insert_clon = Array(
                                "titulo" => "'" . $xml['titulo'] . "'",
                                "objetivo" => "'<b>Descripción:</b><br/>" . $xml['descripcion'] . " <br /><b>En que consiste:</b><br/>" . $xml['procedimiento'] . "'",
                                "beneficiarios" => "'Para quién: " . $xml['para-quien'] . " <br />A quién esta dirigido: " . $xml['destinatarios'] . " <br />Requisitos: " . $xml['requisitos'] . "'",
                                "costo" => "'" . $xml['costo'] . "'",
                                "vigencia" => "NULL",
                                "plazo" => "'" . $xml['plazo'] . "'",
                                "guia_online" => "'Dónde se realiza: " . $xml['donde'] . " <br /> Resultado: " . $xml['resultado'] . "'",
                                "guia_online_url" => "'" . $xml['enlinea'] . "'",
                                "doc_requeridos" => "'" . $xml['documentos'] . "'",
                                "maestro" => 0,
                                "publicado" => 0,
                                "servicio_codigo" => "'" . $codigo_sgs . "'",
                                "cc_observaciones" => "'" . $xml['observaciones'] . "'",
                                "cc_id" => "'" . $xml['idxml'] . "'",
                                "cc_formulario" => "'" . $xml['formulario'] . "'",
                                "cc_llavevalor" => "'" . $xml['llavevalor'] . "'",
                                "maestro_id" => "'" . $id_padre . "'",
                                "created_at" => "'" . $fecha . "'",
                                "updated_at" => "'" . $fecha . "'"
                            );

                            $q_insert_clon = "INSERT INTO " . $db_destino . ".ficha ";
                            $q_insert_clon .= "(" . implode(",", array_keys($insert_clon)) . ")";
                            $q_insert_clon .= " VALUES ";
                            $q_insert_clon .= "(" . implode(",", $insert_clon) . ")";

                            $this->execute($q_insert_clon);
                            $id_clon = mysql_insert_id();

                            /* GENERAMOS HISTORIAL */
                            $q_historial = 'INSERT INTO ' . $db_destino . '.historial (ficha_id, ficha_version_id, usuario_backend_id, created_at, updated_at, descripcion)
                                            VALUES (' . $id_padre . ',' . $id_clon . ',' . $usuario . ',"' . $fecha . '", "' . $fecha . '", "<p>Se ha creado la ficha</p>")';

                            $this->execute($q_historial);

                            $q_maestro = 'SELECT * FROM ' . $db_origen . '.ficha WHERE maestro=1 AND cc_id LIKE "' . $xml['idxml'] . '"';
                            $aDatos = $this->get($q_maestro);

                            //validamos que exista una version en la db de origen
                            if ($aDatos['id']) {

                                //insertamos la ficha ya diagramada
                                $q_insertDiagramada = 'INSERT INTO ' . $db_destino . '.ficha (titulo, alias, objetivo, beneficiarios, costo, vigencia, plazo,
                                guia_online, guia_online_url, guia_oficina, guia_telefonico, guia_correo, marco_legal, doc_requeridos, maestro, publicado,
                                publicado_at, locked, estado, estado_justificacion, actualizable, destacado, servicio_codigo, created_at, updated_at,
                                maestro_id, rating, genero_id, convenio, diagramacion, cc_observaciones, cc_id, cc_formulario, cc_llavevalor, fichacol,
                                comentarios, tipo)
                                VALUES ( "' . mysql_real_escape_string($aDatos['titulo']) . '",
                                    "' . mysql_real_escape_string($aDatos['alias']) . '",
                                    "' . mysql_real_escape_string($aDatos['objetivo']) . '",
                                    "' . mysql_real_escape_string($aDatos['beneficiarios']) . '",
                                    "' . mysql_real_escape_string($aDatos['costo']) . '",
                                    "' . mysql_real_escape_string($aDatos['vigencia']) . '",
                                    "' . mysql_real_escape_string($aDatos['plazo']) . '",
                                    "' . mysql_real_escape_string($aDatos['guia_online']) . '",
                                    "' . mysql_real_escape_string($aDatos['guia_online_url']) . '",
                                    "' . mysql_real_escape_string($aDatos['guia_oficina']) . '",
                                    "' . mysql_real_escape_string($aDatos['guia_telefonico']) . '",
                                    "' . mysql_real_escape_string($aDatos['guia_correo']) . '",
                                    "' . mysql_real_escape_string($aDatos['marco_legal']) . '",
                                    "' . mysql_real_escape_string($aDatos['doc_requeridos']) . '",
                                    "0",
                                    "1",
                                    NULL,
                                    "0",
                                    NULL,
                                    NULL,
                                    "0",
                                    "0",
                                    "' . mysql_real_escape_string($codigo_sgs) . '",
                                    "' . mysql_real_escape_string($fecha) . '",
                                    "' . mysql_real_escape_string($fecha) . '",
                                    "' . $id_padre . '",
                                    "0",
                                    NULL,
                                    "0",
                                    "1",
                                    "' . mysql_real_escape_string($aDatos['cc_observaciones']) . '",
                                    "' . mysql_real_escape_string($aDatos['cc_id']) . '",
                                    "' . mysql_real_escape_string($aDatos['cc_formulario']) . '",
                                    "' . mysql_real_escape_string($aDatos['cc_llavevalor']) . '",
                                    "",
                                    "",
                                    0
                                )';

                                $this->execute($q_insertDiagramada);
                                $id_diagramada = mysql_insert_id();

                                $q_historial = 'INSERT INTO ' . $db_destino . '.historial (ficha_id, ficha_version_id, usuario_backend_id, created_at, updated_at, descripcion)
                                            VALUES (' . $id_padre . ',' . $id_diagramada . ',' . $usuario . ',"' . $fecha . '", "' . $fecha . '", "<p>Se ha creado la ficha diagramada</p>")';
                                $this->execute($q_historial);

                                /* ACTUALIZAR MAESTRO USANDO FICHA DIAGRAMADA */

                                $q_updateFichaMaestro = 'UPDATE ' . $db_destino . '.ficha SET
                                titulo="' . mysql_real_escape_string($aDatos['titulo']) . '",
                                alias="' . mysql_real_escape_string($aDatos['alias']) . '",
                                objetivo="' . mysql_real_escape_string($aDatos['objetivo']) . '",
                                beneficiarios="' . mysql_real_escape_string($aDatos['beneficiarios']) . '",
                                costo="' . mysql_real_escape_string($aDatos['costo']) . '",
                                vigencia="' . mysql_real_escape_string($aDatos['vigencia']) . '",
                                plazo="' . mysql_real_escape_string($aDatos['plazo']) . '",
                                guia_online="' . mysql_real_escape_string($aDatos['guia_online']) . '",
                                guia_online_url="' . mysql_real_escape_string($aDatos['guia_online_url']) . '",
                                guia_oficina="' . mysql_real_escape_string($aDatos['guia_oficina']) . '",
                                guia_telefonico="' . mysql_real_escape_string($aDatos['guia_telefonico']) . '",
                                guia_correo="' . mysql_real_escape_string($aDatos['guia_correo']) . '",
                                marco_legal="' . mysql_real_escape_string($aDatos['marco_legal']) . '",
                                doc_requeridos="' . mysql_real_escape_string($aDatos['doc_requeridos']) . '",
                                convenio ="' . mysql_real_escape_string($aDatos['convenio']) . '",
                                cc_observaciones = "' . mysql_real_escape_string($aDatos['cc_observaciones']) . '",
                                cc_id = "' . mysql_real_escape_string($aDatos['cc_id']) . '",
                                cc_formulario = "' . mysql_real_escape_string($aDatos['cc_formulario']) . '",
                                cc_llavevalor = "' . mysql_real_escape_string($aDatos['cc_llavevalor']) . '"
                                WHERE id = ' . $id_padre;

                                $this->execute($q_updateFichaMaestro);

                            } else {

                                $aux = array();
                                $q_updateFichaMaestro = 'UPDATE ' . $db_destino . '.ficha SET ';
                                $insert_clon['publicado'] = 1;
                                $insert_clon['maestro'] = 1;
                                $insert_clon['maestro_id'] = 'NULL';
                                foreach ($insert_clon as $key => $value) {
                                    $aux[] = $key . "=" . $value;
                                }
                                $q_updateFichaMaestro .= "" . implode(",", $aux) . "";
                                $q_updateFichaMaestro .= 'WHERE id = ' . $id_padre;
                                //debug($q_updateFichaMaestro);

                                $this->execute($q_updateFichaMaestro);
                                $this->execute("UPDATE $db_destino.ficha SET publicado = 1 WHERE id = $id_clon");

                            }
                            //fin DB
                        }//fin validacion institucion
                    } else {
                        //si el xml no está asociado a la tabla que hace la conversion de codigo ChileClic con SGS, avisamos.
                        $error .= '<li>Advertencia! El archivo ' . $archivo . ' tuvo problemas en el proceso de importación, no fue posible obtener codigo SGS, rogamos verificar manualmente</li>';
                    }
                }//end if
            }//end while
        } else {
            debug("NOT ABLE TO OPEN PATH");
        }


        $entidad = UsuarioBackendSesion::getEntidad();
        $servicio = UsuarioBackendSesion::getServicio();

        $servicios = Doctrine::getTable('Servicio')->findServicios($entidad, $servicio, array());

        $usuarios = Doctrine::getTable('UsuarioBackend')->todosUsuarios(array('activos' => 1));

        $data['title'] = 'Wizard';
        $data['content'] = 'backend/mantenimiento/enhorabuena';
        $data['usuarios'] = $usuarios;
        $data['servicios'] = $servicios;
        $data['errores'] = $error;

        $this->load->view('backend/template', $data);
    }

    function xmlParser($ruta, $archivo) {

        $doc = new DOMDocument;
        $doc->load($ruta . '/' . $archivo);

        //definimos variables
        $dataA = Array(
            "titulo" => "",
            "fecha" => "",
            "institucion" => "",
            "temas" => ""
        );

        $dataB = Array(
            "nombre" => "",
            "telefono" => "",
            "email" => "",
            "website" => "",
            "descripcion" => "",
            "para-quien" => "",
            "enlinea" => "",
            "info" => "",
            "formulario" => "",
            "contacto" => "",
            "procedimiento" => "",
            "destinatarios" => "",
            "requisitos" => "",
            "documentos" => "",
            "costo" => "",
            "donde" => "",
            "plazo" => "",
            "resultado" => "",
            "observaciones" => "",
            "llavenombre" => "",
            "llavevalor" => ""
        );

        //$terNivel = "";
        //$segNivel = "";
        //fin definicion variables

        for ($x = 0; $x < $doc->childNodes->length; $x++) {

            //se obtiene id de xml
            $dataC['idxml'] = $doc->childNodes->item($x)->attributes->getNamedItem("id")->nodeValue;

            //obtengo hijos del nodo
            $segNivel = $doc->childNodes->item($x)->childNodes;
            if ($segNivel)
                for ($y = 0; $y < $segNivel->length; $y++) {
                    #Defino el prefijo
                    $prefix = (substr($segNivel->item($y)->nodeName, 0, 3) == 'cct') ? "cct:" : "";
                    foreach (array_keys($dataA) as $key) {
                        //Casos Especiales
                        if ($key == "codigo")
                            continue;
                        if ($segNivel->item($y)->nodeName == $prefix . $key) {
                            $dataA[$key] = $segNivel->item($y)->nodeValue;
                            //Caso especial
                            if ($key == "institucion") {
                                $dataA["codigo"] = $segNivel->item($y)->attributes->getNamedItem("id")->nodeValue;
                            }
                        }
                    }

                    //obtengo hijos del nodo
                    $terNivel = $segNivel->item($y)->childNodes;

                    if ($terNivel)
                        for ($z = 0; $z < $terNivel->length; $z++) {

                            $prefix = (substr($segNivel->item($y)->nodeName, 0, 3) == 'cct') ? "cct:" : "";
                            //verificamos si los nodos parten con cct ya que hay xml que tienen otro formato

                            foreach (array_keys($dataB) as $key) {
                                if ($terNivel->item($z)->nodeName == $prefix . $key) {
                                    if ($key == 'key') {
                                        $dataB['llavenombre'] = $terNivel->item($z)->attributes->getNamedItem("name")->nodeValue;
                                        $dataB['llavevalor'] = $terNivel->item($z)->attributes->getNamedItem("value")->nodeValue;
                                    } else {
                                        $dataB[$key] = $terNivel->item($z)->nodeValue;
                                    }
                                }
                            }
                        }//endfor z
                }//endfor y
        }//endfor x

        $return = array_map("mysql_real_escape_string", array_merge($dataA, $dataB, $dataC));
        //debug($return);
        return $return;
    }

    function connect($user, $pass, $database) {

        //DB
        //establecemos la conexion
        $conn = mysql_connect('localhost', $user, $pass);
        if (!$conn) {
            die('No pudo conectarse: ' . mysql_error());
        }

        $db_selected = mysql_select_db($database, $conn);
        if (!$db_selected) {
            die('Can\'t use foo : ' . mysql_error());
        }

        mysql_set_charset('utf8', $conn);
    }

    function execute($query) {

        $result = mysql_query($query);
        if (!$result)
            echo '<div style="background-color: red;color: #fff;">' . mysql_error() . '<br /><div style="background-color: orange; padding: 20px;margin: 20px;">' . $query . '</div></div>';

        return $result;
    }

    function get($query) {
        return mysql_fetch_assoc($this->execute($query));
    }

    function exporta($db) {
        header('Content-Disposition: attachment; filename="search_log_' . date('dmY') . '.xml"');
        header('Content-type: text/xml');
        $query = Doctrine::getTable($db)->findAll();
        echo $query->exportTo('xml');
    }
    
    function broken_links(){
        $fichas=  Doctrine_Query::create()
                ->from('Ficha f')
                ->select('f.id, f.titulo')
                ->where('f.publicado = 1 and f.maestro = 0')
                ->andWhere('f.guia_online_url != ""')
                ->execute();
        
        
        
        foreach($fichas as $f){
            $ch = curl_init($f->guia_online_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            echo '<ul>';
            if($http_code!=200){
                echo 'Error en ficha '.$f->Maestro->id.': '.$f->titulo.'<br />';
                echo 'URL: <a target="_blank" href="'.$f->guia_online_url.'">'.$f->guia_online_url.'</a>';
            }
            echo '</ul>';
        }
        
        echo '<p>El chequeo se ha completado.</p>';
    }

}

