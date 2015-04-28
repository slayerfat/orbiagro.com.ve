var map;
var mapOptions;

function initialize(latitude, longitude, zoom) {
  if (latitude === undefined || longitude === undefined)
  {
    latitude = 10.5000;
    longitude = -66.9667;
  }
  if (zoom === undefined)
  {
    zoom = 6;
  }
  mapOptions = {
    center: { lat: latitude, lng: longitude},
    zoom: zoom
  };
  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
}

function getAdress(address){
  // https://developers.google.com/maps/documentation/javascript/geocoding#GeocodingStatusCodes
  var geocoder = new google.maps.Geocoder();
  // el "query"
  geocoder.geocode( {'address': address}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      map.setCenter(results[0].geometry.location);
      var marker = new google.maps.Marker({
        map: map,
        position: results[0].geometry.location
      });
    } else {
      console.log("Geocode was not successful for the following reason: " + status);
    }
  });
}

function changeInputs(){
  $('input[name="longitude"]').val(map.center.D);
  $('input[name="latitude"').val(map.center.k);
  $('input[name="zoom"').val(map.zoom);
}

function make(){
  // se cambia el zoom
  map.setZoom(9);
  // el "query string"
  var address = $('#state_id :selected').html()+', venezuela';
  getAdress(address);
  changeInputs();
}

$(document).ajaxStop(function () {

  if ( $('input[name="longitude"]') !== 0 || $('input[name="latitude"') !== 0){
    initialize();
  }
  else if ( $.isNumeric( $('#state_id').val() ) )
  {
    initialize();
    make();
  }

  $('#state_id').change(function(){
    make();
  });

  google.maps.event.addListener(map, 'bounds_changed', function() {
    $('input[name="longitude"]').val(map.center.D);
    $('input[name="latitude"').val(map.center.k);
  });

  google.maps.event.addListener(map, 'zoom_changed', function() {
    $('input[name="zoom"').val(map.zoom);
  });
});
