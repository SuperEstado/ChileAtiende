<h2>Servicios: obtener</h2>

<p>Obtiene un servicio.</p>

<h3>Request HTTP</h3>
<pre>GET <?=site_url('api/servicios')?>/{servicioId}</pre>

<h3>Parámetros</h3>
<table class="tabla">
    <tr>
        <th>Nombre del parámetro</th>
        <th>Valor</th>
        <th>Descripción</th>
    </tr>
    <tr>
        <td colspan="3">Parámetros requeridos</td>
    </tr>
    <tr>
        <td>servicioId</td>
        <td>string</td>
        <td>Identificador único de un servicio del Estado.</td>
    </tr>
</table>

<h3>Response HTTP</h3>
<p>Si el request es correcto, se devuelve un <a href="<?=site_url('desarrolladores/servicios')?>">recurso servicio</a>.</p>