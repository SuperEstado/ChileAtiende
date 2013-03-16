<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <span>Temas</span>
</div>

<div class="pane">
    <h2>Listado Temas</h2>
    
    <?= $this->session->flashdata('message') ? '<div class="message">' . $this->session->flashdata('message') . '</div>' : '' ?>
    
    <p><a class="boton" href="<?= site_url('backend/temas/agregar') ?>"><img src="assets/images/backend/add.png" /> Agregar Tema</a></p>
    <table class="tabla">
        <tr>
            <th>Nombre</th>
            <th>Acción</th>
        </tr>
        <?php
        if (count($temas)) {
            $cnt = 1;
            foreach ($temas as $tema) :
                $class = ($cnt & 1) ? 'odd' : 'even';
                ?>
                <tr>
                    <td class="<?=$class?>"><?= $tema->nombre ?></td>
                    <td class="<?=$class?>"><a href="<?= site_url('backend/temas/editar/' . $tema->id) ?>"><img src="assets/images/backend/pencil.png" alt="Editar" title="Editar" /></a> <a href="<?= site_url('backend/temas/borrar/' . $tema->id) ?>" onclick="return confirm('¿Está seguro que desea eliminar este Tema?')"><img src="assets/images/backend/delete.png" alt="Eliminar" title="Eliminar" /></a></td>
                </tr>
                <?php
                $cnt++;
            endforeach;
        } else {
            ?>
            <tr>
                <td colspan="2" class="noregistros">No se encontraron registros</td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>
