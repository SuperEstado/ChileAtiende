<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <span>Configuración</span>
</div>

<div class="pane">
    <?= $this->session->flashdata('message') ? '<div class="message">' . $this->session->flashdata('message') . '</div>' : '' ?>
    <fieldset>
        <legend>Configuración</legend>
        <form class="ajaxForm" action="<?= site_url('backend/configuraciones/form_guardar/') ?>" method="post" >
            <div class="validacion"><?= $msj ? $msj : ''; ?></div>
            <table class="formTable">
                <tr>
                    <td>Descripción</td>
                    <td><textarea name="descripcion" cols="83" rows="7"><?=$descripcion?></textarea></td>
                </tr>
                <tr>
                    <td>Palabras Claves</td>
                    <td><textarea name="keywords" cols="83" rows="7"><?=$keywords?></textarea></td>
                </tr>
                <tr>
                    <td>Autor</td>
                    <td><input type="text" name="autor" value="<?=$autor?>" size="83" /></td>
                </tr>
                <tr>
                    <td>Tiempo Caché</td>
                    <td><input type="text" name="cache" value="<?=$cache?>" size="3" maxlenght="3" /></td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                
            </table>
            <p class="botones">
                <button type="submit" class="guardar">Guardar</button>
                <button type="button" class="cancelar" onclick="javascript:history.back()">Cancelar</button>
            </p>
        </form>
    </fieldset>
</div>