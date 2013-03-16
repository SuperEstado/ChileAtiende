<h2>Fichas</h2>

<p>Fichas es un listado de fichas de este portal. Los métodos permiten obtener una ficha,
listar una serie de fichas o listar fichas pertenecientes a un servicio en particular.</p>

<h3>Métodos</h3>
<dl>
    <dt><a href="<?=site_url('desarrolladores/fichas_obtener')?>">obtener</a></dt>
    <dd>Obtiene una ficha</dd>
    <dt><a href="<?=site_url('desarrolladores/fichas_listar')?>">listar</a></dt>
    <dd>Lista todas las fichas</dd>
    <dt><a href="<?=site_url('desarrolladores/fichas_listarporservicio')?>">listarPorServicio</a></dt>
    <dd>Lista todas las fichas de un servicio/institución en particular.</dd>
</dl>

<h3>Representación del recurso</h3>
<p>Una ficha es representada como una estructura json. Este es un ejemplo de cómo se vería una ficha.</p>
<pre>
{
   "ficha":{
      "id":"1",
      "fecha":"2011-08-18 11:57:16",
      "servicio":"Direcci\u00f3n de Previsi\u00f3n de Carabineros de Chile",
      "titulo":"\u00bfC\u00f3mo solicito a la Direcci\u00f3n de Previsi\u00f3n de Carabineros de Chile (DIPRECA) el Pago Complementario del Reintegro M\u00e9dico?",
      "objetivo":"<p>Solicitar a la Direcci&oacute;n de Previsi&oacute;n de Carabineros de Chile (DIPRECA) el Pago Complementario del Reintegro M&eacute;dico o gastos asociados a la atenci&oacute;n de salud. El tr&aacute;mite puede realizarse durante todo el a&ntilde;o en los horarios definidos por la instituci&oacute;n.<\/p>",
      "beneficiarios":"<p>El personal activo de Carabineros de Chile, DIPRECA, Investigaciones de Chile y Gendarmer&iacute;a de Chile, adem&aacute;s, de los pensionados de retiro y los montepiados.<\/p>",
      "costo":"<p>Ninguno.<\/p>",
      "vigencia":"<p>Anual.<\/p>",
      "plazo":"<p>27 d&iacute;as h&aacute;biles, aproximadamente.<\/p>",
      "marco_legal":"",
      "temas":{
         "tema":[
            "Salud"
         ]
      },
      "tags":{
         "tag":[
            "DIPRECA",
            "Carabineros"
         ]
      }
   }
}
</pre>