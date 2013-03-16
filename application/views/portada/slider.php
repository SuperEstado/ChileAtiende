<div><?php $this->load->view('portada/slides/' . $slide); ?></div>

<?php if (isset($slide) && !($slide == "temas" || $slide == "etapas")): ?>
    <!-- FICHAS DESTACADAS -->
    <div id="contenido_hot">
        <div class="tramites_frecuentes_titulo">MÁS VISTOS ESTA SEMANA</div>
    <?php if ($fichasMasVistas): ?>
        <ul>
        <?php foreach ($fichasMasVistas as $ficha): ?>
            <li>
                <p><a href="<?= site_url("fichas/ver/" . $ficha->maestro_id); ?>" class="ficha"> <?= $ficha->titulo; ?></a> (<?= $ficha->total ?> visitas)</p>
                <a href="<?= site_url("servicios/ver/" . $ficha->Servicio->codigo); ?>" class="institucion"><?= $ficha->Servicio->nombre . ( ($ficha->Servicio->sigla) ? ' (' . $ficha->Servicio->sigla . ')' : '' ) ?> </a>
            </li>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>
        </div>

        <!-- FICHAS MAS VISTAS -->
        <div id="destacados">
            <div class="tramites_frecuentes_titulo">DESTACAMOS</div>
    <?php if ($fichasDestacadas): ?>
                <ul>
        <?php foreach ($fichasDestacadas as $ficha): ?>
                    <li>
                        <p><a href="<?= site_url("fichas/ver/" . $ficha->maestro_id); ?>" class="ficha"> <?= $ficha->titulo; ?></a></p>
                        <a href="<?= site_url("servicios/ver/" . $ficha->Servicio->codigo); ?>" class="institucion"><?= $ficha->Servicio->nombre . ( ($ficha->Servicio->sigla) ? ' (' . $ficha->Servicio->sigla . ')' : '' ) ?> </a>
                    </li>
        <?php endforeach; ?>
                </ul>
    <?php endif; ?>
                </div>

                <div id="general">
                <div class="tramites_frecuentes_subtitulo">
                        Comunícate con ChileAtiende</div>
<div class="comunicate">
                        <div class="redessociales">
                            <h4>Redes Sociales</h4>
                            <a href="http://twitter.com/chileatiende" target="_blank"><img src="<?= site_url('assets/images/redsocial/twitter.png') ?>" alt="Twitter" title="Siguenos en Twitter" /></a>
                            <a href="http://facebook.com/chileatiende" target="_blank">
                                <img src="<?= site_url('assets/images/redsocial/facebook.png') ?>" alt="Facebook" title="Siguenos en Facebook" /></a>
                        </div>
                        <div class="telefono">
                            <h4>Call Center</h4>
                            <p>101</p>
                        </div>
<div class="clear"></div>
                    </div>
                    <div class="tramites_frecuentes_titulo">
                        Acerca de ChileAtiende</div>
                    <ul>
                        <li><a href="http://info.chileatiende.cl/">¿Qué es ChileAtiende?</a></li>
                        <li><a href="http://info.chileatiende.cl/servicios-disponibles/" target="_blank">Servicios disponibles</a></li>
                        <li><a href="<?= site_url('/oficinas/') ?>">Sucursales ChileAtiende</a></li>
                    </ul>
                    
                    
                </div>
                <div id="noticias">
                  <div class="noticias_frecuentes_subtitulo"> Noticias ChileAtiende
                    <div class="rss"><a href="<?php echo site_url('/noticias/rss'); ?>" title="RSS">RSS</a></div>
                  </div>
                  <div class="items">
                  	<?php foreach ($noticias as $key => $noticia){ ?>
                  		<div class="noticia<?php echo $key==(count($noticias)-1)?' final':''; ?><?php echo !$noticia->foto?' no-foto':''; ?>">
                  			<div class="foto">
                  				<img src="assets/timthumb/timthumb.php?zc=1&w=110&h=75&src=<?php echo $noticia->foto?'uploads/noticias/'.$noticia->foto:'assets/images/placeholder_noticias_home.png'; ?>" alt="<?php echo $noticia->titulo; ?>">
                  			</div>
                  			<div class="titulo">
                  				<a href="<?php echo site_url('noticias/ver/' . $noticia->alias); ?>">
                  					<?php echo $noticia->titulo; ?>
                  				</a>
                  			</div>
                  			<div class="descripcion">
                  				<?php echo word_limiter(strip_tags($noticia->contenido),35); ?>
                  			</div>
                  		</div>
                  	<?php } ?>
                    <div class="otras_noticias">
                    	<a href="<?= site_url('/noticias') ?>">Noticias anteriores</a>
                    </div>
                  </div>
                </div>
