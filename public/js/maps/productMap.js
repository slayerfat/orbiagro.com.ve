var map;
var mapOptions;

function initialize() {
  mapOptions = {
    center: { lat: 10.5000, lng: -66.9667},
    zoom: 6
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

function make(){
  // se cambia el zoom
  map.setZoom(9);
  // el "query string"
  address = $('#state_id :selected').html()+', venezuela';
  getAdress(address);
}

google.maps.event.addDomListener(window, 'load', initialize);

$(document).ajaxStop(function () {
  var address;
  if ( $.isNumeric( $('#state_id').val() ) )
  {
    make();
  }

  $('#state_id').change(function(){
    make();
  });
});
