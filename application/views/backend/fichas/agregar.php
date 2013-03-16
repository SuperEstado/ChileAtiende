<?php
$titulo = ( $flujo ) ? 'Flujo' : 'Ficha';
?>
<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <a href="<?= site_url( ( $flujo ) ? 'backend/fichas/listarflujos' : 'backend/fichas' ) ?>"><?= $titulo ?></a> »
    <span>Agregar <?=$titulo?></span>
</div>

<div class="pane">
    <h2>Agregar <?=  strtolower($titulo)?></h2>
    <form class="ajaxForm" method="post" action="<?= site_url('backend/fichas/'. ( ( $flujo ) ? 'agregar_flujo' : 'agregar_form' ) ) ?>">
        <fieldset>
            <legend>Datos <?=  strtolower($titulo)?></legend>
            <div class="validacion"></div>
            <table class="formTable">
                <?php if (UsuarioBackendSesion::usuario()->tieneRol(array('publicador'))) { ?>
                    <tr>
                        <td class="titulo">Diagramación</td>
                        <td>
                            <select data-placeholder="Estado  <?= ( $flujo ) ? 'del flujo' : 'de la ficha'; ?>" name="diagramacion" class="chzn-select" style="width: 150px;">
                                <option value="NULL"></option>
                                <option value="1">Pendiente</option>
                                <option value="2">En proceso</option>
                                <option value="3">Finalizada</option>
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
                <tr>
                    <td class="titulo">Código <span class="red">*</span></td>
                    <td>
                            <input size="6" type="text" class="codigo_preview" disabled="disabled"> 

                        - <input size="6" title="Corresponde al Código Único e Identificatorio del Proyecto utizando la nomenclatura propuesta por Segpres. Ej: AJ001-1" type="text" name="correlativo" />
                        <a href="#" onclick="return generarCodigo()">Generar</a>
                    </td>
                </tr>
                <tr>
                    <td class="titulo">Nombre del <?= ($flujo) ? 'Flujo' : 'Trámite'; ?> <span class="red">*</span></td>
                    <td><input type="text" name="titulo" size="64" value="" /></td>
                </tr>
                <tr>
                    <td class="titulo"><?= ($flujo) ? 'Resumen' : 'Descripción'; ?> <span class="red">*</span></td>
                    <td><textarea id="editorA" name="objetivo" cols="65" rows="15"></textarea></td>
                </tr>
                <tr>
                    <td class="titulo"><?= ($flujo) ? 'Contenido' : 'Beneficiarios'; ?></td>
                    <td><textarea id="editorB" name="beneficiarios" cols="65" rows="15"></textarea></td>
                </tr>
                <!-- si es un flujo, ocultamos estos campos -->
                <?php
                if(!$flujo) {
                ?>
                <tr>
                    <td class="titulo">Documentos Requeridos</td>
                    <td><textarea id="editorG" name="doc_requeridos" cols="65" rows="15"></textarea></td>
                </tr>
                <tr>
                    <td class="titulo">Trámite Online</td>
                    <td><textarea id="editorH" name="guia_online" cols="65" rows="15"></textarea></td>
                </tr>
                <tr>
                    <td class="titulo">Url Trámite Online</td>
                    <td><input type="text" name="guia_online_url" size="64" value="" /></td>
                </tr>
                <tr>
                    <td class="titulo">Trámite Oficina</td>
                    <td><textarea id="editorI" name="guia_oficina" cols="65" rows="15"></textarea></td>
                </tr>
                <tr>
                    <td class="titulo">Trámite Telefónico</td>
                    <td><textarea id="editorJ" name="guia_telefonico" cols="65" rows="15"></textarea></td>
                </tr>
                <tr>
                    <td class="titulo">Trámite Carta</td>
                    <td><textarea id="editorK" name="guia_correo" cols="65" rows="15"></textarea></td>
                </tr>
                <tr>
                    <td class="titulo">Tiempo Realización</td>
                    <td><textarea id="editorF" name="plazo" cols="65" rows="15"></textarea></td>
                </tr>
                <tr>
                    <td class="titulo">Vigencia</td>
                    <td><textarea id="editorD" name="vigencia" cols="65" rows="15"></textarea></td>
                </tr>
                <tr>
                    <td class="titulo">Costo</td>
                    <td><textarea id="editorC" name="costo" cols="65" rows="15"></textarea></td>
                </tr>
                <tr>
                    <td class="titulo">Información Relacionada</td>
                    <td><textarea id="editorL" name="cc_observaciones" cols="65" rows="15"></textarea></td>
                </tr>
                <tr>
                    <td class="titulo">Marco Legal</td>
                    <td><textarea id="editorE" name="marco_legal" cols="65" rows="15"></textarea></td>
                </tr>
                <?php
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
                        <label><input type="radio" name="tipo" id="personas" /> Personas</label>
                        <label><input type="radio" name="tipo" id="empresas"/> Empresas</label>
                        <label><input type="radio" name="tipo" id="ambos"/> Ambos</label>
                    </td>
                </tr>
            </table>
            <div id="clasificacion-personas" style="display:none">
                <table class="formTable">
                    <tr>
                        <td class="titulo">Rangos de Edad</td>
                        <td>
                            <input type="text" name="rangos"  /> Ej: 15-30,40-65
                        </td>
                    </tr>
                    <tr>
                        <td class="titulo">Género</td>
                        <td>
                            <select data-placeholder="Seleccione el Género" name="genero" class="chzn-select" style="width: 300px;">
                                <option value=""></option>
                                <?php
                                foreach ($generos as $genero) {
                                    echo '<option value="' . $genero->id . '" >' . $genero->nombre . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="titulo">Temas</td>
                        <td>
                            <select data-placeholder="Seleccione su(s) Tema(s)" name="temas[]" multiple class="chzn-select" style="width:550px;">
                                <option value=""></option>
                                <?php foreach ($temas as $tema): ?>
                                    <option value="<?= $tema->id ?>"><?= $tema->nombre ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="titulo">Hechos de Vida</td>
                        <td class="widgetSelectTable">
                            <select class="chzn-select"  data-placeholder="Seleccionar hecho de vida" style="width: 300px;">
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
                                <tbody></tbody>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <table class="formTable">
                <tr>
                    <td class="titulo">Tags</td>
                    <td>
                        <ul style="width: 535px;" class="tagitTags"></ul>
                    </td>
                </tr>
            </table>
        </fieldset>

        <table>
            <tr>
                <td><p class="red">* Campos Obligatorios</p></td>
            </tr>
            <tr>
                <td class="botones">
                    <?php $this->load->view('backend/widgets/botones.php') ?>
                </td>
            </tr>
        </table>
    </form>
</div>
