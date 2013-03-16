<h2>Servicios: listar</h2>

<p>Lista todos los servicios (instituciones) que publican en este portal.</p>

<h3>Request HTTP</h3>
<pre>GET <?=site_url('api/servicios')?></pre>

<h3>Response HTTP</h3>
<p>Si el request es correcto, se devuelve la siguiente estructura.</p>
<pre>
{
    "fichas":{
        "titulo":"Listado de Servicios",
        "tipo":"chileatiende#serviciosFeed",
        "items": [
            <a href="<?=site_url('desarrolladores/servicios')?>">recurso servicio</a>
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
        <td>El listado de servicios.</td>
    </tr>
</table>