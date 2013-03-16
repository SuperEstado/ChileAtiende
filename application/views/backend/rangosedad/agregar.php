<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <a href="<?= site_url('backend/rangosedad') ?>">Rangos de Edad</a> »
    <span>Agregar Rango de Edad</span>
</div>

<div id="noticias">
    <p class="red">* Campos Obligatorios</p>

    <fieldset>
        <legend>Agregar Rango de Edad</legend>
        <form class="ajaxForm" action="<?= site_url('backend/rangosedad/form_agregar') ?>" method="post" accept-charset="utf-8">
            <div class="validacion"></div>
            <table class="formTable">
                <tr>
                    <td class="titulo">Edad Mínima <span class="red">*</span></td>
                    <td><input type="text" name="edad_minima" size="3" value="" /></td>
                </tr>
                <tr>
                    <td class="titulo">Edad Máxima <span class="red">*</span></td>
                    <td><input type="text" name="edad_maxima" size="3" value="" /></td>
                </tr>

                <tr><td colspan="2">&nbsp;</td></tr>
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
