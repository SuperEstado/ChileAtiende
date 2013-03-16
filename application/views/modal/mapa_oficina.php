<script type="text/javascript">
    $(document).ready(function(){
        $(".pickoficina").overlay({
            onLoad: function(){
                var aUrl = this.getTrigger().attr('href').split('#');
                var aParams = aUrl[1].split('&');
                var tmpId = aParams[0].split('=');
                var id = tmpId[1];
                var tmpLat = aParams[1].split('=');
                var lat = tmpLat[1];
                var tmpLng = aParams[2].split('=');
                var lng = tmpLng[1];
                //console.log(id, lat, lng);
                despliegaMapa( lat, lng, id );
            }
        });

        function despliegaMapa(lat, lng, idOficina) {
            console.log(idOficina);
            if(!lat || !lng) {
                var lat = -33.439589;
                var lng = -70.655394;
            }

            var myOptions = {
                center: new google.maps.LatLng(lat, lng),
                disableDefaultUI: true,
                zoom: 15,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                scrollwheel: true
            };

            var map = new google.maps.Map(document.getElementById('map_canvas'),myOptions);

            var image = 'assets/images/punto.png';

            marker = new google.maps.Marker({
                id: idOficina,
                map: map,
                position: new google.maps.LatLng(lat, lng),
                icon: image,
                draggable: false
            });
            $.get(site_url+"oficinas/ajax_load_infowindow/"+idOficina,function(response){
                var infowindow = new google.maps.InfoWindow({
                    content: response
                });
                infowindow.open(map,marker);
            });

            marker.setMap(map);
            google.maps.event.trigger(map, 'resize');
        }
    });
</script>
<div id="map" class="simpleOverlay">
    <div id="map_canvas" style="width: 640px; height: 450px;"></div>
</div>