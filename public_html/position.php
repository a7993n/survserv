<?php

?>
<style>
#leafletmap{
  height: 300px;
  border: 1px solid #ccc;
}
button{
  margin: 1.5em;
}
</style>

<div id="leafletmap"></div>
<i class="fa fa-map-marker"></i>
<button class="pure-button pure-button-primary">Get my location</button>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.leafletjs.com/leaflet-0.6.4/leaflet.js"></script>
<script>
var mymap = L.map('leafletmap');
mymap.setView([40.775,-73.972], 15);
L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
    attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
    maxZoom: 18
}).addTo(mymap);

$('html').on('load', function(){
  mymap.locate({setView: true, maxZoom: 15});
});

mymap.on('locationfound', onLocationFound);
function onLocationFound(e) {
    console.log(e); 
    // e.heading will contain the user's heading (in degrees) if it's available, and if not it will be NaN. This would allow you to point a marker in the same direction the user is pointed. 
    L.marker(e.latlng).addTo(mymap);
}

</script>