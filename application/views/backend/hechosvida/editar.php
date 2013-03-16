<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <a href="<?= site_url('backend/hechosvida') ?>">Hechos de Vida</a> »
    <span>Editar Hecho de Vida #<?= $hecho->id ?></span>
</div>

<div class="pane">
    <h2>Ediatr Hecho de Vida</h2>

    <fieldset>
        <legend>Datos hecho de vida<?= $hecho ? ' - ' . $hecho->nombre : '' ?></legend>
        <form class="ajaxForm" action="<?= site_url('backend/hechosvida/form_guardar' . ( $hecho ? '/' . $hecho->id : '')) ?>" method="post" accept-charset="utf-8">
            <table class="formTable">
                <tr>
                    <td class="titulo">Nombre <span class="red">*</span></td>
                    <td><input type="text" name="nombre" size="80" value="<?= $hecho ? $hecho->nombre : '' ?>" /></td>
                </tr>
                <tr>
                    <td class="titulo">Descripción</td>
                    <td><textarea id="editorA" name="descripcion" cols="80" rows="15"><?= $hecho ? $hecho->descripcion : '' ?></textarea></td>
                </tr>
                <tr>
                    <td class="titulo">Etapas de Vida <span class="red">*</span></td>
                    <td>
                        <select data-placeholder="Seleccione una(s) Etapa(s) de Vida" name="etapas[]" class="chzn-select" style="width: 600px;" multiple>
                            <?php foreach ($etapasvida as $etapa): ?>
                                <option value="<?= $etapa->id ?>" 
                                <?php
                                if ($hecho->hasEtapa($etapa->id))
                                    echo 'selected="selected"'
                                    ?>>
                                <?= $etapa->nombre ?>
                                </option>
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
