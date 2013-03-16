<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <a href="<?= site_url('backend/'. ( ($flujo) ? 'fichas/listarflujos' : 'fichas' ) ) ?>"><?= ($flujo) ? 'Flujos' : 'Fichas' ?></a> »
    <span>Ver <?= ($flujo) ? 'Flujo' : 'Ficha' ?> #<?= $ficha->id ?></span>
</div>

<div class="pane">

    <?php $this->load->view('backend/fichas/menu', array('tab' => 'ver', 'flujo' => $flujo)) ?>

    <h2><?= $ficha->titulo ?></h2>

    <?php

    $message = $this->session->flashdata('message');
    if ($message) {
        echo '<ul class="message">';
        echo '<li>';
        echo '<div class="mensaje">'.$message.'</div>';
        echo '</li>';
        echo '</ul>';
    }

    $editar = ($ficha->estado == 'en_revision') ? '' : "[".anchor(site_url('backend/fichas/'.( ($flujo) ? 'editarflujo' : 'editar' ).'/'.$ficha->id),'Editar')."]";

    $error = '';
    $errorRechazo = '';

    $txt_fichaflujo = ($flujo) ? 'Este flujo' : 'Esta ficha';

    if(!UsuarioBackendSesion::usuario()->tieneRol('publicador')){
        if($ficha->estado == 'en_revision') {
            $error .= '<li>';
            $error .= '<div class="mensaje"><strong>Atención.</strong> '.$txt_fichaflujo.' no se puede editar porque se encuentra en proceso de revisión</div>';
            $error .= '</li>';
        }
    }

    if($ficha->estado == 'rechazado') {
        $errorRechazo .= '<li>';
        $errorRechazo .= '<div class="mensaje"><strong>'.$txt_fichaflujo.' se encuentra con las siguientes observaciones:</strong> <br />' . $ficha->estado_justificacion . '</div>';
        $errorRechazo .= '</li>';
    }

    if (UsuarioBackendSesion::usuario()->tieneRol('publicador')) {
        if ($ficha->actualizable) {
            $error .= '<li>';
            $error .= "<div class='mensaje'><strong>Atención.</strong> $txt_fichaflujo no está publicada en su última versión. La versión publicada actualmente es la # ". $ficha->getVersionPublicada()->id . "<br /> [<a class='popupcompara' href='" . site_url('backend/fichas/ajax_ficha_comparar/' . $ficha->getUltimaVersion()->id . '/' . $ficha->getVersionPublicada()->id) . "'>Comparar</a>] [<a href='" . site_url('backend/fichas/'.( ($flujo)?'publicarflujo':'publicar' ).'/' . $ficha->id) . "'>Actualizar</a>]</div>";
            $error .= '</li>';
        }
    }

    if (!$ficha->beneficiarios) {
        $error .= '<li>';
        $error .= "<div class='mensaje'><strong>Atención.</strong> $txt_fichaflujo no tiene Beneficiarios asociado $editar </div>";
        $error .= '</li>';
    }

    if(!$flujo) {
        if (!$ficha->doc_requeridos) {
            $error .= '<li>';
            $error .= "<div class='mensaje'><strong>Atención.</strong> Esta ficha no tiene Documentos requeridos asociado $editar </div>";
            $error .= '</li>';
        }
        if (!($ficha->guia_online && $ficha->guia_online_url)) {
            $error .= '<li>';
            $error .= "<div class='mensaje'><strong>Atención.</strong> Esta ficha no tiene un Trámite Online+URL asociado $editar </div>";
            $error .= '</li>';
        }
        if (!$ficha->guia_oficina) {
            $error .= '<li>';
            $error .= "<div class='mensaje'><strong>Atención.</strong> Esta ficha no tiene un Trámite oficina asociado $editar </div>";
            $error .= '</li>';
        }
        if (!$ficha->guia_telefonico) {
            $error .= '<li>';
            $error .= "<div class='mensaje'><strong>Atención.</strong> Esta ficha no tiene un Trámite telefónico asociado $editar </div>";
            $error .= '</li>';
        }
        if (!$ficha->guia_correo) {
            $error .= '<li>';
            $error .= "<div class='mensaje'><strong>Atención.</strong> Esta ficha no tiene un Trámite carta asociado $editar </div>";
            $error .= '</li>';
        }
        if (!$ficha->plazo) {
            $error .= '<li>';
            $error .= "<div class='mensaje'><strong>Atención.</strong> Esta ficha no tiene un Tiempo de realizacion asociado $editar </div>";
            $error .= '</li>';
        }
        if (!$ficha->vigencia) {
            $error .= '<li>';
            $error .= "<div class='mensaje'><strong>Atención.</strong> Esta ficha no tiene una Vigencia asociado $editar </div>";
            $error .= '</li>';
        }
        if (!$ficha->costo) {
            $error .= '<li>';
            $error .= "<div class='mensaje'><strong>Atención.</strong> Esta ficha no tiene un Costo asociado $editar </div>";
            $error .= '</li>';
        }
        if (!$ficha->marco_legal) {
            $error .= '<li>';
            $error .= "<div class='mensaje'><strong>Atención.</strong> Esta ficha no tiene un Marco legal asociado $editar </div>";
            $error .= '</li>';
        }
    }

    if (!$ficha->showRangosAsString()) {
        $error .= '<li>';
        $error .= "<div class='mensaje'><strong>Atención.</strong> $txt_fichaflujo no tiene un Rango de edad asociado $editar </div>";
        $error .= '</li>';
    }
    if (!$ficha->genero_id) {
        $error .= '<li>';
        $error .= "<div class='mensaje'><strong>Atención.</strong> $txt_fichaflujo no tiene un Género asignado $editar </div>";
        $error .= '</li>';
    }

    if($ficha->tipo!=2) { //no muestra si la ficha es de empresa
        if (count($ficha->Temas) == 0) {
            $error .= '<li>';
            $error .= "<div class='mensaje'><strong>Atención.</strong> $txt_fichaflujo no tiene Temas asociados $editar </div>";
            $error .= '</li>';
        }
        if (count($ficha->HechosVida) == 0) {
            $error .= '<li>';
            $error .= "<div class='mensaje'><strong>Atención.</strong> $txt_fichaflujo no tiene Hechos de Vida asociados $editar </div>";
            $error .= '</li>';
        }
    }



    if($errorRechazo) {
        echo '<ul class="updateWarningsRechazado">'.$errorRechazo.'</ul>';
    }
    if($error) {
        echo '<ul class="updateWarnings">'.$error.'</ul>';
    }

    if(UsuarioBackendSesion::usuario()->tieneRol('aprobador')){
            if (!$ficha->locked)
                echo '<div style="text-align: center;"><a class="boton" href="' . site_url('backend/fichas/'.( ($flujo)?'aprobarflujo':'aprobar' ).'/' . $ficha->id) . '">Enviar a revisión</a></div>';
        }
    ?>

    <table class="formTable">
        <tr>
            <td style="font-weight: bold; background-color: #EDEDED">Código</td>
            <td style="background-color: #EDEDED">
                <?= $ficha->getCodigo() ?>
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold; background-color: #EDEDED">Servicio</td>
            <td style="background-color: #EDEDED">
                <?= $ficha->Servicio->nombre ?>
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Nombre del <?= ( ($flujo) ? 'flujo' : 'trámite' ) ?></td>
            <td><?= $ficha->titulo ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold; background-color: #EDEDED;">Descripción</td>
            <td style="background-color: #EDEDED"><?= prepare_content_ficha($ficha->objetivo) ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Beneficiarios</td>
            <td><?= prepare_content_ficha($ficha->beneficiarios) ?></td>
        </tr>
        <!-- si es un flujo, ocultamos estos campos -->
        <?php
        if(!$flujo) {
        ?>
        <tr>
            <td style="font-weight: bold; background-color: #EDEDED">Documentos requeridos</td>
            <td style="background-color: #EDEDED"><?= prepare_content_ficha($ficha->doc_requeridos) ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Guía Online</td>
            <td><?= prepare_content_ficha($ficha->guia_online) ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold; background-color: #EDEDED">Guía online URL</td>
            <td style="background-color: #EDEDED"><?= prepare_content_ficha($ficha->guia_online_url) ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Guía Oficina</td>
            <td><?= prepare_content_ficha($ficha->guia_oficina) ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold; background-color: #EDEDED">Guía telefónico</td>
            <td style="background-color: #EDEDED"><?= prepare_content_ficha($ficha->guia_telefonico) ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Guía Correo</td>
            <td><?= prepare_content_ficha($ficha->guia_correo) ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold; background-color: #EDEDED">Tiempo relización</td>
            <td style="background-color: #EDEDED"><?= prepare_content_ficha($ficha->plazo) ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Vigencia</td>
            <td><?= prepare_content_ficha($ficha->vigencia) ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold; background-color: #EDEDED">Costo</td>
            <td style="background-color: #EDEDED"><?= prepare_content_ficha($ficha->costo) ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Información relacionada</td>
            <td><?= prepare_content_ficha($ficha->cc_observaciones) ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold; background-color: #EDEDED">Marco legal</td>
            <td style="background-color: #EDEDED"><?= prepare_content_ficha($ficha->marco_legal) ?></td>
        </tr>
        <?php
        }
        ?>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center; color: #000; background-color: #CCC; font-weight: bold;">Clasificación</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Destacada</td>
            <td><?= ($ficha->destacado) ? 'Si' : 'No' ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold; background-color: #EDEDED">Temas</td>
            <td style="background-color: #EDEDED">
                <?php foreach ($ficha->Temas as $tema) {
                    echo $tema->nombre . ' ';
                } ?>
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Tipo</td>
            <td><?php if ($ficha->tipo == 1) { echo 'Personas'; } elseif($ficha->tipo == 2) { echo 'Empresas'; } else { echo 'Ambos'; }  ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold; background-color: #EDEDED">Hechos de la vida</td>
            <td style="background-color: #EDEDED">
                <?php
                foreach ($ficha->HechosVida as $h) {

                    $eta = ' ( ';
                    foreach ($etapasvida as $etapa):
                        if ($h->hasEtapa($etapa->id))
                            $eta .= $etapa->nombre . ' ';
                    endforeach;
                    $eta .= ')';

                    echo $h->nombre . ' ' . $eta.'<br />';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Género</td>
            <td><?= $ficha->Genero->nombre ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold; background-color: #EDEDED">Rango edad</td>
            <td style="background-color: #EDEDED"><?= $ficha->showRangosAsString() ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Tags</td>
            <td>
                <?php foreach ($ficha->Tags as $tag): ?>

                        <?= $tag->nombre ?>


                <?php endforeach; ?>
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold; background-color: #EDEDED">Keywords</td>
            <td style="background-color: #EDEDED"><?= $ficha->keywords ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Sic</td>
            <td><?= $ficha->sic ?></td>
        </tr>
        <?php
        if (UsuarioBackendSesion::usuario()->tieneRol('publicador')) {
            if ($ficha->cc_id || $ficha->cc_formulario || $ficha->cc_llavevalor) {
                ?>
                <tr>
                    <td colspan="2" style="text-align: center; color: #000; background-color: #CCC; font-weight: bold;">Información Adicional</td>
                </tr>
                <?php
                if ($ficha->cc_id) {
                    ?>
                    <tr>
                        <td style="font-weight: bold;">CC ID</td>
                        <td><?= $ficha->cc_id ?></td>
                    </tr>
                    <?php
                }
                if ($ficha->cc_formulario) {
                    ?>
                    <tr>
                        <td style="font-weight: bold; background-color: #EDEDED">CC Formulario</td>
                        <td style="background-color: #EDEDED"><?= $ficha->cc_formulario ?></td>
                    </tr>
                    <?php
                }
                if ($ficha->cc_llavevalor) {
                    ?>
                    <tr>
                        <td style="font-weight: bold;">CC LLave Valor</td>
                        <td><?= $ficha->cc_llavevalor ?></td>
                    </tr>
                    <?php
                }
            }
        }
        ?>
    </table>

    <div style="text-align: center;">
        <?php

        if(UsuarioBackendSesion::usuario()->tieneRol('publicador')){

            if ($ficha->locked){
                //echo '<a class="boton" href="' . site_url('backend/fichas/rechazar/' . $ficha->id) . '">Rechazar</a>';
                echo '<a class="overlay boton" rel="#msgrechazar" href="'.site_url('#').'">Observaciones</a>';
                echo '<a class="boton" href="' . site_url('backend/fichas/'.( ($flujo)?'publicarflujo':'publicar' ).'/' . $ficha->id) . '">Publicar</a>';
            }
            else{
                if($ficha->publicado)
                    echo '<a class="boton" href="' . site_url('backend/fichas/'.( ($flujo)?'despublicarflujo':'despublicar' ).'/' . $ficha->id) . '">Despublicar</a>';
                //else
                    //echo '<a class="boton" href="' . site_url('backend/fichas/publicar/' . $ficha->id) . '">Publicar</a>';

            }

        }

        if(UsuarioBackendSesion::usuario()->tieneRol('aprobador')){
            if (!$ficha->locked)
                echo '<a class="boton" href="' . site_url('backend/fichas/'.( ($flujo)?'aprobarflujo':'aprobar' ).'/' . $ficha->id) . '">Enviar a revisión</a>';
        }
        ?>
    </div>

    <div id="msgrechazar" class="simpleOverlay">
        <form method="post" action="<?= site_url('backend/fichas/'.( ($flujo)?'rechazarflujo':'rechazar' ).'/' . $ficha->id) ?>">
            <table>
                <tr>
                    <td>Motivo por el que se realiza una observación al <?= ( ($flujo)?'flujo':'trámite' ) ?></td>
                </tr>
                <tr>
                    <td><textarea name="estado_justificacion" cols="110" rows="5"></textarea></td>
                </tr>
                <tr>
                    <td class="botones">
                        <button type="submit" class="agregar">Enviar</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
