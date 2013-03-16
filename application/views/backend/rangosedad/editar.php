<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <a href="<?= site_url('backend/rangosedad') ?>">Rangos de Edad</a> »
    <span>Editar Rango de Edad #<?= $rango->id ?></span>
</div>

<div id="noticias">
    <p class="red">* Campos Obligatorios</p>

    <fieldset>
        <legend>Editar Rango de Edad<?= $rango ? ' - ' . $rango->edad_minima .'-'.$rango->edad_maxima : '' ?></legend>
        <form class="ajaxForm" action="<?= site_url('backend/rangosedad/form_guardar' . ( $rango ? '/' . $rango->id : '')) ?>" method="post" accept-charset="utf-8">
            <div class="validacion"></div>
            <table class="formTable">
                <tr>
                    <td class="titulo">Edad Mínima <span class="red">*</span></td>
                    <td><input type="text" name="edad_minima" size="3" value="<?= $rango ? $rango->edad_minima : '' ?>" /></td>
                </tr>
                <tr>
                    <td class="titulo">Edad Máxima <span class="red">*</span></td>
                    <td><input type="text" name="edad_maxima" size="3" value="<?= $rango ? $rango->edad_maxima : '' ?>" /></td>
                </tr>
                
                <tr><td colspan="2">&nbsp;</td></tr>
                <tr>
                    <td colspan="2" class="botones">
                        <button type="submit" class="guardar">Guardar<!-- <img src="assets/images/backend/bullet_disk.png" />--></button>
                        <button type="button" class="cancelar" onclick="javascript:history.back()">Cancelar</button>
                    </td>
                </tr>
            </table>
        </form>
    </fieldset>
</div>
