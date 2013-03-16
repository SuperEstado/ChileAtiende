<!-- Registro -->
	<div id="registro" class="formulario simpleOverlay">
		<h2>Regístrese como Usuario</h2>
		<p>Inscríbase y disfrute de una mejor experiencia en su navegación.</p>
		<p class="alert">Introduzca TODOS los datos en el formulario. Una vez realizado el proceso le enviaremos un email de verificación.</p>
		<form action="#">
			<fieldset>
			<legend>Información Personal</legend>
			<p>
			<label for="rut">RUT</label><br />
				<input type="text" id="rut" name="rut" />-<label for="verificador"><input type="text" id="verificador" name="verificador" /></label>
			</p>
			<p class="long">
			<label for="nombres">Nombres</label><br />
				<input type="text" id="nombres" name="nombres" />
			</p>
			<p class="left">
			<label for="apellido_paterno">Apellido Paterno</label><br />
				<input type="text" id="apellido_paterno" name="apellido_paterno" />
			</p>
			<p class="right">
			<label for="apellido_materno">Apellido Materno</label><br />
				<input type="text" id="apellido_materno" name="apellido_materno" />
			</p>
			<p class="left">
			<label for="email">Correo Electrónico</label><br />
				<input type="text" id="email" name="email" />
			</p>
			<p class="right">
			<label for="email_check">Repita su Correo</label><br />
				<input type="text" id="email_check" name="email_check" />
			</p>
			</fieldset>
			<fieldset>
			<legend>Los siguientes datos son necesarios para optimizar su atención</legend>
			<p class="left">
				<label for="region">Región</label><br />
				<input type="text" id="region" name="region" />
			</p>
			<p class="right">
			<label for="reg_comuna">Comuna</label><br />
				<input type="text" id="reg_comuna" name="comuna" />
			</p>
			<p class="left">
			<label for="prevision">Sistema de Previsión</label><br />
				<select name="prevision" id="prevision">
					<option value="ips">IPS</option>
					<option value="caja">Caja de Compensación</option>
					<option value="afp">AFP</option>
				</select>
			</p>
			<p class="right">
			<label for="salud">Sistema de Salud</label><br />
				<select name="salud" id="salud">
					<option value="fonasa">Fonasa</option>
					<option value="afp">AFP</option>
				</select>
			</p>
			<p class="left">
			<label for="estado">Estado Civil</label><br />
				<select name="estado" id="estado">
					<option value="soltero/a">Soltera / Soltero</option>
					<option value="casado/a">Casada / Casado</option>
					<option value="divorciado/a">Divorciada / Divorciado</option>
					<option value="viudo/a">Viuda / Viudo</option>
				</select>
			</p>
			<p class="right">
			<label for="edad">Edad</label><br />
				<input type="text" id="edad" name="edad" />
			</p>
			<p class="left">
			<label for="sexo">Sexo</label><br />
				<select name="sexo" id="sexo">
					<option value="femenino">Femenino</option>
					<option value="masculino">Masculino</option>
				</select>
			</p>
			<p class="right">
			<label for="hijos">¿Hijos?</label><br />
				<select name="hijos" id="hijos">
					<option value="no">No</option>
					<option value="si">Sí</option>
				</select>
			</p>
			</fieldset>
			<fieldset>
			<legend>Defina su contraseña</legend>
			<p class="left">
				<label for="password">Contraseña</label><br />
				<input type="text" id="password" name="password" />
			</p>
			<p class="right">
			<label for="password_check">Repita su Contraseña</label><br />
				<input type="text" id="password_check" name="password_check" />
			</p>
			</fieldset>
			<p><input type="checkbox" name="condiciones_de_uso" id="condiciones_de_uso" value="Acepta las Condiciones" /><label for="condiciones_de_uso">Acepto <strong>haber leído y entendido</strong> las <a href="<?php echo site_url('contenido/politicadeprivacidad') ?>">políticas de uso y privacidad</a>.</label></p>
			<p class="right"><input type="reset" value="Cancelar" />&nbsp;<input type="submit" class="submit" value="Registrar" /></p>
		</form>
	</div>
<!-- Fin Registro -->