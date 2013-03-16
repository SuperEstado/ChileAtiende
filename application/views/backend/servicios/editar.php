<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <a href="<?= site_url('backend/servicios') ?>">Instituciones</a> »
    <span>Editar Institución #<?= $servicio->codigo ?></span>
</div>

<div class="pane">
    <h2>Editar institución</h2>
    
    <fieldset>
        <legend>Datos institución <?= $servicio ? ' - ' . $servicio->nombre : '' ?></legend>
        <form class="ajaxForm" action="<?= site_url('backend/servicios/form_guardar' . ( $servicio ? '/' . $servicio->codigo : '')) ?>" method="post" accept-charset="utf-8">
            <div class="validacion"></div>
            <table class="formTable">
                <tr>
                    <td>Código</td>
                    <td><?= $servicio ? $servicio->codigo : '' ?></td>
                </tr>
                <tr>
                    <td>Nombre <span class="red">*</span></td>
                    <td><input type="text" name="nombre" size="90" value="<?= $servicio ? $servicio->nombre : '' ?>" /></td>
                </tr>
                <tr>
                    <td>Sigla</td>
                    <td><input type="text" name="sigla" size="90" value="<?= $servicio ? $servicio->sigla : '' ?>" /></td>
                </tr>
                <tr>
                    <td>URL</td>
                    <td><input type="text" name="url" size="90" value="<?= $servicio ? $servicio->url : '' ?>" /></td>
                </tr>
                <tr>
                    <td>Responsable</td>
                    <td><input type="text" name="responsable" size="90" value="<?= $servicio ? $servicio->responsable : '' ?>" /></td>
                </tr>
                <tr>
                    <td>Entidad</td>
                    <td>
                        <select data-placeholder="Seleccione Entidad..." name="entidad_codigo" class="chzn-select" style="width: 485px">
                            <option value=""></option>
                            <?php
                            foreach ($entidades as $entidad) {
                                ?>
                                <option value="<?= $entidad->codigo ?>" <?php if ($entidad->codigo == $servicio->entidad_codigo)
                                echo 'selected="selected"'; ?>><?= $entidad->nombre ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Misión <span class="red">*</span></td>
                    <td><textarea id="editorA" name="mision" cols="88" rows="15"><?= $servicio ? $servicio->mision : '' ?></textarea></td>
                </tr>
                <tr>
                    <td colspan="2"><p class="red">* Campos Obligatorios</p></td>
                </tr>
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
