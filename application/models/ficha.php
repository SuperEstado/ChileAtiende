<?php

class Ficha extends Doctrine_Record {

    function setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('correlativo');
        $this->hasColumn('titulo');
        $this->hasColumn('alias');
        $this->hasColumn('objetivo');
        $this->hasColumn('beneficiarios');
        $this->hasColumn('costo');
        $this->hasColumn('vigencia');
        $this->hasColumn('plazo');
        $this->hasColumn('guia_online');
        $this->hasColumn('guia_online_url');
        $this->hasColumn('guia_oficina');
        $this->hasColumn('guia_telefonico');
        $this->hasColumn('guia_correo');
        $this->hasColumn('doc_requeridos');
        $this->hasColumn('maestro');
        $this->hasColumn('publicado', 'boolean', 1, array('default' => 0));
        $this->hasColumn('publicado_at');
        $this->hasColumn('locked', 'boolean', 1, array('default' => 0));
        $this->hasColumn('estado');
        $this->hasColumn('estado_justificacion');
        $this->hasColumn('actualizable');
        $this->hasColumn('destacado', 'boolean', 1, array('default' => 0));
        $this->hasColumn('servicio_codigo');
        $this->hasColumn('maestro_id');
        $this->hasColumn('marco_legal');
        $this->hasColumn('genero_id');
        $this->hasColumn('convenio');
        $this->hasColumn('diagramacion');
        $this->hasColumn('cc_observaciones');
        $this->hasColumn('cc_id');
        $this->hasColumn('cc_formulario');
        $this->hasColumn('cc_llavevalor');
        $this->hasColumn('comentarios');
        $this->hasColumn('tipo');
        $this->hasColumn('flujo');
        $this->hasColumn('keywords');
        $this->hasColumn('sic');
    }

    function setUp() {
        parent::setUp();
        $this->actAs('Timestampable');

        $this->hasMany('Ficha as Versiones', array(
            'local' => 'id',
            'foreign' => 'maestro_id',
            'orderBy' => 'id desc'
        ));

        $this->hasMany('Archivo as Archivos', array(
            'local' => 'id',
            'foreign' => 'ficha_id',
            'orderBy' => 'id desc'
        ));

        $this->hasOne('Ficha as Maestro', array(
            'local' => 'maestro_id',
            'foreign' => 'id'
        ));

        $this->hasOne('Ficha as Maestro', array(
            'local' => 'maestro_id',
            'foreign' => 'id'
        ));

        $this->hasOne('Servicio', array(
            'local' => 'servicio_codigo',
            'foreign' => 'codigo'
        ));

        $this->hasMany('Tema as Temas', array(
            'local' => 'ficha_id',
            'foreign' => 'tema_id',
            'refClass' => 'FichaHasTema'
        ));

        $this->hasMany('Tag as Tags', array(
            'local' => 'ficha_id',
            'foreign' => 'tag_id',
            'refClass' => 'FichaHasTag'
        ));

        $this->hasMany('Hit as Hits', array(
            'local' => 'id',
            'foreign' => 'ficha_id'
        ));

        $this->hasMany('Evaluacion as Evaluaciones', array(
            'local' => 'id',
            'foreign' => 'ficha_id'
        ));

        $this->hasMany('Comentario as Comentarios', array(
            'local' => 'id',
            'foreign' => 'ficha_id'
        ));

        $this->hasMany('Historial as Historiales', array(
            'local' => 'id',
            'foreign' => 'ficha_id',
            'orderBy' => 'id desc'
        ));

        $this->hasMany('HechoVida as HechosVida', array(
            'local' => 'ficha_id',
            'foreign' => 'hecho_vida_id',
            'refClass' => 'FichaHasHechoVida'
        ));

        $this->hasMany('RangoEdad as RangosEdad', array(
            'local' => 'ficha_id',
            'foreign' => 'rango_edad_id',
            'refClass' => 'FichaHasRangoEdad'
        ));
        
        $this->hasMany('ChileclicSubtema as ChileclicSubtemas', array(
            'local' => 'ficha_id',
            'foreign' => 'chileclic_subtema_id',
            'refClass' => 'FichaHasChileclicSubtema'
        ));

        $this->hasOne('Genero', array(
            'local' => 'genero_id',
            'foreign' => 'id'
        ));
    }

    function getCodigo() {
        if ($this->maestro)
            return $this->servicio_codigo . '-' . $this->correlativo;
        else
            return $this->Maestro->servicio_codigo . '-' . $this->Maestro->correlativo;
    }

    function hasTema($tema_id) {
        foreach ($this->Temas as $tema) {
            if ($tema_id == $tema->id)
                return TRUE;
        }
        return FALSE;
    }

    function setTemasFromArray($temas) {

        foreach ($this->Temas as $key => $c)
            unset($this->Temas[$key]);

        if ($temas)
            foreach ($temas as $tema)
                $this->Temas[] = Doctrine::getTable('Tema')->find($tema);
    }

    function setHechosVidaFromArray($hechosvida) {

        foreach ($this->HechosVida as $key => $c)
            unset($this->HechosVida[$key]);

        if ($hechosvida)
            foreach ($hechosvida as $h)
                $this->HechosVida[] = Doctrine::getTable('HechoVida')->find($h);
    }

    function setTagsFromArray($tags) {
        foreach ($this->Tags as $key => $c)
            unset($this->Tags[$key]);

        if ($tags) {
            foreach ($tags as $t) {
                $tag_db = Doctrine::getTable('Tag')->findOneByNombre($t);
                if (!$tag_db) {
                    $tag_db = new Tag();
                    $tag_db->nombre = $t;
                }
                $this->Tags[] = clone $tag_db;
            }
        }
    }

    function showRangosAsString() {

        $rangos = array();
        foreach ($this->RangosEdad as $rango) {
            if ($rango->edad_minima != null && $rango->edad_maxima != null)
                $rangos[] = $rango->edad_minima . '-' . $rango->edad_maxima;
        }

        return implode(",", $rangos);
    }

    function setRangosEdadFromString($string) {

        $string = str_replace(" ", "", $string);
        $rangos_en_bruto = explode(',', $string);

        //Genero arreglo de nuevos rangos
        $new_rangos = array();
        if (is_array($rangos_en_bruto) && count($rangos_en_bruto) > 0)
            foreach ($rangos_en_bruto as $key => $val) {
                if ($val) {
                    list($min, $max) = explode("-", $val);
                    $new_rangos[$min . "-" . $max] = 1;
                }
            }

        //Arreglo de rangos anteriores
        $old_rangos = array();
        if ($this->RangosEdad != null)
            foreach ($this->RangosEdad as $key => $val) {
                $old_rangos[$val->edad_minima . "-" . $val->edad_maxima] = $val->id;
            }

        //Defino los rangos que hay que agregar
        $para_agregar = array();
        if (is_array($new_rangos) && count($new_rangos) > 0)
            foreach ($new_rangos as $rango => $id) {
                if (!isset($old_rangos[$rango])) {
                    $para_agregar[$rango] = $id;
                }
            }

        //Defino los rangos que se deben borrar
        $para_borrar = array();
        if (is_array($old_rangos) && count($old_rangos) > 0) {
            foreach ($old_rangos as $rango => $id) {
                if (!isset($new_rangos[$rango])) {
                    $para_borrar[$rango] = $id;
                }
            }
        }

        //Borro solo los rangos que no uso
        if ($this->RangosEdad != null)
            foreach ($this->RangosEdad as $key => $val) {
                $new_key = $val->edad_minima . "-" . $val->edad_maxima;
                if (isset($para_borrar[$new_key])) {
                    $this->unlink('RangosEdad', $val->id);
                }
            }

        //Agrego los nuevos rangos a la ficha
        if (is_array($para_agregar) && count($para_agregar) > 0)
            foreach ($para_agregar as $rango => $id) {
                list($min, $max) = explode("-", $rango);
                //Busco si el rango existe
                list($rango) = Doctrine::getTable('rangoEdad')->min_max($min, $max);
                if ($rango->id != null) {
                    //Encontrado, set rango
                    $this->RangosEdad[] = $rango;
                } else {
                    //No encontrado, crea y set rango
                    $rango = new RangoEdad();
                    $rango->edad_minima = $min;
                    $rango->edad_maxima = $max;
                    $this->RangosEdad[] = $rango;
                }
            }
    }

    public function generarVersion() {
        if ($this->maestro) {
            //
            //$penultima_version = $this->getUltimaVersion();
            $proyecto_copia = $this->copy(TRUE);
            $proyecto_copia->maestro = 0;
            $proyecto_copia->publicado = 0;
            $proyecto_copia->maestro_id = $this->id;
            $proyecto_copia->actualizable = NULL;
            $proyecto_copia->correlativo = NULL;
            $proyecto_copia->save();

            if ($this->publicado) {
                $this->actualizable = 1;
                $this->save();
            }

            $this->logLastChange();
        }
    }

    public function copy($deep = false) {
        $copia = parent::copy(false);

        if ($deep) {
            //Asignamos
            foreach ($this->Temas as $c)
                $copia->Temas[] = $c;
            foreach ($this->Tags as $t)
                $copia->Tags[] = $t;
            foreach ($this->HechosVida as $h)
                $copia->HechosVida[] = $h;
            foreach ($this->RangosEdad as $r)
                $copia->RangosEdad[] = $r;

            //Copiamos
            //foreach ($this->Documentos as $d)
            //    $copia->Documentos[] = $d->copy();
        }

        //Reseteamos fechas de actualizacion
        $copia->created_at = NULL;
        $copia->updated_at = NULL;

        return $copia;
    }

    //Grabo en el log lo que se hizo
    private function logLastChange() {
        $usuario = NULL;
        if (UsuarioBackendSesion::usuario())
            $usuario = UsuarioBackendSesion::usuario();

        $ultima_version = $this->getUltimaVersion();

        if ($this->Versiones->count() > 1) {

            $penultima_version = $this->Versiones[1];
            $comparacion = $ultima_version->compareWith($penultima_version);
            if ($comparacion) {
                $descripcion = make_description($comparacion, $ultima_version); //Helper historial
            } else {
                $descripcion = '<p>'.( ($this->flujo) ? 'El flujo': 'La ficha' ).' ha sido guardado pero no se realizaron cambios.</p>';
            }
        } else {    //El proyectos es nuevo
            
            $descripcion = '<p>Se ha creado el '.( ($this->flujo) ? 'flujo': 'trámite' ).'</p>';
        }

        $log = new Historial();
        $log->Ficha = $this;
        $log->FichaVersion = $ultima_version;
        $log->UsuarioBackend = $usuario;
        $log->descripcion = $descripcion;
        $log->save();
    }

    /**
     * Obtiene la ultima version de este proyecto
     * La última versión se define como la versión con el ID más grande.
     * @return Proyecto
     */
    function getUltimaVersion() {
        if ($this->maestro)
            $versiones = $this->Versiones;
        else
            $versiones = $this->Maestro->Versiones;


        $version = NULL;

        if ($versiones)
            $version = $versiones[0];

        return $version;
    }

    //Retorna la version publicada
    function getVersionPublicada() {
        if ($this->maestro)
            $versiones = $this->Versiones;
        else
            $versiones = $this->Maestro->Versiones;

        foreach ($versiones as $v)
            if ($v->publicado)
                return $v;

        return false;
    }

    function aprobar() {
        //if ($this->getErrores())
        //    return;

        Doctrine_Manager::connection()->beginTransaction();

        //Marco el maestro como en revision
        $this->locked = 1;
        $this->estado = 'en_revision';
        $this->save();


        $ultimaversion = $this->getUltimaVersion();
        $ultimaversion->estado = 'en_revision';

        //Lo escribo en el log
        $log = new Historial();
        $log->descripcion = '<strong>Actualización de Estado</strong><br />Versión aprobada y enviada a revisión.';
        $log->Ficha = $this;
        $log->FichaVersion = $ultimaversion;
        $log->UsuarioBackend = UsuarioBackendSesion::usuario();
        $log->save();

        Doctrine_Manager::connection()->commit();
    }

    function rechazar() {
        //if ($this->getErrores())
        //    return;

        Doctrine_Manager::connection()->beginTransaction();

        $this->locked = 0;
        $this->estado = 'rechazado';
        $this->save();


        $ultimaversion = $this->getUltimaVersion();
        $ultimaversion->estado = 'rechazado';
        $ultimaversion->estado_justificacion = $this->estado_justificacion;

        $ultimaversion->save();

        //Lo escribo en el log
        $log = new Historial();
        $log->descripcion = '<strong>Actualización de Estado</strong><br />Versión rechazada.<br />Motivo: ' . $this->estado_justificacion;
        $log->Ficha = $this;
        $log->FichaVersion = $ultimaversion;
        $log->UsuarioBackend = UsuarioBackendSesion::usuario();
        $log->save();

        Doctrine_Manager::connection()->commit();
    }

    function publicar() {
        //if ($this->getErrores())
        //    return;

        Doctrine_Manager::connection()->beginTransaction();

        //Marco el maestro como publicado
        if ($this->publicado) {
            $this->actualizable = 0;
        } else {
            $this->publicado = 1;
            $this->publicado_at = date('Y-m-d H:i:s');
        }

        $this->estado_justificacion = '';
        $this->locked = 0;
        $this->estado = NULL;

        $this->save();

        //Primero despublico las versiones antiguas;
        $versiones = $this->Versiones;
        foreach ($versiones as $v) {
            $v->publicado = 0;
            $v->publicado_at = NULL;
            $v->save();
        }

        $ultimaversion = $this->getUltimaVersion();
        $ultimaversion->estado = NULL;
        $ultimaversion->publicado = 1;
        $ultimaversion->publicado_at = date('Y-m-d H:i:s');
        $ultimaversion->estado_justificacion = '';

        $ultimaversion->save();

        //Lo escribo en el log
        $log = new Historial();
        $log->descripcion = '<strong>Actualización de Estado de Publicación</strong><br />Versión publicada';
        $log->Ficha = $this;
        $log->FichaVersion = $ultimaversion;
        $log->UsuarioBackend = UsuarioBackendSesion::usuario();
        $log->save();

        Doctrine_Manager::connection()->commit();
    }

    function despublicar() {
        Doctrine_Manager::connection()->beginTransaction();

        //Marco el maestro como publicado
        $this->publicado = 0;
        $this->publicado_at = NULL;
        $this->actualizable = 0;

        $this->save();

        //Despublico las versiones;
        $versiones = $this->Versiones;
        foreach ($versiones as $v) {
            if ($v->publicado == 1) {
                $v->publicado = 0;
                $v->publicado_at = NULL;
                $v->save();
                $versionactualizada = $v;
            }
        }

        //Lo escribo en el log
        $log = new Historial();
        $log->descripcion = '<strong>Actualización de Estado de Publicación</strong><br />Versión despublicada';
        $log->Ficha = $this;
        $log->FichaVersion = $versionactualizada;
        $log->UsuarioBackend = UsuarioBackendSesion::usuario();
        $log->save();

        Doctrine_Manager::connection()->commit();
    }

    public function compareWith(Ficha $ficha) {

        $comparacion = NULL;

        $left = $this->toArray(false);
        $right = $ficha->toArray(false);

        $exclude = array('id', 'genero_id', 'convenio', 'updated_at', 'created_at', 'publicado', 'publicado_at', 'servicio_codigo', 'comentarios', 'alias', 'rating', 'estado', 'estado_justificacion', 'actualizable', 'diagramacion','locked');
        $labels = array('tipo' => array(1 => 'Personas', 2 => 'Empresas', 3 => 'Ambos', 0 => 'No asignado'));

        foreach ($left as $key => $val) {
            if (!in_array($key, $exclude)) {
                if ($right[$key] != $left[$key]) {
                    if (array_key_exists($key, $labels)) {
                        $diff = htmlDiff(
                                strip_tags($labels[$key][$right[$key]]), strip_tags($labels[$key][$left[$key]])
                        );
                    } else {
                        $diff = htmlDiff(strip_tags($right[$key]), strip_tags($left[$key]));
                    }
                    $diff = trim($diff);
                    if ($diff) {
                        $comparacion[$key]->left[] = $diff;
                        $comparacion[$key]->right[] = $right[$key];
                    }
                }
            }
        }


        //Comparamos las relaciones one
        //Nombre => Valor_Para_Label
        $relacionesAComparar = array('Servicio' => 'nombre', 'Genero' => 'nombre');
        foreach ($relacionesAComparar as $r => $label) {
            $left = $this->get($r);
            $right = $ficha->get($r);

            //debug($left->toArray());
            //debug($right->toArray());

            if ($left->toArray() !== $right->toArray()) {
                //if ($left !== $right) {
                $comparacion[$r]->left[] = htmlDiff($left->$label, $right->$label);
                $comparacion[$r]->right[] = $right->$label;
            }
        }

        //Comparamos las relaciones many
        //[caso un valor] : Nombre => Valor_Para_Label
        //[caso multiple] : Nombre => Array(Array(label1,label2,...,labelN),separador)
        $relacionesAComparar = array(
            'Tags' => 'nombre',
            'Temas' => 'nombre',
            'HechosVida' => 'nombre',
            'RangosEdad' => array(array('edad_minima', 'edad_maxima'), '-')); //Caso multiple

        foreach ($relacionesAComparar as $r => $label) {
            $left = $this->get($r);
            $right = $ficha->get($r);
            if (!$this->bidimensional_array_equals($left->toArray(false), $right->toArray(false), array('id', 'ficha_id'))) {

                $tmp = array();

                foreach ($right as $rig) {

                    if (!is_array($label)) {
                        $tmp[] = $rig->$label;
                    } else {
                        list($mlabels, $sep) = $label;
                        $values = array();
                        foreach ($mlabels as $mlabel) {
                            $values[] = $rig->$mlabel;
                        }
                        $val = implode($sep, $values);
                        $tmp[] = $val;
                    }
                }
                $right_label = implode(" ", $tmp);
                $tmp = array();
                foreach ($left as $l) {
                    if (!is_array($label)) {
                        $tmp[] = $l->$label;
                    } else {
                        list($mlabels, $sep) = $label;
                        $values = array();
                        foreach ($mlabels as $mlabel) {
                            $values[] = $l->$mlabel;
                        }
                        $val = implode($sep, $values);
                        $tmp[] = $val;
                    }
                }
                $left_label = implode(" ", $tmp);

                $diff = trim(htmlDiff($right_label, $left_label));
                if ($diff) {
                    $comparacion[$r]->left[0] = $diff;
                    $comparacion[$r]->right[0] = $right_label;
                }
            }
        }

        return $comparacion;
    }

    //Funcion que compara arreglos multidimensionales
    /**
     * Función que compara arreglos multidimensionales.
     * Si los arreglos tienen una cantidad distinta de elementos son distintos
     * Si tienen la misma cantidad de elementos, se toman los elementos de $a,
     * se buscan en $b y se comparan.
     *
     * Esta función no indica cual es la diferencia.
     */
    private function bidimensional_array_equals($a, $b, $exclude=array()) {
        //echo "comienzo\n";
        //print_r($a);
        //print_r($b);

        if (count($a) != count($b)) {
            //debug($b);
            return FALSE;
        }
        foreach ($a as $keyr => $record)
            foreach ($record as $keyc => $column)
                if (!in_array($keyc, $exclude) && $a[$keyr][$keyc] != $b[$keyr][$keyc]) {
                    //debug($a[$keyr][$keyc]);
                    //debug($b[$keyr][$keyc]);
                    return FALSE;
                }
        return TRUE;
    }

    public function getFiles() {
        return Doctrine::getTable('Archivo')->ficha($this->maestro_id);
    }

    public function getEstadisticaEvaluaciones() {
        $query = Doctrine_Query::create();
        $query->from('Evaluacion e, e.Ficha ficha');
        $query->where('ficha.id=?', $this->id)
                ->select('AVG(e.rating) as promedio, COUNT(e.id) as nevaluaciones');

        return $query->fetchOne();
    }

    //Retorna la ficha convertida en array, solamente con los campos visibles al publico a traves de la API.
    public function toPublicArray() {
        //No se accede al maestro en forma directa por el publico en la API
        if ($this->maestro)
            return NULL;

        $temas = NULL;
        foreach ($this->Temas as $t)
            $temas->tema[] = $t->nombre;

        $tags = NULL;
        foreach ($this->Tags as $t)
            $tags->tag[] = $t->nombre;

        $publicArray = array(
            'codigo' => $this->getCodigo(),
            'fecha' => $this->publicado_at,
            'servicio' => $this->Servicio->nombre,
            'titulo' => $this->titulo,
            'objetivo' => $this->objetivo,
            'beneficiarios' => $this->beneficiarios,
            'costo' => $this->costo,
            'vigencia' => $this->vigencia,
            'plazo' => $this->plazo,
            'observaciones'=>$this->cc_observaciones,
            'marco_legal' => $this->marco_legal,
            'doc_requeridos'=>$this->doc_requeridos,
            'guia_online'=>$this->guia_online,
            'guia_online_url'=>$this->guia_online_url,
            'guia_oficina'=>$this->guia_oficina,
            'guia_telefonico'=>$this->guia_telefonico,
            'guia_correo'=>$this->guia_correo,
            'temas' => $temas,
            'tags' => $tags,
            'chileclic_id' => $this->Maestro->cc_id,
            'permalink' => site_url('fichas/ver/'.$this->Maestro->id)
        );

        return $publicArray;
    }

    //Retorna la cantidad de Hits de una ficha
    function getHits() {
        
        $query = Doctrine_Query::create();
        $query->from('Ficha f, f.Maestro maestro, maestro.Hits hits');
        $query->andWhere('f.id = ?',$this->id);
        $query->addSelect("SUM(hits.count) as total");
        $query->groupBy("hits.ficha_id");
        $result = $query->execute();
        return ($result[0]->total)?$result[0]->total:"0";
        
    }

}

?>