<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <span>Flujos</span>
</div>


<div class="pane">
    <h2>Flujos</h2>
    
    <?= $this->session->flashdata('message') ? '<div class="message">' . $this->session->flashdata('message') . '</div>' : '' ?>
    <?php
    if ((UsuarioBackendSesion::usuario()->tieneRol('editor'))) {
    ?>
    <p><a class="boton" href="<?= site_url('backend/flujos/agregar') ?>"><img src="assets/images/backend/add.png" /> Agregar Flujo</a></p>
    <?php
    }
    ?>

    <table class="tabla">
        <thead>
            <tr>
                <th>Título</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($flujos)) {
                $cnt = 1;
                foreach ($flujos as $flujo) {
                    $class = ($cnt & 1) ? 'odd' : 'even';
                    ?>
                    <tr>
                        <td class="<?= $class ?>"><a title="<?= $flujo->titulo ?>" href="<?= site_url('backend/flujos/editar/' . $flujo->id) ?>"><?= character_limiter($flujo->titulo, 100) ?></a></td>
                        <td class="centrado <?= $class ?>">
                            <a href="<?= site_url('backend/flujos/editar/' . $flujo->id) ?>" ><img src="assets/images/backend/pencil.png" alt="Editar" title="Editar" /></a>
                            <a href="<?= site_url('backend/flujos/borrar/' . $flujo->id) ?>" onclick="return confirm('¿Está seguro que desea eliminar este Flujo?')"><img src="assets/images/backend/delete.png" alt="Eliminar" title="Eliminar" /></a>
                        </td>
                    </tr>
                    <?php
                    $cnt++;
                }
            } else {
                ?>
                <tr>
                    <td colspan="2" class="noregistros">No se encontraron registros</td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>

    <?= $this->pagination->create_links() ?>
</div>