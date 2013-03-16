<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <a href="<?= site_url('backend/etapasvida') ?>">Etapas de Vida</a> »
    <span>Agregar Etapa de Vida</span>
</div>

<div class="pane">
    <h2>Agregar Etapa de Vida</h2>

    <fieldset>
        <legend>Datos etapa de vida</legend>
        <form class="ajaxForm" action="<?= site_url('backend/etapasvida/form_agregar') ?>" method="post" accept-charset="utf-8">
            <div class="validacion"></div>
            <table class="formTable">
                <tr>
                    <td class="titulo">Nombre <span class="red">*</span></td>
                    <td><input type="text" name="nombre" size="118" value="" /></td>
                </tr>
                <tr>
                    <td class="titulo">Descripción</td>
                    <td><textarea id="editorA" name="descripcion" cols="115" rows="15"></textarea></td>
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
