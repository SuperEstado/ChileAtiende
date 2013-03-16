<h2>Fichas: listarPorServicio</h2>

<p>Lista todas las fichas pertenecientes a un servicio.</p>

<h3>Request HTTP</h3>
<pre>GET <?=site_url('api/servicios/{servicioId}/fichas')?></pre>

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
<p>Si el request es correcto, se devuelve la siguiente estructura.</p>
<pre>
{
    "fichas":{
        "titulo":"Listado de Fichas",
        "tipo":"chileatiende#fichasFeed",
        "items": [
            <a href="<?=site_url('desarrolladores/fichas')?>">recurso ficha</a>
        ]
    }
}
</pre>

<p>Las propiedades que incorpora esta respuesta son:</p>

<table class="tabla">
    <tr>
        <th>Nombre del parámetro</th>
        <th>Valor</th>
        <th>Descripción</th>
    </tr>
    <tr>
        <td>titulo</td>
        <td>string</td>
        <td>El título de este listado de fichas.</td>
    </tr>
    <tr>
        <td>tipo</td>
        <td>string</td>
        <td>Identifica el nombre de este recurso.</td>
    </tr>
    <tr>
        <td>items</td>
        <td>list</td>
        <td>El listado de fichas.</td>
    </tr>
</table>