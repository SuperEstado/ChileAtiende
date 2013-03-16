<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <span>Cuenta</span>
</div>

<div class="pane">
    <h2>Mis Datos</h2>
    
    <?php echo validation_errors(); ?>
    <fieldset>
        <legend>Editar mi cuenta</legend>
        
        <form class="ajaxForm" action="<?= site_url('backend/cuenta/form_actualizar/' . $usuario->id) ?>" method="post" >
            <div class="validacion"></div>
            <?= $this->session->flashdata('message') ? '<div class="message">' . $this->session->flashdata('message') . '</div>' : '' ?>
            <table class="formTable">
                <tr>
                    <td>Nombres <span class="red">*</span></td>
                    <td><input type="text" name="nombres" size="50" value="<?= $usuario->nombres ?>" /></td>
                </tr>
                <tr>
                    <td>Apellidos <span class="red">*</span></td>
                    <td><input type="text" name="apellidos" size="50" value="<?= $usuario->apellidos ?>" /></td>
                </tr>
                <tr>
                    <td>E-mail</td>
                    <td><?= $usuario->email ?></td>
                </tr>
                <tr>
                    <td>Institución</td>
                    <td><?= $usuario->Servicio->nombre ?></td>
                </tr>
                <tr>
                    <td>Mis Roles</td>
                    <td><?php foreach($usuario->Roles as $rol){echo $rol->nombre."<br/>";} ?></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td>
                        <input type="password" id="password" name="password" value="" /><br />
                    </td>
                </tr>
                <tr>
                    <td>Confirmar</td>
                    <td>
                        <input type="password" id="confirm_password" name="confirm_password" value="" /><br />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                
            </table>
            <p class="red">* Campos Obligatorios</p>
            <p class="botones">
                <button type="submit" class="guardar">Guardar<!-- <img src="assets/images/backend/bullet_disk.png" />--></button>
                <button type="button" class="cancelar" onclick="javascript:history.back()">Cancelar</button>
            </p>
        </form>
    </fieldset>
</div>