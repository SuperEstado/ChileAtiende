<div class="breadcrumb">
    <a href="<?=site_url('backend/portada')?>">Administración</a> »
    <span>Noticias</span>
</div>

<div class="pane">
    <h2>Noticias</h2>
    
    <?php 
    echo $this->session->flashdata('message');
    ?>
    
    <p><a class="boton" href="<?= site_url('backend/noticias/agregar') ?>"><img src="assets/images/backend/add.png" /> Agregar Noticia</a></p>
    
    <div class="contador"><span>Mostrando <?= $offset + 1 ?> - <?= min($offset + $per_page, $total) ?> de <?= $total ?> resultados</span></div>
    <?php
    $orden = (strpos($order_by, "ASC") === FALSE)?"ASC":"DESC";
    ?>
    <table class="tabla">
        <tr>
            <th><a href="<?= site_url('backend/noticias?order_by=n.titulo%20'. ( ($orden) ? $orden : 'DESC' ) . '&offset=' . $this->input->get('offset')) ?>">Título</a></th>
            <th><a href="<?= site_url('backend/noticias?order_by=n.publicado%20'. ( ($orden) ? $orden : 'DESC' ) . '&offset=' . $this->input->get('offset')) ?>">Publicado</a></th>
            <th><a href="<?= site_url('backend/noticias?order_by=n.created_at%20'. ( ($orden) ? $orden : 'DESC' ) . '&offset=' . $this->input->get('offset')) ?>">Fecha Publicación</a></th>
            <th>Acción</th>
        </tr>
        <?php
        if(count($noticias)) {
            $cnt = 1;
        foreach ($noticias as $noticia) {
            $class = ($cnt & 1) ? 'odd' : 'even';
        ?>
            <tr>
                <td class="<?=$class?>"><a href="<?= site_url('backend/noticias/editar/' . $noticia->id) ?>"><?= $noticia->titulo ?></a></td>
                <td class="<?=$class?>"><?= ($noticia->publicado) ? '<img src="assets/images/backend/tick.png" title="Publicada" alt="Publicada" />' : '<img src="assets/images/backend/cross.png" title="No publicada" alt="No publicada" />' ?></td>
                <td class="<?=$class?>"><?= strftime('%d/%m/%Y %H:%M', mysql_to_unix($noticia->created_at)) ?></td>
                <td class="<?=$class?>"><a href="<?= site_url('backend/noticias/editar/' . $noticia->id) ?>"><img src="assets/images/backend/pencil.png" alt="Editar" title="Editar" /></a> <a href="<?= site_url('backend/noticias/borrar/' . $noticia->id) ?>" onclick="return confirm('¿Está seguro que desea eliminar esta Noticia?')"><img src="assets/images/backend/delete.png" alt="Eliminar" title="Eliminar" /></a></td>
            </tr>
        <?php
        $cnt++;
        }
        } else {
        ?>
            <tr>
                <td colspan="4" class="noregistros">No se encontraron registros</td>
            </tr>
            <?php
        }
            ?>
    </table>
    
    <div class="contador"><span>Mostrando <?= $offset + 1 ?> - <?= min($offset + $per_page, $total) ?> de <?= $total ?> resultados</span></div>
    <?php echo $this->pagination->create_links() ?>
    
</div>
