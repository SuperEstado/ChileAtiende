<script type="text/javascript" src="assets/js/etapas.js"></script>
<div id="etapas">
    <form action="buscar/fichas/" method="get">
        <div class="encabezado_temas">
            <span></span>
            <h2 class="temas_title">Hechos de vida</h2>
            <p><strong>Selecciona una etapa y un hecho</strong> de tu interés </p>
        </div>

        <div class="paso1">
            <div class="lista">
                <div class="ui-widget-content hoverscroll vertical" style="width: 170px; height: 300px;">
                    <div class="listcontainer" style="width: 170px; height: 300px;">
                        
                        <ul id="my-list" class="list" style="height: 467px;">
                            <?php foreach ($etapas as $e): ?>
                            <li class="item"><label class="label_radio"><input type="radio" value="<?=$e->id?>" name="etapa" /><?=$e->nombre?></label></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="paso2">
            <h3 style="padding-bottom: 10px; font-size: 14px; font-weight: bold;">Seleccione un Hecho de vida</h3>
            <ul>
                <li></li>
            </ul>
			<div class="clear"></div>
<div><input style="display: none;" type="submit" onclick="_gaq.push(['_trackEvent', 'Acciones', 'Buscar', 'Temas']);" class="bt_buscar" value="Buscar" id="button" name="button" /></div>
        </div>

    </form>

</div>
<!-- Fin Contenido -->
