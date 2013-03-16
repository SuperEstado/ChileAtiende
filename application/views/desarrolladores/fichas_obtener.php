<h2>Fichas: obtener</h2>

<p>Obtiene una ficha.</p>

<h3>Request HTTP</h3>
<pre>GET <?=site_url('api/fichas')?>/{fichaId}</pre>

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
        <td>fichaId</td>
        <td>int</td>
        <td>Identificador único de una ficha de este portal.</td>
    </tr>
</table>

<h3>Response HTTP</h3>
<p>Si el request es correcto, se devuelve un <a href="<?=site_url('desarrolladores/fichas')?>">recurso ficha</a>.</p>