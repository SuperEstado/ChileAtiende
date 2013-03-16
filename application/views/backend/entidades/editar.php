<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <a href="<?= site_url('backend/entidades') ?>">Entidades</a> »
    <span>Editar entidad #<?= $entidad->codigo ?></span>
</div>

<div class="pane">
    <h2>Editar Entidad</h2>

    <fieldset>
        <legend>Datos entidad <?= $entidad ? ' - ' . $entidad->nombre : '' ?></legend>
        <form class="ajaxForm" action="<?= site_url('backend/entidades/form_guardar' . ( $entidad ? '/' . $entidad->codigo : '')) ?>" method="post" accept-charset="utf-8">
            <div class="validacion"></div>
            <table class="formTable">
                <tr>
                    <td>Código</td>
                    <td><?= $entidad ? $entidad->codigo : '' ?></td>
                </tr>
                <tr>
                    <td>Nombre <span class="red">*</span></td>
                    <td><input type="text" name="nombre" size="90" value="<?= $entidad ? $entidad->nombre : '' ?>" /></td>
                </tr>
                <tr>
                    <td>Misión</td>
                    <td><textarea id="mision" name="mision"><?=$entidad->mision?></textarea></td>
                </tr>
                <tr>
                    <td>Sigla</td>
                    <td><input type="text" name="sigla" size="90" value="<?= $entidad ? $entidad->sigla : '' ?>" /></td>
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
