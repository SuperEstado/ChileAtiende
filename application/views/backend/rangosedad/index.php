<div class="breadcrumb">
    <a href="<?=site_url('backend/portada')?>">Administración</a> »
    <span>Rangos de Edad</span>
</div>

<div>
    <h2>Rangos de Edad</h2>
    <p><a class="boton" href="<?= site_url('backend/rangosedad/agregar') ?>"><img src="assets/images/backend/add.png" style="padding-top: 5px;" /> Agregar Rango de Edad</a></p>
    <table class="tabla">
        <tr>
            <th>Id</th>
            <th>Edad Mínima</th>
            <th>Edad Máxima</th>
            <th>Acción</th>
        </tr>
        <?php
        foreach ($rangos as $rango) {
        ?>
            <tr>
                <td class="centrado"><?= $rango->id ?></td>
                <td class="centrado"><?= $rango->edad_minima ?></td>
                <td class="centrado"><?= $rango->edad_maxima ?></td>
                <td class="centrado">
                    <a href="<?= site_url('backend/rangosedad/editar/' . $rango->id) ?>" ><img src="assets/images/backend/pencil.png" alt="Editar Rando de Edad" title="Editar Rando de Edad" /></a>
                    <a href="<?= site_url('backend/rangosedad/borrar/' . $rango->id) ?>" onclick="return confirm('¿Está seguro que desea eliminar este Rango de Edad?')" ><img src="assets/images/backend/delete.png" alt="Borrar Rando de Edad" title="Borrar Rando de Edad" /></a>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>
</div>
