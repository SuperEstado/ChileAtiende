<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <a href="<?= site_url('backend/usuariosbackend') ?>">Usuarios Backend</a> »
    <span>Agregar Usuario</span>
</div>

<div class="pane">
    <h2>Agregar Usuario</h2>
    
    

    <fieldset>
        <legend>Datos del usuario</legend>
        <form class="ajaxForm" action="<?= site_url('backend/usuariosbackend/form_agregar/') ?>" method="post" >
            <div class="validacion"></div>
            <table class="formTable">
                <tr>
                    <td>Nombres <span class="red">*</span></td>
                    <td><input type="text" name="nombres" size="50" value="" /></td>
                </tr>
                <tr>
                    <td>Apellidos <span class="red">*</span></td>
                    <td><input type="text" name="apellidos" size="50" value="" /></td>
                </tr>
                <tr>
                    <td>E-mail <span class="red">*</span></td>
                    <td><input type="text" name="email" size="50" value="" /></td>
                </tr>
                <tr>
                    <td>Activo</td>
                    <td><input type="checkbox" name="activo" /></td>
                </tr>
                <tr>
                    <td>Ministerial</td>
                    <td><input type="checkbox" name="ministerial" /></td>
                </tr>
                <tr>
                    <td>Interministerial</td>
                    <td><input type="checkbox" name="interministerial" /></td>
                </tr>
                <tr>
                    <td>Servicio <span class="red">*</span></td>
                    <td>
                        <select multiple data-placeholder="Seleccione un Servicio"  name="servicio_codigo[]" class="chzn-select">
                            <option value=""></option>
                            <?php
                            foreach ($servicios as $servicio) :
                                ?>
                                <option value="<?= $servicio->codigo ?>"><?= $servicio->nombre ?></option>
                                <?php
                            endforeach;
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Rol <span class="red">*</span></td>
                    <td>
                        <select data-placeholder="Seleccione su Rol"  name="rol[]" class="chzn-select" style="width: 470px" multiple>
                            <option value=""></option>
                            <?php
                            foreach ($roles as $rol) :
                                ?>
                                <option value="<?= $rol->id ?>"><?= $rol->nombre ?></option>
                                <?php
                            endforeach;
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table>
                            <tr>
                                <td><input type="radio" name="radio" id="crear" checked="checked" /> Crear Password</td>
                                <td><input type="radio" name="radio" id="generar" /> Generar Password</td>
                            </tr>
                            <tr>
                                <td class="crear">
                                    <table>
                                        <tr>
                                            <td>Password <span class="red">*</span></td>
                                            <td>
                                                <input type="password" id="password" name="password" value="" /><br />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Confirmar <span class="red">*</span></td>
                                            <td>
                                                <input type="password" id="confirm_password" name="confirm_password" value="" /><br />
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td class="generar" style="display:none;">
                                    <table>
                                        <tr>
                                            <td>
                                                <input type="text" id="generated_pw" name="generated_pw" value="" /> <input type="button" onclick="suggestPassword(this.form)" value="Generar Password" />
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                
                
                
                
                <tr><td><p class="red">* Campos Obligatorios</p></td></tr>
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
