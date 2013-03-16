<script type="text/javascript">
    $(document).ready(function(){
        $.post(site_url+"fichas/ajax_inserta_visita/"+<?=$ficha->Maestro->id?>);
    });
</script>

<div id="content" class="clearfix">
    <div id="maincontent" class="left clearfix">
        <div class="breadcrumbs">
            <?php if(isset($perfil) && $perfil == 'empresas'): ?>
            <a href="<?= site_url('/') ?>">Portada</a> / <a href="<?= site_url('/empresas/') ?>">Empresas y Organizaciones</a> /
            <?php
                if($subtema){
                    list($st_id,$st_nombre) = explode("#",$subtema);
                    echo anchor(site_url('/empresas/subtemas/'.$st_id),$st_nombre)." /";
                }
            ?>
            <?= $ficha->titulo ?>
            <?php else: ?>
            <a href="<?= site_url('/') ?>">Portada</a> / <?= $ficha->titulo ?>
            <?php endif; ?>
        </div>
        <div class="wrap_header_ficha clearfix">
            <h2 class="title"><?= $ficha->titulo ?></h2>
            <p class="responsible">Información proporcionada por: <strong> <a href="<?= site_url('servicios/ver/' . $ficha->Servicio->codigo ) ?>"><?= $ficha->Servicio->nombre . ( ($ficha->Servicio->sigla) ? ' ('.$ficha->Servicio->sigla.')' : '' ) ?></a></strong></p>
            <?php if($ficha->publicado_at): ?><p class="meta">Última actualización: <?= strftime('%d/%m/%Y', mysql_to_unix($ficha->publicado_at)) ?></p><?php endif; ?>

          <dl id="options">
                <?php
                if (!empty($ficha->guia_online) || !empty($ficha->guia_oficina) || !empty($ficha->guia_telefonico) || !empty($ficha->guia_correo)) {
                    ?>
                    <dd><a href="<?= current_url() ?>#howto" class="red-text">Cómo realizar este trámite</a></dd>
                    <?php
                }
                ?>
                <script type="text/javascript">
                        $(document).ready(function(){
                            loadRating(".ratingFicha", <?= $ficha->Maestro->id ?>);
                        });
                    </script>
                <dd class="ratingFicha"></dd>
            </dl>
        <?php
            $this->load->view("fichas/access_share_menu.php");
            ?>
            </div>
        <div class="shadow" />&nbsp;</div>
        <div class="txt">
            <?php
            if (!$ficha->flujo) {
                ?>
                <h3 class="first_topic"><span class="title-bullet"></span>Descripción</h3>
                <?= prepare_content_ficha($ficha->objetivo) ?>
                <?php
            }
            if (!empty($ficha->beneficiarios)) {
                if (!$ficha->flujo) {
                    ?>
                    <hr />
                    <h3><span class="title-bullet"></span>Beneficiarios</h3>
                    <?php
                }
                echo prepare_content_ficha($ficha->beneficiarios)
                ?>
                <?php
            }

            if (!empty($ficha->doc_requeridos)) {
                ?>
                <hr />
                <h3><span class="title-bullet"></span>Documentos requeridos</h3>
                <?= prepare_content_ficha($ficha->doc_requeridos) ?>
                <?php
            }
            ?>
        </div>
        <?php
        if (!empty($ficha->guia_online) || !empty($ficha->guia_oficina) || !empty($ficha->guia_telefonico) || !empty($ficha->guia_correo)) {
        ?>

        <hr /><a name="howto"></a>
        <h3><span class="title-bullet"></span>Paso a paso: Cómo realizar el trámite</h3>
        <div id="howto_tramite">

            <!-- the tabs -->
            <ul class="nav">
                <?php
                echo!empty($ficha->guia_online) ? '<li><a href="#online">En Línea</a></li>' : '';
                echo!empty($ficha->guia_oficina) ? '<li><a href="#oficina">En Oficina</a></li>' : '';
                echo!empty($ficha->guia_telefonico) ? '<li><a href="#telefono">Por Teléfono</a></li>' : '';
                echo!empty($ficha->guia_correo) ? '<li><a href="#correo">Por Correo</a></li>' : '';
                ?>
            </ul>

            <!-- tab "panes" -->
            <div class="panes">
                <?php
                $tramite_online = ($ficha->guia_online_url) ? '<div class="t_online"><a href="' . $ficha->guia_online_url . '" target="_blank" alt="Realizar en línea" title="Realizar en línea">Realizar en línea</a></div>' : '';
                echo!empty($ficha->guia_online) ? '<div id="online">' . prepare_content_ficha($ficha->guia_online) . $tramite_online . '</div>' : '';
                echo!empty($ficha->guia_oficina) ? '<div id="oficina">' . prepare_content_ficha($ficha->guia_oficina) . '</div>' : '';
                echo!empty($ficha->guia_telefonico) ? '<div id="telefono">' . prepare_content_ficha($ficha->guia_telefonico) . '</div>' : '';
                echo!empty($ficha->guia_correo) ? '<div id="correo">' . prepare_content_ficha($ficha->guia_correo) . '</div>' : '';
                ?>
            </div>
            <script type="text/javascript">
                $(document).ready(function(){
                    $(".t_online a").click(function(){
                        _gaq.push(['_trackEvent', 'Fichas', 'Botón Trámite Online', '<?=$ficha->Maestro->id?>']);
                    });
                });
            </script>
        </div>
        <?php
        }
        ?>
    <div class="pasos_print">
    <?php
                $tramite_online = ($ficha->guia_online_url) ? '<div class="t_online"><a href="' . $ficha->guia_online_url . '" target="_blank" alt="Realizar en línea" title="Realizar en línea">Realizar en línea</a></div>' : '';
                echo!empty($ficha->guia_online) ? '<div id="online"><h3 class="print">En Línea</h3>' . $ficha->guia_online . $tramite_online . '</div>' : '';
                echo!empty($ficha->guia_oficina) ? '<div id="oficina"><h3 class="print">En Oficina</h3>' . $ficha->guia_oficina . '</div>' : '';
                echo!empty($ficha->guia_telefonico) ? '<div id="telefono"><h3 class="print">Por Teléfono</h3>' . $ficha->guia_telefonico . '</div>' : '';
                echo!empty($ficha->guia_correo) ? '<div id="correo"><h3 class="print">Por Correo</h3>' . $ficha->guia_correo . '</div>' : '';
                ?>
    </div>
  <hr class="hidden" />
    <ul id="resumen_tramite" class="clearfix">
        <?php echo!empty($ficha->plazo) ? '<li class="first"><h4>Tiempo de realización</h4>' . prepare_content_ficha($ficha->plazo) . '</li>' : '' ?>
        <?php echo!empty($ficha->vigencia) ? '<li class="first"><h4>Vigencia del trámite</h4>' . prepare_content_ficha($ficha->vigencia) . '</li>' : '' ?>
        <?php echo!empty($ficha->costo) ? '<li class="first"><h4>Costo del trámite</h4>' . prepare_content_ficha($ficha->costo) . '</li>' : '' ?>
        <?php echo!empty($ficha->cc_observaciones) ? '<li class="first"><h4>Información relacionada</h4>' . prepare_content_ficha($ficha->cc_observaciones) . '</li>' : '' ?>
        <?php echo!empty($ficha->marco_legal) ? '<li class="marco_legal second"><h4>Marco legal</h4>' . prepare_content_ficha($ficha->marco_legal) . '</li>' : '' ?>
    </ul>

    <img class="qr" src="https://chart.googleapis.com/chart?chs=220x220&amp;cht=qr&amp;chid=<?= md5(uniqid(rand(), true)) ?>&amp;chl=Tr&aacute;mite:%20<?= $ficha->titulo ?>%0D%0A%0D%0AURL:%20<?= site_url('fichas/ver/' . $ficha->maestro_id . '/') ?>" alt="<?= $ficha->titulo ?>" />

    <div class="ratingFicha"></div>

    <?php
    //$this->load->view("fichas/access_share_menu.php");
    ?>
</div>
<?php $this->load->view('widgets/relatedbar.php'); ?>



</div><!-- Content -->
<script type="text/javascript">
    $(document).ready(function(){
    	$('#maincontent').waitForImages(function(){
	      if ($("div#maincontent").height() > $("div#sidebar").height()) {
	        $("div#sidebar").height($("div#maincontent").height())
	      }else{
	        $("div#maincontent").height($("div#sidebar").height())
	      }
    	});
    });
</script>