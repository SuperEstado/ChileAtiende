<h2>Fichas: listar</h2>

<p>Lista todas las fichas de este portal.</p>

<h3>Request HTTP</h3>
<pre>GET <?=site_url('api/fichas')?></pre>

<h3>Parámetros</h3>
<table class="tabla">
    <tr>
        <th>Nombre del parámetro</th>
        <th>Valor</th>
        <th>Descripción</th>
    </tr>
    <tr>
        <td colspan="3">Parámetros opcionales</td>
    </tr>
    <tr>
        <td>query</td>
        <td>string</td>
        <td>Realiza una búsqueda sobre las fichas del portal que contienen el string ingresado.</td>
    </tr>
    <tr>
        <td>maxResults</td>
        <td>unsigned integer</td>
        <td>El número máximo de resultados que debería contener la respuesta. Valores aceptables son del 1 al 20.
        Por defecto: 10.</td>
    </tr>
    <tr>
        <td>pageToken</td>
        <td>string</td>
        <td>El token de continuación. Usado para la paginación entre varios sets de resultados. Para obtener la
        próxima página de resultados se debe setear este parámetro con el valor de "nextPageToken" entregado
        en la respuesta previa.</td>
    </tr>
</table>

<h3>Response HTTP</h3>
<p>Si el request es correcto, se devuelve la siguiente estructura.</p>
<pre>
{
    "fichas":{
        "titulo":"Listado de Fichas",
        "tipo":"chileatiende#fichasFeed",
        "nextPageToken":{string},
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
        <td>nextPageToken</td>
        <td>string</td>
        <td>El token de continuación. Usado para paginar entre varios sets de resultados. Proveer este
        valor en requests subsiguientes para obtener la próxima página de resultados.</td>
    </tr>
    <tr>
        <td>items</td>
        <td>list</td>
        <td>El listado de fichas.</td>
    </tr>
</table>