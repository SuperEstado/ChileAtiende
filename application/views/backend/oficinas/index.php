<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <span>Oficinas</span>
</div>

<div class="pane">
    <h2>Oficinas</h2>

    <p><a class="boton" href="<?= site_url('backend/oficinas/agregar') ?>"><img src="assets/images/backend/add.png" /> Agregar Oficina</a></p>

    <table class="tabla">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Latitud</th>
                <th>Longitud</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($oficinas)) {
                $cnt = 1;
                foreach ($oficinas as $of) {
                    $class = ($cnt & 1) ? 'odd' : 'even';
                    ?>
                    <tr class="<?=$class?>">
                        <td><?= $of->nombre ?></td>
                        <td><?= $of->lat ?></td>
                        <td><?= $of->lng ?></td>
                        <td>
                            <?php
                            if (UsuarioBackendSesion::usuario()->tieneRol(array('publicador', 'mantenedor'))) {
                                ?>
                                <a href="<?= site_url('backend/oficinas/editar/' . $of->id) ?>"><img src="assets/images/backend/pencil.png" alt="Editar" title="Editar" /></a>
                                <a href="<?= site_url('backend/oficinas/borrar/' . $of->id) ?>" onclick="return confirm('¿Está seguro que desea eliminar esta Oficina?')"><img src="assets/images/backend/delete.png" alt="Eliminar" title="Eliminar" /></a>
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
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4"></td>
            </tr>
        </tfoot>
    </table>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.tabla tr').nth-child(even).style('color','#ccc');
        });
    </script>
</div>