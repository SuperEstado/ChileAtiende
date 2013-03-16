<ul id="sti-menu" class="sti-menu">
    <li style="display:none"></li>
    <li id="portada_etapas">
        <h2 class="sti-item"><img src="assets/images/bullet_rojo.png" width="9" height="12" alt="" />Hechos de vida</h2>
        <h3 class="sti-item">Conoce los servicios y beneficios que el Estado tiene para ti según tu etapa y hecho de vida

            </h3>

<span class="letrachica">Niñez, Adolescencia, Juventud, Adultez ...</span>
        <span class="sti-icon sti-icon-info sti-item"></span>
    </li>
    <li id="portada_temas">
        <h2 class="sti-item"><img src="assets/images/bullet_rojo.png" width="9" height="12" alt="" />
                Temas
        </h2>
        <h3 class="sti-item">
            Descubre los servicios y beneficios que el Estado tiene para ti según tu tema de interés
        </h3>

        <span class="letrachica">Salud, Familia, Trabajo, Seguridad ...</span>
        <span class="sti-icon sti-icon-family sti-item"></span>
    </li>
    <li id="portada_busqueda">
        <h2 class="sti-item"><img src="assets/images/bullet_rojo.png" width="9" height="12" alt="" />Búsqueda</h2>
        <h3 class="sti-item">Accede a nuestro buscador de servicios y beneficios del Estado</h3>

        <span class="letrachica">Ingresa el concepto o palabra ...</span>
        <span class="sti-icon sti-icon-technology sti-item"></span>
    </li>
</ul>
<script type="text/javascript">
    $(document).ready(function() {
        $("#portada_etapas").click(function(){
            _gaq.push(['_trackEvent', 'Acciones', 'Etapas', 'Slider']);
            window.location.href = site_url+"portada/etapas";
        });
        $("#portada_temas").click(function(){
            _gaq.push(['_trackEvent', 'Acciones', 'Temas', 'Slider']);
            window.location.href = site_url+"portada/temas";
        });
        $("#portada_busqueda").click(function(){
            _gaq.push(['_trackEvent', 'Acciones', 'Búsqueda', 'Slider']);
            $("#buscador").expose({
                onBeforeLoad: function(event) {
                    $("#exposeMask").css('opacity','1!important');
                    $("#exposeMask").css('background-image','url(assets/prueba/img/overlay_txt_buscador.png)');
                    $("#exposeMask").css('background-repeat','no-repeat');
                    $("#exposeMask").css('background-position','top center');
                },
                onClose: function(event) {
                    $("#exposeMask").css('opacity','.8!important');
                    $("#exposeMask").css('background-color','rgba(0,0,0,.9) !important');
                    $("#exposeMask").css('background-image','none');
                    $("#exposeMask").css('background-repeat','no-repeat');
                    $("#exposeMask").css('background-position','top center');
                }
            });
        });
    });
</script>