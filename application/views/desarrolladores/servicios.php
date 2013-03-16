<h2>Servicios</h2>

<p>Servicios es un listado de las instituciones que publican en este portal. Los métodos de Servicios permiten obtener un servicio,
listar todos los servicios.</p>

<h3>Métodos</h3>
<dl>
    <dt><a href="<?=site_url('desarrolladores/servicios_obtener')?>">obtener</a></dt>
    <dd>Obtiene un servicio</dd>
    <dt><a href="<?=site_url('desarrolladores/servicios_listar')?>">listar</a></dt>
    <dd>Lista todas las servicios.</dd>
</dl>

<h3>Representación del recurso</h3>
<p>Un servicio es representado como una estructura json. Este es un ejemplo de como se vería un servicio.</p>
<pre>
{
    "servicio":{
        "id":"AD009",
        "nombre":"Carabineros de Chile",
        "url":"http:\/\/www.carabineros.cl",
        "mision":"Su misi\u00f3n es brindar seguridad a la comunidad en todo el territorio nacional mediante acciones prioritariamente preventivas, apoyadas por un permanente acercamiento a la comunidad. Privilegia la acci\u00f3n policial eficaz, eficiente, justa y transparente."
    }
}
</pre>