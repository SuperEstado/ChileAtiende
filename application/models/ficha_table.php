<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class FichaTable extends Doctrine_Table {

    function findPublicados($options=array()) {
        $query = Doctrine_Query::create();
        $query->from('Ficha f, f.Temas temas, f.Servicio servicio, servicio.Entidad entidad');
        $query->andWhere('f.maestro = 0 and f.publicado = 1');

        return $this->_optionsHandler($query, $options);
    }

    function findMaestros($entidad=NULL, $servicio=NULL, $options=array()) {
        $query = Doctrine_Query::create();

        if (isset($options['campos']))
            $query->select($options['campos']);

        $query->from('Ficha f, f.Temas temas, f.Servicio servicio, servicio.Entidad entidad');

        $query->andWhere('f.maestro = 1');

        if ($entidad)
            $query->andWhere('entidad.codigo = ?', $entidad);
        if ($servicio)
            $query->andWhere('servicio.codigo = ?', $servicio);

        if (isset($options['flujos'])) {
            if ($options['estado'] != 'destacado') {//habilitamos esta opción para que muestre destacadas las fichas y los flujos
                if ($options['flujos']) {
                    $query->andWhere('f.flujo = 1');
                } else {
                    $query->andWhere('f.flujo = 0');
                }
            }
        }

        if (!empty($options['titulo'])) {
            //verifico si es numerico, en caso de que este buscando por el id del tramite
            if (is_numeric($options['titulo'])) {
                $query->andWhere('f.id = ?', $options['titulo']);
            } else {
                //divido el string, en el caso de que se esté buscando por el codigo del tramite
                //si este arreglo que se genera es menor de 1 significa que está buscando por el titulo del tramite
                $aCodigo = explode('-', $options['titulo']);
                if (count($aCodigo) > 1) {
                    $query->andWhere('f.servicio_codigo LIKE ?', $aCodigo[0]);
                    $query->andWhere('f.correlativo = ?', $aCodigo[1]);
                } else {
                    $query->andWhere('f.titulo LIKE ?', '%' . $options['titulo'] . '%');
                }
            }
        }
        //filtro para tipos de fichas, empresas o personas
        if (!empty($options['publico'])) {
            $query->andWhere('f.tipo = ?', $options['publico']);
        }

        if (isset($options['estado'])) {

            if ($options['estado'] == 'publicados')
                $query->andWhere('f.publicado = 1');

            if ($options['estado'] == 'nopublicados')
                $query->andWhere('f.publicado = 0');

            if ($options['estado'] == 'actualizables')
                $query->andWhere('f.actualizable = 1');

            if ($options['estado'] == 'destacado')
                $query->andWhere('f.destacado = 1');

            if ($options['estado'] == 'chileclic')
                $query->andWhere('f.cc_llavevalor IS NOT NULL');

            if ($options['estado'] == 'pendiente')
                $query->andWhere('f.diagramacion = 1');

            if ($options['estado'] == 'enproceso')
                $query->andWhere('f.diagramacion = 2');

            if ($options['estado'] == 'finalizada')
                $query->andWhere('f.diagramacion = 3');

            if ($options['estado'] == 'enrevision')
                $query->andWhere("f.estado LIKE 'en_revision'");

            if ($options['estado'] == 'rechazado')
                $query->andWhere("f.estado LIKE 'rechazado'");

            if ($options['estado'] == 'creadas') {
                $query->andWhere("f.publicado = 0");
                $query->andWhere("f.publicado_at IS NULL");
                $query->andWhere("f.locked = 0");
                $query->andWhere("f.estado IS NULL");
            }
        }

        return $this->_optionsHandler($query, $options);
    }

    function findFichaOnServicio($codigo, $options=array()) {
        $query = Doctrine_Query::create();
        $query->from('Ficha f');

        $query->where('f.servicio_codigo = ?', $codigo);
        $query->andWhere('f.maestro = 0 and f.publicado = 1');
        $query->orderBy('f.titulo');

        return $this->_optionsHandler($query, $options);
    }

    function findFichaOnEntidad($codigo, $options=array()) {
        $query = Doctrine_Query::create();
        $query->from('Ficha f');

        $query->where('f.servicio_codigo LIKE ?', $codigo . '%');
        $query->andWhere('f.maestro = 0 and f.publicado = 1');
        //debug( $query->getSqlQuery() );

        return $this->_optionsHandler($query, $options);
    }

    function findNroFichasOnServicios($options=array()) {
        $query = Doctrine_Query::create();
        $query->select('COUNT(f.titulo) AS cnt, f.servicio_codigo, s.nombre');
        $query->from('Ficha f, f.Servicio s');
        $query->andWhere('f.maestro = 0 and f.publicado = 1');
        $query->groupBy('f.servicio_codigo');
        $query->orderBy('cnt DESC');

        //return $this->_optionsHandler($query, $options);
        if (isset($options['limit']))
            $query->limit($options['limit']);
        if (isset($options['offset']))
            $query->offset($options['offset']);

        $result = $query->execute();
        return $result;
    }

    function findNroFichasOnHechos($idHV) {
        $query = Doctrine_Query::create();
        $query->select('COUNT(*) AS cnt');
        $query->from('Ficha f, f.HechosVida hv');
        $query->where('hv.id = ?', $idHV);
        //debug($query->getSqlQuery(),"red");
        $resultado = $query->fetchOne();

        return $resultado;
    }

    /* Metodo que retorna la ficha publicada a partir del id del maestro */

    function findPublicado($id_maestro, $options=array()) {
        $query = Doctrine_Query::create();
        $query->from('Ficha f, f.Temas temas, f.Servicio servicio, servicio.Entidad entidad');
        $query->andWhere('f.maestro = 0 and f.publicado = 1');
        $query->andWhere('f.maestro_id = ?', $id_maestro);

        return $this->_optionsHandler($query, $options);
    }

    /* Metodo privado que gestiona las opciones de busqueda para una ficha */

    function _optionsHandler($query, $options) {


        if (isset($options['filtros'])) {


            //Normalmente se hacen dos consultas, la primera es para obtener todos los resultados y construir la paginacion, obtener el total de temas asociados, etc.
            //La seguna es el resultado de una pagina especifica.
            //Este parametro es True cuando hago la consulta que pide todos los resultados y false cuando pido los resultados de una pagina en particular.
            $all = FALSE;
            if (!(isset($options['limit']) && isset($options['offset']) ))
            //Si estos parametros no estan definidos entonces es posible inferir que se piden todos los resultados
                $all = TRUE;

            //Si status es True, entonces Sphinx busco correctamente
            list($query, $status) = $this->_search($query, $options['filtros'], $options, $all);
            if ($status) {

                //En este caso se eliminan los limit y offset externos ya que se aplican sobre la busqueda de sphinx y no a nivel de doctrine, por ende es necesario ignorarlo en esta parte de optionsHandler.

                if (isset($options['limit']))
                    unset($options['limit']);
                if (isset($options['offset']))
                    unset($options['offset']);

                if (!$all) {
                    //Al igual que en el caso de limit y offset, doctrine se encarga de aplicar orderBy por lo tanto se ignora este campo.
                    unset($options['orderBy']);
                }
            }
        }

        if (isset($options['limit'])) {
            $query->limit($options['limit']);
        }
        if (isset($options['offset'])) {
            $query->offset($options['offset']);
        }

        /*
         * En esta parte, se desarma el parametro orderBy para implementar orderBy mas_votados y mas_vistos, los cuales no son campos de la ficha propiamente tal y es necesario
         * hacer una serie de cruces para poder entregar fichas ordenadas de esta manera.
         * Actualmente se observo que estos dos metodos no funcionan correctamente ya que doctrine
         * genera entidades extras que hacen que SUM y COUN no funcionen como es esperado, por lo tanto no se deben utilizar estos métodos y en el futuro
         * deberian ser eliminados.
         */

        if (isset($options['orderBy'])) {

            $orders = explode(",", $options['orderBy']);
            $orderByFinal = array();
            foreach ($orders as $orderby) {

                $orderby = explode(" ", trim($orderby));

                $campo = $orderby[0];
                $order = (isset($orderby[1])) ? $orderby[1] : "DESC";

                if ($campo == "mas_votados") {
                    //Warning: Estas dos funciones no son seguras, no calculan bien las cantidades

                    $query->addFrom(" f.Maestro maestro");
                    $query->leftJoin("maestro.Evaluaciones evaluaciones");
                    $query->addSelect("*,maestro.id, maestro.rating");
                    $query->groupBy("maestro.id");
                    $orderByFinal[] = "maestro.rating " . $order;
                } elseif ($campo == "mas_vistos") {
                    //Warning: Estas dos funciones no son seguras, no calculan bien las cantidades

                    $query->addFrom(" f.Maestro maestro");
                    $query->leftJoin("maestro.Hits hits ");
                    $query->addSelect("f.id,temas.*,servicio.*,entidad.*, SUM(hits.count) as total");
                    $query->groupBy("f.id, maestro.id");
                    $orderByFinal[] = "total " . $order;
                } else {

                    $orderByFinal[] = $campo . " " . $order;
                }
            }
            $query->orderBy(implode(",", $orderByFinal));
        }

        if (isset($options['order_by'])) {
            $query->orderBy($options['order_by']);
        }

        $resultado = NULL;
        if (isset($options['justCount'])) {
            //debug($query->getSqlQuery(),"red");
            $resultado = $query->count();
        } elseif (isset($options['justQuery'])) {
            $resultado = $query;
        } else {
            //debug($query->getSqlQuery(), "red");
            if (isset($options['justIds'])) {
                $query->select('f.id');
            }
            $resultado = $query->execute();
        }
        if (isset($options['to_array']))
            return $resultado->toArray();
        else
            return $resultado;
    }

    /* Funcion que gestiona la busqueda de fichas en distintos casos */

    private function _search($query, $filtros, $op = NULL, $all = FALSE) {

        $ci = &get_instance();
        $ci->load->helper("sphinx");

        //Se asume que el filtro no sera una busqueda en texto a menos que este definida la opcion 'palabra'
        $string = "";
        $nonfulltext = true;
        $filters = array();

        //Intento correr Sphinx
        //Defino una nueva variable de filtros que le paso al search(sphinxhelper) usando los filtros que me llegan del optionsHandler

        if (isset($filtros['string'])) {
            $string = $filtros['string'];
            $nonfulltext = false;
        }

        if (isset($filtros['hecho'])) {
            $filters['hecho_vida_id'] = array($filtros['hecho']);
        }

        if (isset($filtros['etapa'])) {
            $filters['etapa_vida_id'] = array($filtros['etapa']);
        }

        if (isset($filtros['temas'])) {
            $filters['tema_id'] = $filtros['temas'];
        }

        if (isset($filtros['servicios'])) {
            //Se usa crc32 para transformar el codigo de un servicio a int para poder indexarlo en sphinx.
            //Esto hay que hacerlo con cualquier campo sobre el cual haya que aplicar filtros y no sea un numero.
            $filters['servicio_codigo'] = array_map("crc32", $filtros['servicios']);
        }

        if (isset($filtros['edad'])) {

            //La edad para filtrar no sirve directamente, es necesario obtener los rangos donde la edad esta incluida
            //y luego filtrar por ese set de rangos asociados a las fichas

            $rangos = Doctrine::getTable("RangoEdad")->rangosFromAge($filtros['edad']);
            if ($rangos) {
                $filters['rango_edad_id'] = $rangos;
            } else {
                //Fuerzo el resultado a 0 fichas ya que preguntan por una edad que no posee rangos de edad asociados
                return array($query->having("f.id IN (0)"), TRUE);
            }
        }

        if (isset($filtros['genero'])) {

            $genero = $filtros['genero'];
            switch ($genero) {
                case 1:
                    //Caso ambos (1) busco las fichas marcadas con ambos y las que poseen genero 0 (no asignadas)
                    $genero = array(1, 0);
                    break;
                case 2:
                    //Si me piden un genero particular busco el genero (2), ambos (1), que tambien contienen al genero (2) y también las que no han sido asignadas
                    $genero = array(2, 1, 0);
                    break;
                case 3:
                    //Igual que caso 2
                    $genero = array(3, 1, 0);
                    break;
            }

            $filtros['genero'] = $genero;

            if (!is_array($filtros['genero'])) {
                //Cada variable en filters debe ser un arreglo. Si genero es solo un valor, entonces lo defino como un arreglo de un elemento.
                $filters['genero_id'] = array($filtros['genero']);
            } else {
                $filters['genero_id'] = $filtros['genero'];
            }
        }

        /* IMPORTANTE AGREGAR PARA TENER BUENOS RESULTADOS */
        //Esto es un poco feo, ya que la busqueda solo me va a servir para documentos publicados.
        //Deberia ser posible abstraerlo.
        $filters['publicado'] = array(1);
        $filters['maestro'] = array(0);

        /* LIMITO RESULTADOS */
        $limit = 100000; //Se define esto ya que Sphinx limita por defecto los resultados, para el caso donde no se define limite se pone un limite alto para escapar el limite de sphinx.
        $offset = 0;
        if (isset($op['limit']))
            $limit = $op['limit'];
        if (isset($op['offset']))
            $offset = $op['offset'];

        //debug($filters);

        $search_result = search($string, $filters, $nonfulltext, $limit, $offset);
        list($res, $status, $message) = $search_result;

        $temas = (isset($filtros['temas'])) ? $filtros['temas'] : null;
        $servicios = (isset($filtros['servicios'])) ? $filtros['servicios'] : null;
        $edad = (isset($filtros['edad'])) ? $filtros['edad'] : null;
        $genero = (isset($filtros['genero'])) ? $filtros['genero'] : null;

        //Caso en que esta corriendo sphinx
        if ($status) {

            $fichas = search_wrapper($search_result, TRUE);
            $set_de_fichas = implode(",", array_keys($fichas));

            $q = Doctrine_Manager::getInstance()->getCurrentConnection();

            if ($set_de_fichas) {
                $query->having("f.id IN (" . $set_de_fichas . ")");
                $query->orderBy("FIELD(id," . $set_de_fichas . ")");
            } else {
                $query->having("f.id IN (0)");
            }
        } else {
            //En caso que no este corriendo el demonio searchd, se usan los metodos viejos de filtro :)
            //Busqueda por string
            if (isset($filtros['string'])) {
                $query = $this->_searchString($query, $filtros['string']);
            }
            //Filtros! MUST CHANGE
            $query = $this->_searchFilters($query, $filtros);
        }

        return array($query, $status);
    }

    /* Método privado invocado por _search que gestiona filtros */

    function _searchFilters($query, $filtros) {

        //debug($filtros);
        $w = array();
        $s = array();

        $temas = (isset($filtros['temas'])) ? $filtros['temas'] : null;
        $servicios = (isset($filtros['servicios'])) ? $filtros['servicios'] : null;
        $edad = (isset($filtros['edad'])) ? $filtros['edad'] : null;
        $genero = (isset($filtros['genero'])) ? $filtros['genero'] : null;
        $hecho = (isset($filtros['hecho'])) ? $filtros['hecho'] : null;

        //Temas y Servicios
        if ((is_array($temas) && count($temas)) || (is_array($servicios) && count($servicios))) {
            //debug("Temas y Servicios");
            if (is_array($temas) && count($temas)) {
                foreach ($temas as $tema) {
                    $w[] = ' temas.id = ? ';
                    $s[] = $tema;
                }
            }
            if (is_array($servicios) && count($servicios)) {
                foreach ($servicios as $servicio) {
                    $w[] = ' servicio.codigo = ? ';
                    $s[] = $servicio;
                }
            }
            $query->andWhere(implode(" OR ", $w), $s);
        }

        if ($hecho) {
            //debug("Hecho");
            $query->addFrom('f.HechosVida hechos');
            $query->andWhere('hechos.id = ?', $hecho);
        }

        //FILTROS DE EDAD
        if ($edad) {
            //debug("Edad");
            //valido que efectivamente sea un numero antes de incluirlo en la query, evitando inyecciones o cruces innecesarios.
            if ($edad > 0 && is_numeric($edad)) {
                $query->addFrom("f.RangosEdad r");
                $query->andWhere("r.edad_maxima >= $edad AND r.edad_minima <= $edad");
            }
            //debug($query->getSqlQuery());
        }

        //FILTRO DE GENERO
        if (is_array($genero)) {
            //debug("Genero");
            $gen = array();
            foreach ($genero as $key) {
                $gen[] = "f.genero_id = " . $key;
            }
            $query->andWhere(implode(" OR ", $gen));
        } elseif (is_numeric($genero)) {
            $query->andWhere("f.genero_id = $genero OR f.genero_id = 1 OR f.genero_id = 0");
        }

        return $query;
    }

    /* Busqueda por strings sin sphinx */

    function _searchString($query, $string) {

        $ci = &get_instance();
        $ci->load->helper("file");

        $string = explode(" ", $string);
        $stopwords = explode("\n", read_file("./application/config/stopwords.txt"));
        $string = array_diff($string, $stopwords);

        if (is_array($string) && count($string) && $string[0]) {
            foreach ($string as $str) {
                if ($str) {
                    $str = "%" . $str . "%";
                    //$w[] = " objetivo LIKE '$str' OR titulo LIKE '$str' ";
                    $w[] = " objetivo LIKE ? OR titulo LIKE ? ";
                    $s[] = $str;
                    $s[] = $str;
                }
            }
            $query->andWhere(implode(" OR ", $w), $s);
        } else {
            //Llega vacio
            $query->andWhere(" objetivo LIKE '' OR titulo LIKE '' ");
        }

        return $query;
    }

    function getRandom($limit = 4) {

        $query = Doctrine_Query::create();
        $query->from('Ficha f');
        $query->where('f.maestro = 0 and f.publicado = 1');
        $query->select('f.* , RANDOM() AS rand');
        $query->orderby('rand');
        $query->limit($limit);
        $rating = $query->execute();
        return $rating;
    }

    //obtiene el total de fichas publicadas
    function totalPublicados() {
        $options_ficha['justCount'] = True;
        return $this->findPublicados($options_ficha);
    }

    function MasVistas($aData) {
        if (!isset($aData['limit']))
            ini_set('memory_limit', '64M');

        if (isset($aData['fields']))
            $campos = $aData['fields'];
        else
            $campos = '*';

        $query = Doctrine_Query::create();
        $query->from('Ficha f, f.Maestro maestro, maestro.Hits hits');
        $query->andWhere('f.maestro = 0 and f.publicado = 1');
        if (isset($aData['last_week']))
            $query->andWhere('hits.fecha > DATE_SUB(CURDATE(), INTERVAL 1 WEEK)');
        $query->addSelect($campos . ",SUM(hits.count) as total");
        $query->orderBy("total DESC");
        $query->groupBy("f.maestro_id");

        if (isset($aData['limit']))
            $query->limit($aData['limit']);
        if (isset($aData['offset']))
            $query->offset($aData['offset']);

        $result = $query->execute();

        return $result;
    }

    function MasVotadas($aData) {
        if (!isset($aData['limit']))
            ini_set('memory_limit', '64M');

        $query = Doctrine_Query::create();
        if (isset($aData['fields']))
            $campos = $aData['fields'];
        else
            $campos = '*';

        $query->from('Ficha f, f.Maestro maestro, maestro.Evaluaciones evaluaciones');
        $query->andWhere('f.maestro = 0 and f.publicado = 1');
        $query->addSelect($campos . ", AVG(evaluaciones.rating) as rating, COUNT(evaluaciones.ficha_id) as nrating");
        $query->groupBy("maestro.id");
        $query->orderBy("rating DESC, nrating DESC");

        if (isset($aData['limit']))
            $query->limit($aData['limit']);

        if (isset($aData['offset']))
            $query->offset($aData['offset']);

        $result = $query->execute();

        return $result;
    }

    function MasDestacadas($limit = False, $offset = False) {

        $query = Doctrine_Query::create();
        $query->from('Ficha f, f.Maestro maestro');
        $query->andWhere('f.maestro = 0 and f.publicado = 1 and f.destacado=1');
        $query->orderBy('RAND()');

        if ($limit)
            $query->limit($limit);
        if ($offset)
            $query->offset($offset);

        $result = $query->execute();
        return $result;
    }

}

?>