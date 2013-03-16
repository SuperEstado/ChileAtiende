<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <a href="<?= site_url('backend/'. ( ($flujo) ? 'fichas/listarflujos' : 'fichas' )) ?>"><?= ($flujo) ? 'Flujos' : 'Fichas' ?></a> »
    <span>Editar <?= ($flujo) ? 'Flujo' : 'Ficha' ?> #<?= $ficha->id ?></span>
</div>

<div class="pane">

    <?php $this->load->view('backend/fichas/menu', array('tab' => 'editar')) ?>

    <h2>Edición <?= ($flujo) ? 'flujo' : 'ficha' ?></h2>

    <form class="ajaxForm" method="post" action="<?= site_url('backend/fichas/' . $nombreform . '/' . $ficha->id) ?>">
        <fieldset>
            <legend><?= $ficha->titulo ?></legend>

            <div class="validacion"></div>
            <table class="formTable">
                <?php if (UsuarioBackendSesion::usuario()->tieneRol(array('publicador'))) { ?>
                    <tr>
                        <td class="titulo">Diagramación</td>
                        <td>
                            <select data-placeholder="Estado de la ficha" name="diagramacion" class="chzn-select" style="width: 150px;">
                                <option value="NULL"></option>
                                <option value="1" <?= ($ficha->diagramacion == 1) ? 'selected="selected"' : '' ?>>Pendiente</option>
                                <option value="2" <?= ($ficha->diagramacion == 2) ? 'selected="selected"' : '' ?>>En proceso</option>
                                <option value="3" <?= ($ficha->diagramacion == 3) ? 'selected="selected"' : '' ?>>Finalizada</option>
                            </select>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td class="titulo">Servicio <span class="red">*</span></td>
                    <td>
                            <select data-placeholder="Seleccione un Servicio" name="servicio_codigo" class="chzn-select">
                                <option value=""></option>
                                <?php
                                foreach ($servicios as $servicio) {
                                    echo '<option value="' . $servicio->codigo . '" ' . ( ($ficha->servicio_codigo == $servicio->codigo) ? 'selected="selected"' : '' ) . '>' . $servicio->nombre . '</option>';
                                }
                                ?>
                            </select>

                    </td>
                </tr>
                <td class="titulo">Código <span class="red">*</span></td>
                <td>
                    <input size="6" type="text" disabled="disabled" value="<?= $ficha->Servicio->codigo ?>" /> - <input size="6" name="correlativo" type="text" value="<?= $ficha->correlativo ?>" />
                </td>

                <?php
                if(isset($flujo) && ($flujo)) {
                    $campos = array(
                        array('label' => "Nombre del Flujo", 'relevant' => 'true', 'field' => 'titulo', 'type' => 'input'),
                        array('label' => "Resumen", 'id' => 'editorA', 'relevant' => 'true', 'field' => 'objetivo', 'type' => 'textarea'),
                        array('label' => "Contenido", 'id' => 'editorB', 'field' => 'beneficiarios', 'type' => 'textarea')
                    );
                } else {
                    $campos = array(
                        array('label' => "Nombre del Trámite", 'relevant' => 'true', 'field' => 'titulo', 'type' => 'input'),
                        array('label' => "Descripción", 'id' => 'editorA', 'relevant' => 'true', 'field' => 'objetivo', 'type' => 'textarea'),
                        array('label' => "Beneficiarios", 'id' => 'editorB', 'field' => 'beneficiarios', 'type' => 'textarea'),
                        array('label' => "Documentos Requeridos", 'id' => 'editorG', 'field' => 'doc_requeridos', 'type' => 'textarea'),
                        array('label' => "Trámite Online", 'id' => 'editorH', 'field' => 'guia_online', 'type' => 'textarea'),
                        array('label' => "Url Trámite Online", 'field' => 'guia_online_url', 'type' => 'input'),
                        array('label' => "Trámite Oficina", 'id' => 'editorI', 'field' => 'guia_oficina', 'type' => 'textarea'),
                        array('label' => "Trámite Telefónico", 'id' => 'editorJ', 'field' => 'guia_telefonico', 'type' => 'textarea'),
                        array('label' => "Trámite Carta", 'id' => 'editorK', 'field' => 'guia_correo', 'type' => 'textarea'),
                        array('label' => "Tiempo de Realización", 'id' => 'editorF', 'field' => 'plazo', 'type' => 'textarea'),
                        array('label' => "Vigencia", 'id' => 'editorD', 'field' => 'vigencia', 'type' => 'textarea'),
                        array('label' => "Costo", 'id' => 'editorC', 'field' => 'costo', 'type' => 'textarea'),
                        array('label' => "Información Relacionada", 'id' => 'editorL', 'field' => 'cc_observaciones', 'type' => 'textarea'),
                        array('label' => "Marco Legal", 'id' => 'editorE', 'field' => 'marco_legal', 'type' => 'textarea')
                    );
                }
                
                $comentarios = json_decode($ficha->comentarios,true);

                foreach ($campos as $campo) {
                    echo "<tr>";
                    if(isset($comentarios[$campo['field']]) && $comentarios[$campo['field']] ){
                        echo "<td class='titulo ttip' title='<div class=\"tooltip_content\">Comentario de la revisión anterior para ".$campo['label'].": <br/><br/>".$comentarios[$campo['field']]." </div>'>";
                        echo "<img src='".  site_url('assets/images/comment.png')."' />";
                    }else{
                        echo "<td class='titulo'>";
                    }
                    echo $campo['label'];
                    if (isset($campo['relevant']) && $campo['relevant'] == true) {
                        echo "<span class='red'>*</span>";
                    }
                    echo "</td>";
                    echo "<td>";
                    if ($campo['type'] == 'input') {
                        echo "<input type='text' name='" . $campo['field'] . "' size='64' value='" . $ficha->$campo['field'] . "' />";
                    } else {
                        echo "<textarea id='" . $campo['id'] . "' name='" . $campo['field'] . "' cols='65' rows='15'>" . $ficha->$campo['field'] . "</textarea>";
                    }
                    echo "<div class='comentario_wrap'>";
                    echo "<span class='comentario'>Clic aquí para comentar respecto a los cambios de " . $campo['label'] . "</span>";
                    echo "<textarea class='comentario_texto' name='comentario[" . $campo['field'] . "]' cols='65' rows='5'>";
                    
                    echo "</textarea>";
                    echo "</div>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </fieldset>

        <fieldset>
            <legend>Clasificación</legend>
            <table class="formTable">
                <tr>
                    <td class="titulo">Público objetivo</td>
                    <td>
                        <label><input type="radio" name="tipo" id="personas" value="1" <?= ($ficha->tipo==1 || !$ficha->tipo) ? 'checked="checked"' : '' ?> /> Personas</label>
                        <label><input type="radio" name="tipo" id="empresas" value="2" <?= ($ficha->tipo==2) ? 'checked="checked"' : '' ?> /> Empresas</label>
                        <label><input type="radio" name="tipo" id="ambos" value="3" <?= ($ficha->tipo==3) ? 'checked="checked"' : '' ?> /> Ambos</label>
                    </td>
                </tr>
            </table>
            <div id="clasificacion-personas" style="<?= ($ficha->tipo==1 || $ficha->tipo==3 || $ficha->tipo==0) ? 'display:block' : 'display:none' ?>">
                <table class="formTable">
                    <tr>
                        <td class="titulo">Rangos de Edad</td>
                        <td>
                            <input type="text" name="rangos" value="<?= $ficha->showRangosAsString() ?>" /> Ej: 15-30,40-65
                        </td>
                    </tr>
                    <tr>
                        <td class="titulo">Género</td>
                        <td>
                            <select data-placeholder="Seleccione el Género" name="genero" class="chzn-select" style="width: 300px;">
                                <option value=""></option>
                                <?php
                                foreach ($generos as $genero) {
                                    echo '<option value="' . $genero->id . '" ' . ( ($ficha->genero_id == $genero->id) ? 'selected="selected"' : '' ) . '>' . $genero->nombre . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="titulo">Temas</td>
                        <td>
                            <select data-placeholder="Seleccione su(s) Tema(s)" name="temas[]" multiple class="chzn-select" style="width:550px;">
                                <?php foreach ($temas as $tema): ?>
                                    <option value="<?= $tema->id ?>" <?php if ($ficha->hasTema($tema->id))
                                    echo 'selected="selected"' ?> ><?= $tema->nombre ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td class="titulo">Hechos de Vida</td>
                        <td class="widgetSelectTable">
                            <select class="chzn-select" data-placeholder="Seleccionar hecho de vida" style="width: 300px;">
                                <option></option>
                                <?php foreach ($etapasvida as $e): ?>
                                    <optgroup label="<?= $e->nombre ?>">
                                        <?php
                                        foreach ($e->HechosVida as $h):
                                            ?>
                                            <?php
                                            $eta = ' ( ';
                                            foreach ($etapasvida as $etapa):
                                                if ($h->hasEtapa($etapa->id))
                                                    $eta .= $etapa->nombre . ' ';
                                            endforeach;
                                            $eta .= ')';
                                            ?>
                                            <option value="<?= $h->id ?>" otro="<?= $h->nombre . $eta ?>"><?= $h->nombre ?></option>
                                            <?php
                                        endforeach;
                                        ?>
                                    </optgroup>

                                <?php endforeach; ?>
                            </select>
                            <input type="button" value="Agregar" class="agregar" />

                            <table id="tablaHV" style="border: 1px solid #ccc; margin-top: 5px;">
                                <thead>
                                    <tr>
                                        <td style="background-color:#e1e1e1; font-weight: bold; text-align: center;">Hecho de la Vida</td>
                                        <td style="background-color:#e1e1e1; font-weight: bold;">Acción</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $cnt = 1;
                                    foreach ($ficha->HechosVida as $h):
                                        $color = ($cnt & 1) ? '#FFF' : '#EDEDED';
                                        ?>
                                        <tr style="background-color: <?= $color ?>">
                                            <td>
                                                <span style="font-weight: bold;"><?= $h->nombre ?></span>
                                                <?php
                                                $eta = '( ';
                                                foreach ($etapasvida as $etapa):
                                                    if ($h->hasEtapa($etapa->id))
                                                        $eta .= $etapa->nombre . ' ';
                                                endforeach;
                                                $eta .= ')';
                                                echo $eta;
                                                ?>
                                                <input type="hidden" name="hechosvida[]" value="<?= $h->id ?>" />
                                            </td>
                                            <td><a class="eliminar" href="#">Eliminar</a></td>
                                        </tr>
                                        <?php
                                        $cnt++;
                                    endforeach;
                                    ?>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <table class="formTable">
                <tr>
                    <td class="titulo">Tags</td>
                    <td>
                        <ul style="width: 535px;" class="tagitTags">
                            <?php foreach ($ficha->Tags as $tag): ?>
                                <li class="tagit-choice">
                                    <?= $tag->nombre ?>
                                    <a class="close">x</a>
                                    <input type="hidden" name="tags[]" value="<?= $tag->nombre ?>" />
                                </li>
                            <?php endforeach; ?>

                        </ul>
                    </td>
                </tr>
                <?php if(isset($editar_ext) && $editar_ext): ?>
                <tr>
                    <td class="titulo">Destacada?</td>
                    <td><input type="checkbox" name="destacado" <?= ($ficha->destacado) ? 'checked="checked"' : '' ?> /></td>
                </tr>
                <tr>
                    <td class="titulo">Keywords</td>
                    <td>
                        <input style="width: 535px;" type="text" name="keywords" value="<?=$ficha->keywords?>" />
                    </td>
                </tr>
                <tr>
                    <td class="titulo">Sic</td>
                    <td>
                        <input style="width: 535px;" type="text" name="sic" value="<?=$ficha->sic?>" />
                    </td>
                </tr>
                <?php endif; ?>
            </table>
        </fieldset>

        <?php
        if (UsuarioBackendSesion::usuario()->tieneRol('publicador')) {
            if ($ficha->cc_id || $ficha->cc_formulario || $ficha->cc_llavevalor) {
                ?>
                <fieldset>
                    <legend>Información Adicional</legend>
                    <table class="formTable">
                        <?php
                        if ($ficha->cc_id) {
                            ?>
                            <tr>
                                <td class="titulo">CC ID</td>
                                <td><?= $ficha->cc_id ?></td>
                            </tr>
                            <?php
                        }
                        if ($ficha->cc_formulario) {
                            ?>
                            <tr>
                                <td class="titulo">CC Formulario</td>
                                <td><?= $ficha->cc_formulario ?></td>
                            </tr>
                            <?php
                        }
                        if ($ficha->cc_llavevalor) {
                            ?>
                            <tr>
                                <td class="titulo">CC LLave Valor</td>
                                <td><?= $ficha->cc_llavevalor ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </fieldset>
                <?php
            }
        }
        ?>

        <table>
            <tr><td colspan="2"><p class="red">* Campos Obligatorios</p></td></tr>
            <tr>
                <td colspan="2" class="botones">
                    <?php $this->load->view('backend/widgets/botones.php') ?>
                </td>
            </tr>
        </table>

    </form>
</div>
<script>
$("td.ttip").tooltip({'effect':'fade'});
</script>
