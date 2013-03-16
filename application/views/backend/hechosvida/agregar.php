<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <a href="<?= site_url('backend/hechosvida') ?>">Hechos de Vida</a> »
    <span>Agregar Hecho de Vida</span>
</div>

<div class="pane">
    <h2>Agregar Hecho de Vida</h2>

    <fieldset>
        <legend>Datos hecho de vida</legend>
        <form class="ajaxForm" action="<?= site_url('backend/hechosvida/form_agregar') ?>" method="post" accept-charset="utf-8">
            <div class="validacion"></div>
            <table class="formTable">
                <tr>
                    <td class="titulo">Nombre <span class="red">*</span></td>
                    <td><input type="text" name="nombre" size="80" value="" /></td>
                </tr>
                <tr>
                    <td class="titulo">Descripción</td>
                    <td><textarea id="editorA" name="descripcion" cols="80" rows="15"></textarea></td>
                </tr>
                <tr>
                    <td class="titulo">Etapas de Vida <span class="red">*</span></td>
                    <td>
                        <select data-placeholder="Seleccione una(s) Etapa(s) de Vida" name="etapas[]" class="chzn-select" style="width: 600px;" multiple>
                            <option value=""></option>
                            <?php foreach ($etapasvida as $etapa): ?>
                                <option value="<?= $etapa->id ?>"><?= $etapa->nombre ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
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
