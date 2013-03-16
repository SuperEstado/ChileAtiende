<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <span>Etapas de Vida</span>
</div>

<div class="pane">
    <h2>Etapas de Vida</h2>
    
    <?= $this->session->flashdata('message') ? '<div class="message">' . $this->session->flashdata('message') . '</div>' : '' ?>
    <p><a class="boton" href="<?= site_url('backend/etapasvida/agregar') ?>"><img src="assets/images/backend/add.png" /> Agregar Etapa de Vida</a></p>
    <table class="tabla">
        <tr>
            <th>Título</th>
            <th>Descripción</th>
            <th>Fecha Publicación</th>
            <th>Acción</th>
        </tr>
        <?php
        if (count($etapasvida)) {
            $cnt = 1;
            foreach ($etapasvida as $etapa) {
                $class = ($cnt & 1) ? 'odd' : 'even';
                
                //consulto si tiene Hechos de Vida asociados (HV)
                $nroHV = Doctrine::getTable('HechoVida')->obtieneHechos($etapa->id);
                ?>
                <tr>
                    <td class="<?= $class ?>"><a href="<?= site_url('backend/etapasvida/editar/' . $etapa->id) ?>"><?= $etapa->nombre ?></a></td>
                    <td class="<?= $class ?>"><?= $etapa->descripcion ?></td>
                    <td class="<?= $class ?>"><?= strftime('%d/%m/%Y %H:%M', mysql_to_unix($etapa->created_at)) ?></td>
                    <td class="centrado <?= $class ?>">
                        <a href="<?= site_url('backend/etapasvida/editar/' . $etapa->id) ?>"><img src="assets/images/backend/pencil.png" alt="Editar" title="Editar" /></a> 
                        <?php
                        //si una Etapa tiene al menos un Hecho asociado no se podrá eliminar
                        if(!$nroHV->cnt) {
                        ?>
                        <a href="<?= site_url('backend/etapasvida/borrar/' . $etapa->id) ?>" onclick="return confirm('¿Está seguro que desea eliminar esta Etapa de Vida?')"><img src="assets/images/backend/delete.png" alt="Eliminar" title="Eliminar" /></a>
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
</div>
