<h2>Solicitar Código de Acceso</h2>

<p>Complete el siguiente formulario para solicitar un código de acceso para la API de ChileAtiende</p>
<p>* Campos obligatorios</p>
<form method="post" action="<?=site_url('desarrolladores/access_token')?>">
    <?=  validation_errors('<p class="error">', '</p>')?>
    <table class="formTable">
        <tr>
            <td><label>E-Mail*:</label></td>
            <td><input type="text" name="email" value="<?=set_value('email')?>"/></td>
        </tr>
        <tr>
            <td><label>Nombre*:</label></td>
            <td><input type="text" name="nombre" value="<?=set_value('nombre')?>" /></td>
        </tr>
        <tr>
            <td><label>Apellidos*:</label></td>
            <td><input type="text" name="apellido" value="<?=set_value('apellido')?>" /></td>
        </tr>
        <tr>
            <td><label>Empresa:</label></td>
            <td><input type="text" name="empresa" value="<?=set_value('empresa')?>" /></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right;"><input type="submit" value="Enviar" /></td>
        </tr>
         
         
    </table>
</form>