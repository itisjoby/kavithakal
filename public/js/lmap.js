let Longitude = "-122.401";
let Latitude = "37.7858";
/*
var map = L.map("map", {
  center: [Latitude, Longitude],
  zoom: 15
});
L.tileLayer("http://{s}.tile.osm.org/{z}/{x}/{y}.png", {
  attribution:
    '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);
*/

var map = L.eeGeo.map("map", "5d09e61ccd12b3d37ec724ea49e03787", {
  center: [Latitude, Longitude],
  zoom: 15
});
