<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <span>Entidades</span>
</div>

<div class="pane">
    <h2>Entidades</h2>

    <p><a class="boton" href="<?= site_url('backend/entidades/agregar') ?>"><img src="assets/images/backend/add.png" /> Agregar Entidad</a></p>

    <table class="tabla">
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Sigla</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($entidades)) {
                $cnt = 1;
                foreach ($entidades as $e) {
                    $class = ($cnt & 1) ? 'odd' : 'even';
                    ?>
                    <tr class="<?=$class?>">
                        <td><?= $e->codigo ?></td>
                        <td><?= $e->nombre ?></td>
                        <td><?= $e->sigla ?></td>
                        <td>
                            <?php
                            if (UsuarioBackendSesion::usuario()->tieneRol(array('publicador', 'mantenedor'))) {
                                ?>
                                <a href="<?= site_url('backend/entidades/editar/' . $e->codigo) ?>"><img src="assets/images/backend/pencil.png" alt="Editar" title="Editar" /></a>
                                <a href="<?= site_url('backend/entidades/borrar/' . $e->codigo) ?>" onclick="return confirm('¿Está seguro que desea eliminar esta Entidad?')"><img src="assets/images/backend/delete.png" alt="Eliminar" title="Eliminar" /></a>
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