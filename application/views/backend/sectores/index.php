<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <span>Sectores</span>
</div>

<div class="pane">
    <h2>Sectores</h2>

    <p><a class="boton" href="<?= site_url('backend/sectores/agregar') ?>"><img src="assets/images/backend/add.png" /> Agregar Sector</a></p>

    <table class="tabla">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Latitud</th>
                <th>Longitud</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($sectores)) {
                $cnt = 1;
                foreach ($sectores as $sector) {
                    $class = ($cnt & 1) ? 'odd' : 'even';
                    ?>
                    <tr class="<?=$class?>">
                        <td><?= $sector->nombre ?></td>
                        <td><?= $sector->tipo ?></td>
                        <td><?= $sector->lat ?></td>
                        <td><?= $sector->lng ?></td>
                        <td>
                            <?php
                            if (UsuarioBackendSesion::usuario()->tieneRol(array('publicador', 'mantenedor'))) {
                                ?>
                                <a href="<?= site_url('backend/sectores/editar/' . $sector->codigo) ?>"><img src="assets/images/backend/pencil.png" alt="Editar" title="Editar" /></a>
                                <a href="<?= site_url('backend/sectores/borrar/' . $sector->codigo) ?>" onclick="return confirm('¿Está seguro que desea eliminar este Sector?')"><img src="assets/images/backend/delete.png" alt="Eliminar" title="Eliminar" /></a>
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
                    <td colspan="5" class="noregistros">No se encontraron registros</td>
                </tr>
                <?php
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5"></td>
            </tr>
        </tfoot>
    </table>
</div>