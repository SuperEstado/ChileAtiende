<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> » Módulos de atención
</div>

<div class="pane">
    <h2>Listado Módulos de atención</h2>
    
    <?= $this->session->flashdata('message') ? '<div class="message">' . $this->session->flashdata('message') . '</div>' : '' ?>
    
    <p><a class="boton" href="<?= site_url('backend/modulosatencion/agregar') ?>"><img src="assets/images/backend/add.png" /> Agregar Módulo de atención</a></p>
    <table class="tabla">
        <tr>
            <th>ID</th>
            <th>Nro máquina</th>
            <th>Descripción</th>
            <th>Oficina</th>
            <th>Dirección</th>
            <th>Código</th>
            <th>Acción</th>
        </tr>
        <?php
        if (count($modulos)) {
            $cnt = 1;
            foreach ($modulos as $modulo) :
                $class = ($cnt & 1) ? 'odd' : 'even';
                ?>
                <tr>
                    <td class="<?=$class?>"># <?= $modulo->id ?></td>
                    <td class="<?=$class?>"><?= $modulo->nro_maquina ?></td>
                    <td class="<?=$class?>"><?= $modulo->descripcion ?></td>
                    <td class="<?=$class?>"><?= $modulo->Oficina->nombre ?></td>
                    <td class="<?=$class?>"><?= $modulo->Oficina->direccion ?></td>
                    <td class="<?=$class?>"><?= $modulo->sector_codigo.'-'.$modulo->oficina_id.'-'.$modulo->nro_maquina ?></td>
                    <td class="<?=$class?>"><a href="<?= site_url('backend/modulosatencion/editar/' . $modulo->id) ?>"><img src="assets/images/backend/pencil.png" alt="Editar" title="Editar" /></a> <a href="<?= site_url('backend/modulosatencion/borrar/' . $modulo->id) ?>" onclick="return confirm('¿Está seguro que desea eliminar este Tema?')"><img src="assets/images/backend/delete.png" alt="Eliminar" title="Eliminar" /></a></td>
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
