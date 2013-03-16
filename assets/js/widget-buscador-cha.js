/* 
 * Widget Buscador Portal Chile Atiende
 * Desarrollado por Unidad de Modernización y Gobierno Electrónico
 * 
 * uso: 
 *      incluir llamada al archivo js <script type="text/javascript" src="http://www.chileatiende.cl/assets/js/widget-buscador-cha.js"></script>
 *      crear un elemento (div, span, etc) con id buscadorChA
 * ejemplo: 
 *      <div id="buscadorChA"></div>
 */

function buscadorChileAtiende() {
    var str;
    var $ = document;
    var cssId = 'css-cha';
    var dominio = 'http://www.chileatiende.cl';
    
    if (!$.getElementById(cssId))
    {
        var head  = $.getElementsByTagName('head')[0];
        var link  = $.createElement('link');
        link.id   = cssId;
        link.rel  = 'stylesheet';
        link.type = 'text/css';
        link.href = dominio+'/assets/css/widget-css.css';
        link.media = 'all';
        head.appendChild(link);
    }
    
    str = '<div id="widget_chileatiende">';
    str += '<div class="detalle"></div>';
    str += '<h1>Buscador del Estado</h1>';
    str += '<form name="buscadorChA" method="post" action="http://buscador.chileatiende.cl/buscador/consulta?filtro=chileatiende" id="consulta-gcs">';
    str += '<label for="buscar"></label>';
    str += '<input type="text" name="q" id="query" placeholder="Búsqueda" />';
    str += '<input type="submit" name="buscar_btn" id="buscar_btn" value="Buscar" title="Buscar" />';
    str += '</form>';
    str += '<div class="txt">';
    str += '<a href="http://www.chileatiende.cl/" target="_blank"><img src="http://www.chileatiende.cl/assets/images/widgets/logo.png" alt="Logo ChileAtiende" width="42" height="53" /></a>Información sobre beneficios, trámites, programas y transparencia en los sitios web del Estado de Chile.';
    str += '<div class="clear"></div>';
    str += '</div>';
    str += '<div class="detalle2"></div>';
    str += '</div>';
    //marca analytics buscador
    str += '<script type="text/javascript">';
    str += 'var _gaq = _gaq || [];';
    str += '_gaq.push([\'_setAccount\', \'UA-28124406-8\']);';
    //str += '_gaq.push([\'_setDomainName\', \'.chileatiende.cl\']);';
    str += '_gaq.push([\'_trackPageview\']);';
    str += '_gaq.push([\'_setCustomVar\', 1, \'WidgetBuscador\', window.location.host, 1]);';
    str += '(function() {';
    str += 'var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;';
    str += 'ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';';
    str += 'var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);';
    str += '})();';
    str += '</script>';
    //fin marca analytics
	
    document.getElementById('buscadorChA').innerHTML = str;
}
window.onload = buscadorChileAtiende;
