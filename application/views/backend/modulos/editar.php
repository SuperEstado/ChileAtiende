<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <a href="<?= site_url('backend/modulosatencion') ?>">Modulos de atención</a> »
    <span>Editar Módulo de atención #<?= $modulo->id ?></span>
</div>

<div class="pane">
    <h2>Editar Módulo de atención</h2>

    <fieldset>
        <legend>Datos módulo <?= $modulo ? ' - ' . $modulo->descripcion : '' ?></legend>
        <form class="ajaxForm" action="<?= site_url('backend/modulosatencion/form_guardar' . ( $modulo ? '/' . $modulo->id : '')) ?>" method="post" accept-charset="utf-8">
            <div class="validacion"></div>
            <table class="formTable">
                <tr>
                    <td>ID</td>
                    <td><?= $modulo ? $modulo->id : '' ?></td>
                </tr>
                <tr>
                    <td>Nro máquina <span class="red">*</span></td>
                    <td><input type="text" name="nro_maquina" size="4" maxlength="4" value="<?= $modulo ? $modulo->nro_maquina : '' ?>" /></td>
                </tr>
                <tr>
                    <td>Descripción <span class="red">*</span></td>
                    <td><input type="text" name="descripcion" size="60" value="<?= $modulo ? $modulo->descripcion : '' ?>" /></td>
                </tr>
                <tr>
                    <td>Sector</td>
                    <td>

                        <select data-placeholder="Seleccione Sector..." name="sector_codigo" class="chzn-select" style="width: 485px">
                            <option value=""></option>
                            <?php
                            foreach ($sectores as $sector) {
                                ?>
                                <option value="<?= $sector->codigo ?>" <?php if ($sector->codigo == $modulo->sector_codigo)
                                echo 'selected="selected"'; ?>><?= $sector->nombre ?></option>
                                        <?php
                                    }
                                    ?>
                        </select>

                    </td>

                </tr>
                <tr>
                    <td>Servicio</td>
                    <td>

                        <select data-placeholder="Seleccione un Servicio" name="servicio_codigo" class="chzn-select">
                            <option value=""></option>
                            <?php
                            foreach ($servicios as $servicio) {
                                echo '<option value="' . $servicio->codigo . '" ' . ( ($modulo->servicio_codigo == $servicio->codigo) ? 'selected="selected"' : '' ) . '>' . $servicio->nombre . '</option>';
                            }
                            ?>
                        </select>

                    </td>
                </tr>
                <tr>
                    <td>Oficina</td>
                    <td>

                        <select data-placeholder="Seleccione una Oficina" name="oficina_id" class="chzn-select">
                            <option value=""></option>
                            <?php
                            foreach ($oficinas as $oficina) {
                                echo '<option value="' . $oficina->id . '" ' . ( ($modulo->oficina_id == $oficina->id) ? 'selected="selected"' : '' ) . '>' . $oficina->nombre . '</option>';
                            }
                            ?>
                        </select>

                    </td>
                </tr>
                

                <tr>
                    <td colspan="2"><p class="red">* Campos Obligatorios</p></td>
                </tr>
                <tr>
                    <td colspan="2" class="botones">
                        <button type="submit" class="guardar">Guardar</button>
                        <button type="button" class="cancelar" onclick="javascript:history.back()">Cancelar</button>
                    </td>
                </tr>
            </table>
        </form>

    </fieldset>

</div>
