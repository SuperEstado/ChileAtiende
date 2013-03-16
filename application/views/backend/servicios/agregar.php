<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <a href="<?= site_url('backend/servicios') ?>">Instituciones</a> »
    <span>Agregar Institución</span>
</div>

<div class="pane">
    <h2>Agregar Institución</h2>

    <fieldset>
        <legend>Datos institución</legend>
        <form class="ajaxForm" action="<?= site_url('backend/servicios/form_agregar') ?>" method="post" accept-charset="utf-8">
            <div class="validacion"></div>
            <table class="formTable">
                <tr>
                    <td>Código <span class="red">*</span></td>
                    <td><input type="text" name="codigo" size="10" value="<?= set_value('codigo'); ?>" /></td>
                </tr>
                <tr>
                    <td>Nombre <span class="red">*</span></td>
                    <td><input type="text" name="nombre" size="90" value="<?= set_value('nombre'); ?>" /></td>
                </tr>
                <tr>
                    <td>Sigla</td>
                    <td><input type="text" name="sigla" size="90" value="<?= set_value('sigla'); ?>" /></td>
                </tr>
                <tr>
                    <td>URL</td>
                    <td><input type="text" name="url" size="90" value="<?= set_value('url'); ?>" /></td>
                </tr>
                <tr>
                    <td>Responsable</td>
                    <td><input type="text" name="responsable" size="90" value="<?= set_value('responsable'); ?>" /></td>
                </tr>
                <tr>
                    <td>Entidad</td>
                    <td>
                        <select data-placeholder="Seleccione Entidad..." name="entidad_codigo" class="chzn-select" style="width: 485px">
                            <?php
                            foreach ($entidades as $entidad) {
                                ?>
                                <option value="<?= $entidad->codigo ?>" <?php if ($entidad->codigo == set_value('entidad_codigo'))
                                echo 'selected="selected"'; ?>><?= $entidad->nombre ?></option>
                                        <?php
                                    }
                                    ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Misión <span class="red">*</span></td>
                    <td><textarea id="editorA" name="mision" cols="88" rows="15"><?= set_value('mision'); ?></textarea></td>
                </tr>
                <tr><td colspan="2"><p class="red">* Campos Obligatorios</p></td></tr>
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
