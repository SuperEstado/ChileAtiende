<h2>Enviar a un amigo</h2>
<p>Utilice este formulario para recomendar a un amigo este contenido.</p>
<form class="ajaxForm" method="post" action="<?= site_url('contacto/enviaemailamigo') ?>">
    <div class="validacion"></div>
    <fieldset>
        
        <legend>Información Personal</legend>
        <p>
            <label for="amigo_nombres">Nombre*</label><br />
            <input type="text" size="50" id="amigo_nombres" name="nombres" />
        </p>
        <p>
            <label for="amigo_email">Correo Electrónico*</label><br />
            <input type="text" size="50" id="amigo_email" name="email" />
        </p>
        
        <legend>Información Amigo</legend>
        <p>
            <label for="amigo_nombres_a">Nombre*</label><br />
            <input type="text" size="50" id="amigo_nombres_a" name="nombres_a" />
        </p>
        <p>
            <label for="amigo_email_a">Correo Electrónico*</label><br />
            <input type="text" size="50" id="amigo_email_a" name="email_a" />
        </p>

        <p class="long">
            <label for="amigo_comentarios">Ingrese sus mensaje</label><br />
            <textarea name="comentarios" id="amigo_comentarios" cols="55" rows="4"></textarea>
        </p>
        
    </fieldset>
    <br />
    <p><input type="submit" class="submit" value="Enviar" onclick="_gaq.push(['_trackEvent', 'Acciones', 'Enviar', 'Contacto']);" /></p>
</form>
