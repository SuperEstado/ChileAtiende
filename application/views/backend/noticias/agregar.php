<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <a href="<?= site_url('backend/noticias') ?>">Noticias</a> »
    <span>Agregar Noticia</span>
</div>

<div class="pane">
    <h2>Agregar Noticia</h2>
    <?php 
    echo validation_errors('<p class="error">','</p>'); 
    echo $this->session->flashdata('message');
    ?>
    <fieldset>
        <legend>Datos noticia</legend>
        <form action="<?= site_url('backend/noticias/form_agregar') ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
            <table class="formTable">
                <tr>
                    <td>Título <span class="red">*</span></td>
                    <td><input type="text" name="titulo" size="85" value="<?= set_value('titulo'); ?>" /></td>
                </tr>
                <!--
                <tr>
                    <td>Resumen <span class="red">*</span></td>
                    <td><textarea id="editorA" name="resumen" cols="115" rows="15"><?= set_value('resumen'); ?></textarea></td>
                </tr>
                -->
                <tr>
                    <td>Contenido <span class="red">*</span></td>
                    <td><textarea id="editorB" name="contenido" cols="85" rows="15"><?= set_value('contenido'); ?></textarea></td>
                </tr>
                <tr>
                    <td>Imagen</td>
                    <td><input type="file" name="imagen" /> <span style="font-size: 11px">Tamaño max: 1024x768</span></td>
                </tr>
                <tr>
                    <td>Descripción de la Imagen</td>
                    <td><input type="text" value="" size="85" id="foto_descripcion" name="foto_descripcion" maxlength="120">Largo max: 120 caracteres</td>
                </tr>
                <tr>
                    <td>Publicado</td>
                    <td><input type="checkbox" name="publicado"  /></td>
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
