<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contenido extends CI_Controller {

    function index() {

        $data['title'] = 'Ayuda y Preguntas Frecuentes';
        $data['texto'] = "Versión Beta - Contenido en Revisión";

        $data['content'] = 'contenido/base';
        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('template', $data);
    }

    function acerca() {

        $data['title'] = 'Red de Servicios del Estado: Un solo lugar, múltiples servicios';
        $data['texto'] = "<p>Actualmente,&nbsp;  los ciudadanos deben peregrinar entre múltiples servicios públicos para  realizar trámites y solicitar beneficios y servicios. Esta realidad dificulta  la relación de los personas con el Estado, ya que los obliga a desplazarse a  oficinas que se encuentran centrales para poder satisfacer sus  requerimientos.&nbsp;</p>
<p>Al respecto  consideramos que el Estado debiera ser un facilitador para los ciudadanos. En  este sentido, hemos concebido la implementación de una Red Multiservicios del  Estado, &nbsp;coordinada por el Ministerio Secretaría General de la  Presidencia, distribuida a lo largo del país, que integrará el canal de atención  presencial con aquellos virtuales para proveer servicios relacionados con  diferentes instituciones del Estado.&nbsp;</p>
<p>La actual red de  sucursales del Instituto de Previsión Social (IPS, ex INP) proveerá, en un solo  lugar, de atención presencial y entregará&nbsp; información, de los servicios  y&nbsp; beneficios&nbsp; que&nbsp; las instituciones incorporen paulatinamente  a esta iniciativa, que además contará con un canal telefónico para información,  orientación y derivación de los mismos productos en convenio con la red  presencial.</p>
<p>En Internet,&nbsp;  la iniciativa dispondrá de un portal centralizado,&nbsp; que reunirá información  y permitirá el acceso a los servicios del Estado. El proyecto &nbsp;está  orientado a satisfacer las necesidades de los usuarios (personas naturales y  jurídicas), a través de la incorporación de herramientas tecnológicas que  faciliten la comprensión y el acceso a los beneficios, documentos e información  pública.</p>
<p>Este portal  reemplaza al actual Chileclic y es el lugar oficial de reporte de las  obligaciones de Transparencia Activa en relación a trámites para acceder a  servicios y beneficios dirigidos a la ciudadanía (personas, empresas y  organizaciones).</p>";
        $data['content'] = 'contenido/base';
        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('template', $data);
    }

    function preguntasyayuda() {

        $data['title'] = 'Ayuda y Preguntas Frecuentes';
        $data['texto'] = "
<h3>¿Qué tipo de información puedo encontrar en el Portal de Servicios del Estado?</h3>
<p>  En este portal podrá encontrar información sobre  más de 1.700 servicios y beneficios que entregan las instituciones del Estado tanto a ciudadanos como a empresas y organizaciones, entre los que se encuentran solicitudes, becas, subsidios, autorizaciones y certificados, entre otros.</p>
<h3>¿Cómo se relaciona este portal con la Red Multiservicios del Estado?</h3>
<p>  Este portal es parte integral de la Red Multiservicios y sigue la misma lógica del canal presencial, al acercar el Estado a los ciudadanos para facilitarles la vida a través de la entrega inmediata de información que les permita ahorrar costos de tiempo y transporte  e interactuar más fácilmente con las instituciones públicas.</p>
<h3>¿Puedo realizar trámites en línea?</h3>
<p>  En el Portal de la Red Multiservicios del Estado existe una variada oferta de beneficios y servicios, algunos de los cuales se encuentran disponibles para realizar en línea.<br />
  Actualmente, estamos trabajando para aumentar la cantidad de trámites que pueden realizarse por esta vía, con el fin de mejorar la calidad de vida de los ciudadanos,  evitando las largas filas, los gastos innecesarios de transporte y mejorando en general la relación de las personas con el Estado.</p>
";
        $data['content'] = 'contenido/base';
        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('template', $data);
    }

    function politicadeprivacidad() {

        $data['title'] = 'Políticas de Privacidad';
        $data['texto'] = '
<p>De conformidad a lo dispuesto en el artículo 19 Nº 4 de la Constitución Política de la República y la Ley Nº 19.628 sobre Protección de la Vida Privada se señala lo siguiente: </p>
<p>El Ministerio Secretaría General de la Presidencia de la República de Chile (MINSEGPRES), pone en conocimiento de todos quienes acceden al PORTAL CHILEATIENDE, a fin de resguardar la seguridad, confidencialidad y privacidad del usuario y/o visitante de este sitio. </p>
<p>Estas políticas tienen por finalidad asegurar la correcta utilización de la información recopilada a través de las visitas de este sitio y de sus contenidos.</p>
<h3>I. SOBRE LOS DATOS RECOPILADOS.</h3>
<p>MINSEGPRES recopila datos de los suscriptores, usuarios y/o visitantes que hagan uso de este portal, a través de dos mecanismos: </p>
<p>a)Mecanismos Automáticos: Son aquellos procesos informáticos realizados para generar registros de las actividades de los visitantes de sitios Web y cuyo objeto es establecer patrones de actividad, navegación y audiencia, que no implican la identificación personal de aquellos suscriptores, usuarios y/o visitantes que accedan a los servicios del Sistema de Atención Ciudadana. </p>
<p>MINSEGPRES se reserva el derecho de usar dicha información general, a fin de establecer criterios que mejoren los contenidos de este sistema, en todo caso siempre disociados de la persona que dejó los datos en su navegación.</p>
<p>b) Mecanismos Manuales: Son requerimientos formales y expresos de información a los suscriptores, usuarios y/o visitantes del portal que implican la recolección de datos personales tales como nombre, apellidos, domicilio, correo electrónico, ocupación, etc.</p>
<p>MINSEGPRES recopila estos datos con el objeto de mejorar la calidad de información del Portal y dar una mejor atención ante consultas de la ciudadanía</p>
<h3>II. SOBRE EL TRATAMIENTO DE LOS DATOS.</h3>
<p>Respecto de la entrega de información recopilada por medio de los mecanismos automáticos antes señalados, y que no contengan identificación personal de los suscriptores, usuarios y/o visitantes de la página, esta podrá ser utilizada para informar a entidades públicas, gubernamentales o a terceros sobre patrones de actividad, navegación, audiencia y caracterización general de este sistema. </p>
<p>Respecto de los datos personales de los usuarios recolectados a través de mecanismos manuales u otros medios, éstos serán objeto de los siguientes tratamientos: mejorar la calidad de información del Portal y dar una mejor atención ante consultas de la ciudadanía, conforme a lo declarado ante el Registro de Bases de Datos que mantiene el Servicio de Registro Civil e Identificación, el cual puede ser consultado aquí. </p>
<p>Al aceptar las presentes Políticas de Privacidad, usted autoriza MINSEGPRES para:</p>
<ol>
<li>Comunicar a otros organismos del Estado u otros terceros sus datos personales con el único objeto de mejorar la calidad de información del Portal y dar una mejor atención ante consultas de la ciudadanía.</li>
<li>Comunicar a terceros información estadística elaborada a partir de los datos personales de sus usuarios, cuando de dichos datos no sea posible identificar individualmente a los titulares, de conformidad a la Ley.</li>
</ol>
<p>Aparte de las autorizaciones establecidas anteriormente, MINSEGPRES mantendrá la debida confidencialidad de los datos personales y no los trasmitirá a terceros, salvo cuando se deban entregar en razón de un mandato legal o una orden emanada de los Tribunales de Justicia que así lo requiera.</p>
<h3>III. DERECHOS DEL TITULAR DE LOS DATOS.</h3>
<p>El usuario podrá en todo momento ejercer los derechos otorgados por la Ley Nº 19.628 y sus modificaciones posteriores. En específico, podrá:</p>
<ol>
<li>Solicitar información respecto de los bancos de datos de que sea responsable el organismos, el fundamento jurídico de su existencia, su finalidad, tipos de datos almacenados y descripción del universo de personas que comprende;</li>
<li>Solicitar información sobre los datos relativos a su persona, su procedencia y destinatario, el propósito del almacenamiento y la individualización de las personas u organismos a los cuales sus datos son transmitidos regularmente;</li>
<li>Solicitar se modifiquen sus datos personales cuando ellos no sean correctos o no estén actualizados, si fuere procedente, y;</li>
<li>Solicitar la eliminación o cancelación de los datos entregados cuando así lo desee, en tanto fuere procedente.</li>
</ol>
<p>Para ejercer sus derechos el usuario podrá dirigirse a LA UNIDAD DE MODERNIZACION Y GOBIERNO ELECTRÓNICO, ubicado en calle Teatinos Nº333 piso 4, Santiago, Teléfono: +562 688 77 01, o a la dirección electrónica: contactochileatiende@minsegpres.gob.cl, indicando claramente su solicitud.</p>
';

        $data['content'] = 'contenido/base';
        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('template', $data);
    }

    function terminosycondiciones() {
        $data['title'] = 'Términos y Condiciones de uso';
        $data['texto'] = '<p>Bienvenidos al portal ChileAtiende operado por el Ministerio Secretaría General de la Presidencia de la República de Chile (MINSEGPRES) (en adelante, el "Portal"). El objeto del presente Portal es entregar información a la ciudadanía acerca de servicios y beneficios del Estado.</p>
                            <p>El uso del Portal sujeto a las siguientes condiciones, las que deberán ser cumplidas por los usuarios de éste (en adelante e indistintamente "Usted" o el "Usuario"). </p>
                            <p>Al acceder al Portal, Usted tendrá derecho a revisar toda la información que esté disponible en él. Sin perjuicio de lo anterior, MINSEGPRES, no se hace responsable por la veracidad o exactitud de la información contenida en los enlaces a otros sitios Web o que haya sido entregada por terceros.</p>
                            <p>El Portal es un medio que facilita la entrega de información a la ciudadanía, sin intervenir en la ejecución de dichos actos ni intervenir ni formal ni sustantivamente en ninguna de sus fases. </p>
                            <p>Los usuarios del Portal declaran conocer y aceptar la circunstancia relativa a que este servicio público podrá en cualquier momento modificar el todo o parte de las presentes condiciones de uso, conforme a la legislación vigente o políticas del organismo.</p>';
        $data['content'] = 'contenido/base';
        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('template', $data);
    }

    function visualizadores() {
        $data['title'] = 'Visualizadores y Navegadores';
        $data['texto'] = '
            <h3>Visualizadores</h3>
            <ul class="visualizadores">
            <li>
                <h4>Visualizador documentos PDF (.pdf)</h4>
                <a href="http://get.adobe.com/es/reader/" rel="external" target="_blank" onclick="_gaq.push([\'_trackEvent\', \'Descargas\', \'Acrobat\', \'Footer\']);">Adobe Reader</a> (Windows, Mac OS, Linux)
            </li>
            <li>
                <h4>Visualizador archivos Word (.doc)</h4>
                <a href="http://bit.ly/MS-WordViewer" rel="external" target="_blank" onclick="_gaq.push([\'_trackEvent\', \'Descargas\', \'Word\', \'Footer\']);">Visualizador Microsoft Word</a> (Windows)<br />
                <a href="http://es.openoffice.org/" rel="external" target="_blank" onclick="_gaq.push([\'_trackEvent\', \'Descargas\', \'openOffice\', \'Footer\']);">OpenOffice.org</a> (Windows, Mac OS, Linux)
            </li>
            <li>
                <h4>Visualizador archivos Excel (.xls)</h4>
                <a href="http://bit.ly/MS-ExcelViewer" rel="external" target="_blank" onclick="_gaq.push([\'_trackEvent\', \'Descargas\', \'Excel\', \'Footer\']);">Visualizador Microsoft Excel</a> (Windows)<br />
                <a href="http://es.openoffice.org/" rel="external" target="_blank" onclick="_gaq.push([\'_trackEvent\', \'Descargas\', \'openOffice\', \'Footer\']);">OpenOffice.org</a> (Windows, Mac OS, Linux)
            </li>
            <li>
                <h4>Visualizador archivos Power Point (.ppt) </h4>
                <a href="http://bit.ly/MS-PowerPointViewer" rel="external" target="_blank" onclick="_gaq.push([\'_trackEvent\', \'Descargas\', \'PowerPoint\', \'Footer\']);">Visualizador Microsoft PowerPoint</a> (Windows)<br />
                <a href="http://es.openoffice.org/" rel="external" target="_blank" onclick="_gaq.push([\'_trackEvent\', \'Descargas\', \'openOffice\', \'Footer\']);">OpenOffice.org</a> (Windows, Mac OS, Linux)
            </li>
            </ul>
            <h3>Navegadores</h3>
            <ul class="visualizadores">
            <li>
                <h4>Navegador Web Mozilla Firefox</h4>
                <a title="Descargar Mozilla Firefox" href="http://www.mozilla.org/es-ES/firefox/" rel="external" target="_blank" onclick="_gaq.push([\'_trackEvent\', \'Descargas\', \'Firefox\', \'Footer\']);">Firefox</a> (Windows, Mac OS, Linux)
            </li>
            <li>
                <h4>Navegador Web Google Chrome</h4>
                <a title="Descargar Google Chrome" href="http://www.google.com/chrome?hl=es" rel="external" target="_blank" onclick="_gaq.push([\'_trackEvent\', \'Descargas\', \'Chrome\', \'Footer\']);">Chrome</a> (Windows, Mac OS, Linux)
            </li>
            <li>
                <h4>Navegador Web Opera</h4>
                <a title="Descargar Opera" href="http://www.opera.com/download/" rel="external" target="_blank" onclick="_gaq.push([\'_trackEvent\', \'Descargas\', \'Opera\', \'Footer\']);">Opera</a> (Windows, Mac OS, Linux)
            </li>
            </ul>
            ';
        $data['content'] = 'contenido/base';
        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('template', $data);
    }

    

}