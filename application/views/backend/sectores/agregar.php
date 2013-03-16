<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <span>Agregar Sector</span>
</div>

<div class="pane">
    <h2>Agregar Sector</h2>

    <fieldset>
        <legend>Datos sector</legend>
        <form class="ajaxForm" action="<?= site_url('backend/sectores/form_agregar') ?>" method="post" accept-charset="utf-8">
            <div class="validacion"></div>
            <table class="formTable">
                <tr>
                    <td>ID</td>
                    <td><input type="text" name="codigo" size="10" value="" /></td>
                </tr>
                <tr>
                    <td>Nombre <span class="red">*</span></td>
                    <td><input type="text" name="nombre" size="90" value="" /></td>
                </tr>
                <tr>
                    <td>Tipo</td>
                    <td><input type="text" name="tipo" size="90" value="" /></td>
                </tr>

                <tr>
                    <td>Sector</td>
                    <td>

                        <select data-placeholder="Seleccione Sector..." name="sector_padre_codigo" class="chzn-select" style="width: 485px">
                            <option value=""></option>
                            <?php
                            foreach ($sectores as $s) {
                                ?>
                                <option value="<?= $s->codigo ?>"><?= $s->nombre.' ('.$s->tipo.')' ?></option>
                                        <?php
                                    }
                                    ?>
                        </select>

                    </td>

                </tr>
                <tr>
                    <td>Latitud</td>
                    <td><input type="text" name="lat" size="90" value="" /></td>
                </tr>
                <tr>
                    <td>Longitud</td>
                    <td><input type="text" name="lng" size="90" value="" /></td>
                </tr>

                <tr>
                    <td colspan="2">
                        <div id="map_canvas" style="height:450px;"></div>
                        <button type="button" class="guardar" id="actualizaLatLng">Actualizar Posición</button>
                    </td>
                </tr>

                <tr>
                    <td colspan="2"><p class="red">* Campos Obligatorios</p></td>
                </tr>
                <tr>
                    <td colspan="2" class="botones">
                        <button type="submit" class="guardar">Guardar</button>
                        <button type="button" class="cancelar" onclick="javascript:history.back()">Cancelar</button>
                    </td>
                </tr>
            </table>
        </form>

        <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                var lat = '';
                var lng = '';

                if(!lat || !lng){
                    lat = -36.8199430371596;
                    lng = -73.0978137119543;
                }

                var myOptions = {
                    scaleControl: true,
                    center: new google.maps.LatLng(lat,lng),
                    zoom: 8,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    scrollwheel: false
                };

                var map = new google.maps.Map(document.getElementById('map_canvas'),myOptions);

                var image = 'assets/images/punto.png';

                marker = new google.maps.Marker({
                    map: map,
                    position: new google.maps.LatLng(lat,lng),
                    icon: image,
                    draggable: true
                });

                marker.setMap(map);

                $('#actualizaLatLng').click( function(){
                    console.log('lat: '+marker.getPosition().lat());
                    console.log('lng: '+marker.getPosition().lng());
                    $("input[name=lat]").val(marker.getPosition().lat());
                    $("input[name=lng]").val(marker.getPosition().lng());
                });

            });
        </script>
    </fieldset>

</div>
