<?php
$txt_titulo = ($flujos) ? 'Flujos' : 'Fichas';
?>
<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <?php
    if ($flujos) {
        echo 'Flujos';
    } else {
        echo ($this->uri->segment(4)) ? '<a href="' . site_url('backend/fichas') . '">Fichas</a>' : '<span>Fichas</span>';

        switch ($this->uri->segment(4)) {
            case 'creadas':
                echo ' » En Borrador';
                break;
            case 'enrevision':
                echo ' » En Revisión';
                break;
            case 'rechazado':
                echo ' » Con Observaciones';
                break;
            case 'nopublicados':
                echo ' » No Publicadas';
                break;
            case 'actualizables':
                echo ' » Actualizables';
                break;
            case 'destacado':
                echo ' » Destacadas';
                break;
            case 'chileclic':
                echo ' » ChileClic';
                break;
            case 'publicados':
                echo ' » Publicadas';
                break;
        }
    }
    ?>
</div>

<div class="pane">
    <h2><?= $txt_titulo ?></h2>

    <?php $this->load->view('backend/widgets/filtro_institucion') ?>

    <p><a class="boton" href="<?= site_url('backend/fichas/' . ( ($flujos) ? 'agregarflujo' : 'agregar' )) ?>"><img src="assets/images/backend/add.png" /> Agregar <?= ( ($flujos) ? 'flujo' : 'ficha' ) ?></a></p>

    <?php $this->load->view('backend/widgets/filtro_titulo') ?>
    <?php $this->load->view('backend/widgets/filtro_publico') ?>

    <div class="contador"><span>Mostrando <?= $offset + 1 ?> - <?= min($offset + $per_page, $total) ?> de <?= $total ?> resultados</span></div>

    <table class="display tabla" id="tablafichas">
        <thead>
            <?php
            $orden = $imagen_id = $imagen_titulo = $imagen_publicado = $imagen_updated = $img = '';

            /* Veo si hay order by para los campos */
            $field = $this->input->get('field');
            if ($field) {

                $order_by = $this->input->get('order_by');

                if ($order_by) {

                    $orden = (strpos($order_by, "ASC") === FALSE) ? "ASC" : "DESC";
                    $img = ($orden == "ASC") ? 'arrow_up.png' : 'arrow_down.png';
                    $img = "<img src='assets/images/backend/" . $img . "' border='0' />";

                    $imagen_id = ($field == 'id') ? $img : '';
                    $imagen_titulo = ($field == 'titulo') ? $img : '';
                    $imagen_publicado = ($field == 'publicado') ? $img : '';
                    $imagen_updated = ($field == 'updated_at') ? $img : '';
                }
            }
            ?>
            <tr>
                <th class="sortable">
                    <?=anchor(site_url('backend/fichas/'. ( ($flujos) ? 'listarflujos' : 'index' ) .'/' . $this->uri->segment(4) . '?field=id&order_by=f.servicio_codigo ' . ( ($orden) ? $orden : 'DESC' ) . ', f.correlativo ' . ( ($orden) ? $orden : 'DESC' ) .'&offset=' . $this->input->get('offset')),"Código");?>
                    <?= $imagen_id ?>
                </th>
                <?php if ($this->user->tieneRol('publicador')) { ?><th class="sortable"><a href="<?= site_url('backend/fichas/'. ( ($flujos) ? 'listarflujos' : 'index' ) .'/' . $this->uri->segment(4) . '?field=publicado&order_by=f.servicio_codigo ' . ( ($orden) ? $orden : 'DESC' ) . '&offset=' . $this->input->get('offset')) ?>">Institución</a></th><?php } ?>
                <th class="sortable"><a href="<?= site_url('backend/fichas/'. ( ($flujos) ? 'listarflujos' : 'index' ) .'/' . $this->uri->segment(4) . '?field=titulo&order_by=f.titulo ' . ( ($orden) ? $orden : 'DESC' ) . '&offset=' . $this->input->get('offset')) ?>">Nombre del <?= ( ($flujos) ? 'flujo' : 'trámite' ) ?></a></th>
                <th>Dest.</th>
                <?php
                if ($this->uri->segment(4) != "publicados") {
                    ?>
                <th class="sortable"><a href="<?= site_url('backend/fichas/'. ( ($flujos) ? 'listarflujos' : 'index' ) .'/' . $this->uri->segment(4) . '?field=publicado&order_by=f.estado ' . ( ($orden) ? $orden : 'DESC' ) . '&offset=' . $this->input->get('offset')) ?>">Estado</a></th>
                    <?php
                }
                ?>
                <th class="sortable"><a href="<?= site_url('backend/fichas/'. ( ($flujos) ? 'listarflujos' : 'index' ) .'/' . $this->uri->segment(4) . '?field=publicado&order_by=f.publicado ' . ( ($orden) ? $orden : 'DESC' ) . '&offset=' . $this->input->get('offset')) ?>">Publicado</a></th>
                <th class="sortable centrado" style="text-align:center;"><a href="<?= site_url('backend/fichas/'. ( ($flujos) ? 'listarflujos' : 'index' ) .'/' . $this->uri->segment(4) . '?field=updated_at&order_by=f.updated_at ' . ( ($orden) ? $orden : 'DESC' ) . '&offset=' . $this->input->get('offset')) ?>">Última<br/>Modificación</a></th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($fichas)) {
                $cnt = 1;
                foreach ($fichas as $ficha) {
                    $color = ($cnt & 1) ? '#FFF' : '#EDEDED';
                    ?>
                    <tr style="background-color: <?= $color ?>">
                        <td><span style="font-size:9px;"><?= $ficha->getCodigo() ?></span></td>
                        <?php if ($this->user->tieneRol('publicador')) { ?>
                            <td class="centrado"><?php echo $ficha->Servicio->nombre; ?></td>
                        <?php } ?>
                        <td><a title="<?= strip_tags($ficha->titulo) ?>" href="<?= site_url('backend/fichas/' . ( ($flujos) ? 'verflujo' : 'ver' ) . '/' . $ficha->id) ?>"><?= character_limiter($ficha->titulo, 100) ?></a></td>

                        <td class="centrado"><?= ($ficha->destacado) ? '<img src="assets/images/backend/tick.png" alt="Destacada" title="Destacada" />' : '<img src="assets/images/backend/cross.png" alt="No Destacada" title="No Destacada" />' ?></td>

                        <?php
                        if ($this->uri->segment(4) != "publicados") {
                            ?>
                            <td>
                                <?php 
                                switch($ficha->estado) { 
                                    case "en_revision":
                                        echo "Para revisión";
                                        break;
                                    case "rechazado":
                                        echo "Con observación";
                                        break;
                                    default:
                                        echo "";
                                        break;
                                }
                                ?>
                            </td>
                            <?php
                        }
                        ?>
                        <td class="centrado">
                            <?= $ficha->publicado ? '<img src="assets/images/backend/tick.png" alt="Publicado" title="Publicado" />' : anchor("backend/fichas/". ( ($flujos) ? 'publicarflujo' : 'publicar' ) ."/" . $ficha->id, '<img src="assets/images/backend/cross.png" alt="No Publicado" title="No Publicado" />') ?>
                            <?php
                            if (count($ficha->Temas) == 0 || count($ficha->HechosVida) == 0) {
                                ?>
                                <a alt="Atención. Esta ficha no tiene asociado un Tema y/o un Hecho de Vida" title="Atención. Esta ficha no tiene asociado un Tema y/o un Hecho de Vida" href="<?= site_url('backend/fichas/'. ( ($flujos) ? 'verflujo' : 'ver' ) .'/' . $ficha->id) ?>"><img src="assets/images/backend/exclamation.png" /></a>
                                <?php
                            }
                            if ($ficha->actualizable) {
                                ?>
                                <a alt="Atención. Esta ficha no está publicada en su última versión." title="Atención. Esta ficha no está publicada en su última versión." href="<?= site_url('backend/fichas/'. ( ($flujos) ? 'verflujo' : 'ver' ) .'/' . $ficha->id) ?>"><img src="assets/images/backend/arrow_join.png" /></a>
                                <?php
                            }
                            ?>
                        </td>

                        <td style="text-align:center;"><?php echo ($ficha->updated_at) ? strftime("%d/%m/%Y<br/>%H:%M", strtotime($ficha->updated_at)) : '' ?></td>
                        <td class="centrado">
                            <?php
                            if (( ($this->user->tieneRol('editor') ? '1' : '0') ) && !(($ficha->locked) ? '1' : '0')) {
                                ?>
                                <a title="<?= $ficha->titulo ?>" href="<?= site_url('backend/fichas/'. ( ($flujos) ? 'editarflujo' : 'editar' ) .'/' . $ficha->id) ?>"><img src="assets/images/backend/pencil.png" alt="Editar" title="Editar" /></a>
                                <?php
                            }

                            if (($this->user->tieneRol('publicador') ? '1' : '0') && (($ficha->locked) ? '1' : '0')) {
                                ?>
                                <a title="<?= $ficha->titulo ?>" href="<?= site_url('backend/fichas/'. ( ($flujos) ? 'editarflujo_ext' : 'editar_ext' ) .'/' . $ficha->id) ?>"><img src="assets/images/backend/pencil.png" alt="Editar Ext" title="Editar Ext" /></a>
                                <?php
                            }
                            ?>
                            <?php
                            if (UsuarioBackendSesion::usuario()->tieneRol( array('publicador','mantenedor') )) {
                            /* Se agrega esta condicion para evitar que una ficha en revision sea eliminada */
                            if (!$ficha->estado) {
                                ?>
                                <a href="<?= site_url('backend/fichas/'.( (($flujos)?'eliminarflujo':'eliminar') ).'/' . $ficha->id) ?>" onclick="return confirm('¿Está seguro que desea eliminar esta Ficha?')"><img src="assets/images/backend/delete.png" alt="Eliminar" title="Eliminar" /></a>
                            <?php                             
                            } }
                            ?>
                        </td>
                    </tr> 
                    <?php
                    $cnt++;
                }
            } else {
                ?>
                <tr>
                    <td colspan="8" class="noregistros">No se encontraron registros</td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <div class="contador"><span>Mostrando <?= $offset + 1 ?> - <?= min($offset + $per_page, $total) ?> de <?= $total ?> resultados</span></div>
    <?php echo $this->pagination->create_links() ?>
</div>
