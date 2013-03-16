<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <a href="<?= site_url('backend/flujos') ?>">Flujos</a> »
    <span>Agregar Flujo</span>
</div>

<div class="pane">
    <h2>Agregar Flujo</h2>

    <fieldset>
        <legend>Datos flujo</legend>
        <form class="ajaxForm" method="post" accept-charset="utf-8" action="<?= site_url('backend/flujos/agregar_form') ?>">
            <div class="validacion"></div>
            <table class="formTable">
                <tr>
                    <td>Título <span class="red">*</span></td>
                    <td><input type="text" name="titulo" size="90" value="<?= set_value('titulo'); ?>" /></td>
                </tr>
                <tr>
                    <td>Descripción <span class="red">*</span></td>
                    <td><textarea id="editorA" name="descripcion" cols="85" rows="20"><?= set_value('descripcion'); ?></textarea></td>
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