<div id="map">
    <script type="text/javascript">
                        $(document).ready(function(){

                            var myOptions = {
                                scaleControl: true,
                                center: new google.maps.LatLng(-33.444593,-70.653591),
                                zoom: 8,
                                mapTypeId: google.maps.MapTypeId.ROADMAP,
                                scrollwheel: false
                            };

                            var map = new google.maps.Map(document.getElementById('map_canvas'),
                            myOptions);

                            var image = 'assets/images/punto.png';


<?php foreach ($oficinas as $o): ?>

                            marker = new google.maps.Marker({
                                id: <?= $o->id ?>,
                                map: map,
                                position: new google.maps.LatLng(<?= $o->lat ?>, <?= $o->lng ?>),
                                icon: image,
                                title: "<?= $o->nombre ?>"
                            });
                            google.maps.event.addListener(marker, 'click', function() {
                                var marcador=this;
                                _gaq.push(['_trackEvent', 'Sucursales', 'Click_Info_Sucursal', 'Mapa', marcador.title]);
                                $.get(site_url+"oficinas/ajax_load_infowindow/"+marcador.id,function(response){
                                    var infowindow = new google.maps.InfoWindow({
                                        content: response,
                                        maxWidth: 400
                                    });
                                    infowindow.open(map,marcador);
                                });

                            });
<?php endforeach; ?>

                            $("select[name=comuna]").change(function(){
                            	var idComuna = $(this).attr('value'),
                            		nombreComuna = $(this).find('option[value="'+idComuna+'"]').data('nombre');
                            	_gaq.push(['_trackEvent', 'Sucursales', 'Cambia_Comuna_Mapa', 'Mapa', nombreComuna]);
                              $.getJSON(site_url+"sectores/ajax_get_info/"+idComuna,function(response){
                                  map.panTo(new google.maps.LatLng(response.lat, response.lng));
                                  map.setZoom(12)
                              });
                            });

                            $("#comunair").click( function(e){
                            	var idComuna = $("#comuna").attr('value'),
                            		nombreComuna = $("#comuna").find('option[value="'+idComuna+'"]').data('nombre');
                            	_gaq.push(['_trackEvent', 'Sucursales', 'ClickIr_Comuna_Mapa', 'Mapa', nombreComuna]);
                              e.preventDefault();
                              $.getJSON(site_url+"sectores/ajax_get_info/"+idComuna,function(response){
                                  map.panTo(new google.maps.LatLng(response.lat, response.lng));
                                  map.setZoom(12)
                              });
                            });

                        });



                        </script>


                        <div class="tramites_frecuentes_subtitulo">Sucursales ChileAtiende</div>
                        <div class="comuna">Selecciona una comuna
                            <form id="form1" name="form1" method="post" action="<?= site_url('/') ?>">
                                <label for="comuna">
                                    <select name="comuna" id="comuna">
                                        <option>Seleccionar...</option>
                    <?php foreach ($comunas as $c): ?>
                            <option value="<?= $c->codigo ?>" data-nombre="<?= $c->nombre ?>"><?= $c->nombre ?> (<?= ($c->noficinas>1) ? $c->noficinas.' sucursales' : $c->noficinas.' sucursal' ?>)</option>
                    <?php endforeach; ?>
                        </select>
                    </label>
                    <input type="submit" id="comunair" value="Ir" />
                </form>
                <span class="mensaje"><strong><?= $oficinas->count() ?> Sucursales</strong> a tu disposición a lo largo del país</span>

                <div align="center" id="map_canvas" style="width: 930px; height: 331px; border-bottom: 1px solid #ccc;" /></div>

            <!-- <div style = "text-align: right;font-weight: bold; color: #EE4143; margin-top: 5px" >*Las ubicaciones de los Centros de Atención son referenciales.</div> -->

        </div>

        <script type="text/javascript">
            function detectMobile(){
                var a = navigator.userAgent;
                if(/android.+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))
                    window.location= site_url+'movil';
            }
            $(document).ready(function(){
                $('#comuna').customStyle();
                //console.log(site_url);
                /*if(!$.cookie('movil')){
                    detectMobile();
                }*/
            });
        </script>

<?php endif; ?>