<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <a href="<?= site_url('backend/oficinas') ?>">Oficinas</a> »
    <span>Editar Oficina #<?= $oficina->id ?></span>
</div>

<div class="pane">
    <h2>Editar Oficina</h2>

    <fieldset>
        <legend>Datos oficina <?= $oficina ? ' - ' . $oficina->nombre : '' ?></legend>
        <form class="ajaxForm" action="<?= site_url('backend/oficinas/form_guardar' . ( $oficina ? '/' . $oficina->id : '')) ?>" method="post" accept-charset="utf-8">
            <div class="validacion"></div>
            <table class="formTable">
                <tr>
                    <td>ID</td>
                    <td><?= $oficina ? $oficina->id : '' ?></td>
                </tr>
                <tr>
                    <td>Nombre <span class="red">*</span></td>
                    <td><input type="text" name="nombre" size="90" value="<?= $oficina ? $oficina->nombre : '' ?>" /></td>
                </tr>
                <tr>
                    <td>Dirección</td>
                    <td><input type="text" name="direccion" size="90" value="<?= $oficina ? $oficina->direccion : '' ?>" /></td>
                </tr>
                <tr>
                    <td>Horario</td>
                    <td><input type="text" name="horario" size="90" value="<?= $oficina ? $oficina->horario : '' ?>" /></td>
                </tr>
                <tr>
                    <td>Teléfonos</td>
                    <td><input type="text" name="telefonos" size="90" value="<?= $oficina ? $oficina->telefonos : '' ?>" /></td>
                </tr>
                <tr>
                    <td>Fax</td>
                    <td><input type="text" name="fax" size="90" value="<?= $oficina ? $oficina->fax : '' ?>" /></td>
                </tr>
                <tr>
                    <td>Sector</td>
                    <td>

                        <select data-placeholder="Seleccione Sector..." name="sector_codigo" class="chzn-select" style="width: 485px">
                            <option value=""></option>
                            <?php
                            foreach ($sectores as $sector) {
                                ?>
                                <option value="<?= $sector->codigo ?>" <?php if ($sector->codigo == $oficina->sector_codigo)
                                echo 'selected="selected"'; ?>><?= $sector->nombre ?></option>
                                        <?php
                                    }
                                    ?>
                        </select>

                    </td>

                </tr>
                <tr>
                    <td>Servicio</td>
                    <td>

                        <select data-placeholder="Seleccione un Servicio" name="servicio_codigo" class="chzn-select">
                            <option value=""></option>
                            <?php
                            foreach ($servicios as $servicio) {
                                echo '<option value="' . $servicio->codigo . '" ' . ( ($oficina->servicio_codigo == $servicio->codigo) ? 'selected="selected"' : '' ) . '>' . $servicio->nombre . '</option>';
                            }
                            ?>
                        </select>

                    </td>
                </tr>
                <tr>
                    <td>Latitud</td>
                    <td><input type="text" name="lat" size="90" value="<?= $oficina ? $oficina->lat : '' ?>" /></td>
                </tr>
                <tr>
                    <td>Longitud</td>
                    <td><input type="text" name="lng" size="90" value="<?= $oficina ? $oficina->lng : '' ?>" /></td>
                </tr>
                <tr>
                    <td>Director</td>
                    <td><input type="text" name="director" size="90" value="<?= $oficina ? $oficina->director : '' ?>" /></td>
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

                var myOptions = {
                    scaleControl: true,
                    center: new google.maps.LatLng(<?= $oficina->lat ?>, <?= $oficina->lng ?>),
                    zoom: 8,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    scrollwheel: false
                };

                var map = new google.maps.Map(document.getElementById('map_canvas'),myOptions);

                var image = 'assets/images/punto.png';

                marker = new google.maps.Marker({
                    id: <?= $oficina->id ?>,
                    map: map,
                    position: new google.maps.LatLng(<?= $oficina->lat ?>, <?= $oficina->lng ?>),
                    icon: image,
                    title: "<?= $oficina->nombre ?>",
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
