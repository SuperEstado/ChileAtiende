<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <a href="<?= site_url('backend/etapasvida') ?>">Etapas de Vida</a> »
    <span>Editar Etapa de Vida #<?= $etapa->id ?></span>
</div>

<div class="pane">
    <h2>Editar Etapa de Vida</h2>
    

    <fieldset>
        <legend>Datos etapa de vida<?= $etapa ? ' - ' . $etapa->nombre : '' ?></legend>
        <form class="ajaxForm" action="<?= site_url('backend/etapasvida/form_guardar' . ( $etapa ? '/' . $etapa->id : '')) ?>" method="post" accept-charset="utf-8">
            <div class="validacion"></div>
            <table class="formTable">
                <tr>
                    <td class="titulo">Nombre <span class="red">*</span></td>
                    <td><input type="text" name="nombre" size="118" value="<?= $etapa ? $etapa->nombre : '' ?>" /></td>
                </tr>
                <tr>
                    <td class="titulo">Descripción</td>
                    <td><textarea id="editorA" name="descripcion" cols="115" rows="15"><?= $etapa ? $etapa->descripcion : '' ?></textarea></td>
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
