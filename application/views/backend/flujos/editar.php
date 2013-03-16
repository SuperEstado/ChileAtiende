<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <a href="<?= site_url('backend/flujos') ?>">Flujos</a> »
    <span>Editar Flujo</span>
</div>

<div class="pane">
    <h2>Editar Flujo</h2>

    <fieldset>
        <legend>Datos flujo - <?= $flujo->titulo ?></legend>
        <form class="ajaxForm" method="post" action="<?= site_url('backend/flujos/editar_form/' . $flujo->id) ?>">
            <div class="validacion"></div>
            <table class="formTable">
                <tr>
                    <td>Título <span class="red">*</span></td>
                    <td><input type="text" name="titulo" size="90" value="<?= $flujo->titulo ?>" /></td>
                </tr>
                <tr>
                    <td>Descripción <span class="red">*</span></td>
                    <td><textarea id="editorA" name="descripcion" cols="85" rows="20"><?= $flujo->descripcion ?></textarea></td>
                </tr>
                <tr><td colspan="2"><p>* Campos Obligatorios</p></td></tr>
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
