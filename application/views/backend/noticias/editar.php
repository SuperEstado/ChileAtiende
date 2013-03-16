<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <a href="<?= site_url('backend/noticias') ?>">Noticias</a> »
    <span>Editar Noticia #<?= $noticia->id ?></span>
</div>

<div class="pane">
    <h2>Editar Noticias</h2>

    <fieldset>
        <legend>Datos noticia<?= $noticia ? ' - ' . $noticia->titulo : '' ?></legend>
        <form action="<?= site_url('backend/noticias/form_guardar' . ( $noticia ? '/' . $noticia->id : '')) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
            <table class="formTable">
                <tr>
                    <td>Título <span class="red">*</span></td>
                    <td><input type="text" name="titulo" size="85" value="<?= $noticia ? $noticia->titulo : '' ?>" /></td>
                </tr>
                <!--
                <tr>
                    <td>Resumen <span class="red">*</span></td>
                    <td><textarea id="editorA" name="resumen" cols="115" rows="15"><?= $noticia ? $noticia->resumen : '' ?></textarea></td>
                </tr>
                -->
                <tr>
                    <td>Contenido <span class="red">*</span></td>
                    <td><textarea id="editorB" name="contenido" cols="85" rows="15"><?= $noticia ? $noticia->contenido : '' ?></textarea></td>
                </tr>
                <tr>
                    <td>Fecha publicación <span class="red">*</span></td>
                    <td><input type="text" name="created_at" id="created_at" value="<?php echo $noticia->created_at ?>" /> </td>
                </tr>
                <tr>
                    <td>Imagen</td>
                    <td><input type="file" name="imagen" size="50" /> <span style="font-size: 11px">Tamaño max: 1024x768</span></td>
                </tr>
                <tr>
                    <td>Descripción de la Imagen</td>
                    <td><input type="text" value="<?= $noticia ? $noticia->foto_descripcion : ''; ?>" size="85" id="foto_descripcion" name="foto_descripcion" maxlength="120">Largo max: 120 caracteres</td>
                </tr>
                <?php
                if($noticia->foto) {
                ?>
                <tr>
                    <td>Previsualización</td>
                    <td>
                        <?= $noticia->foto ? '<img src="'.site_url("assets/timthumb/timthumb.php").'?zc=1&amp;w=120&amp;h=120&amp;src=/uploads/noticias/' . $noticia->foto . '" alt="' . $noticia->titulo . '" />' : '' ?>
                    </td>
                </tr>
                <?php
                }
                ?>
                <tr>
                    <td>Publicado</td>
                    <td><input type="checkbox" name="publicado" <?= $noticia ? (($noticia->publicado) ? 'checked="checked"' : '') : '' ?> /></td>
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
