<div class="breadcrumb">
    <a href="<?=site_url('backend/portada')?>">Administración</a> »
    <span>Hechos de Vida</span>
</div>

<div class="pane">
    <h2>Hechos de Vida</h2>
    
    <?= $this->session->flashdata('message') ? '<div class="message">' . $this->session->flashdata('message') . '</div>' : '' ?>
    <p><a class="boton" href="<?= site_url('backend/hechosvida/agregar') ?>"><img src="assets/images/backend/add.png" /> Agregar Hecho de Vida</a></p>
    
    <div class="contador"><span>Mostrando <?= $offset + 1 ?> - <?= min($offset + $per_page, $total) ?> de <?= $total ?> resultados</span></div>
    <table class="tabla">
        <tr>
            <th>Título</th>
            <th>Etapas</th>
            <th>Fecha Publicación</th>
            <th>Acción</th>
        </tr>
        <?php
        if (count($hechosvida)) {
        $cnt = 1;
        foreach ($hechosvida as $hecho) {
            $class = ($cnt & 1) ? 'odd' : 'even';
            
            //consulto si tiene Fichas asociadas
            $nroF = Doctrine::getTable('Ficha')->findNroFichasOnHechos($hecho->id);
        ?>
            <tr>
                <td class="<?=$class?>"><?= $hecho->nombre ?></td>
                <td class="<?=$class?>">
                    <?php 
                    foreach ($etapasvida as $etapa): 
                        echo ($hecho->hasEtapa($etapa->id)) ? $etapa->nombre.' ' : '';
                    endforeach; 
                    ?>
                </td>
                <td class="<?=$class?>"><?= strftime('%d/%m/%Y %H:%M', mysql_to_unix($hecho->created_at)) ?></td>
                <td class="<?=$class?>">
                    <a href="<?= site_url('backend/hechosvida/editar/' . $hecho->id) ?>"><img src="assets/images/backend/pencil.png" alt="Editar" title="Editar" /></a> 
                    <?php
                    //si una Hecho tiene al menos una Ficha asociada no se podrá eliminar
                    if(!$nroF->cnt) {
                    ?>
                    <a href="<?= site_url('backend/hechosvida/borrar/' . $hecho->id) ?>" onclick="return confirm('¿Está seguro que desea eliminar este Hecho de Vida?')"><img src="assets/images/backend/delete.png" alt="Eliminar" title="Eliminar" /></a>
                    <?php
                    }
                    ?>
                </td>
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
