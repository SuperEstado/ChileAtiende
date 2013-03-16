<?php
$entidades = UsuarioBackendSesion::usuario()->getEntidadesAccesibles();
$servicios = UsuarioBackendSesion::usuario()->getServiciosAccesibles(UsuarioBackendSesion::getEntidad());

if( ($entidades->count() > 1) || ($servicios->count() > 1) ) {
?>
<form class="filtro" method="post" action="<?= site_url('backend/backend/change_institucion') ?>">
    <table class="formTable">

        <tr>
            <td><label>Entidad</label></td>
            <td><label>Institución</label></td>
            <td></td>
        </tr>
        <tr>
            <td>
                <select class="selectEntidades chzn-select" name="entidad_codigo" style="width: 95%">
                    <?php
                    if ($entidades->count() > 1)
                        echo'<option value="0">Todas</option>';
                    foreach ($entidades as $e) {
                        echo '<option value="' . $e->codigo . '" ' . set_select('entidad_codigo', $e->codigo, UsuarioBackendSesion::getEntidad() == $e->codigo) . '>' . $e->nombre . '</option>';
                    }
                    ?>
                </select>
            </td>
            <td>
                <select class="selectServicios chzn-select" name="servicio_codigo" style="width: 95%">
                    <?php
                    if ($servicios->count() > 1)
                        echo '<option value="0" ' . (UsuarioBackendSesion::getServicio() == '0' ? 'selected="selected"' : '') . '>Todos</option>';
                    foreach ($servicios as $s) {
                        echo '<option value="' . $s->codigo . '" ' . set_select('servicio_codigo', $s->codigo, UsuarioBackendSesion::getServicio() == $s->codigo) . '>' . $s->nombre . '</option>';
                    }
                    ?>
                </select>
            </td>
            <td>
                <input type="submit" class="boton_filtrar" value="Filtrar" />
            </td>
        </tr>
    </table>
</form>
<?php
}
?>