// el objeto que contiene los detalles del mapa
var map;
// opciones para la iniciacion del mapa
var mapOptions;


// crea el canvas inicial segun los valores otorgados
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
  console.log(address);
  // https://developers.google.com/maps/documentation/javascript/geocoding#GeocodingStatusCodes
  var geocoder = new google.maps.Geocoder();
  // el "query"
  geocoder.geocode( {'address': address}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      map.setCenter(results[0].geometry.location);
      // crea un punto rojo en el mapa
      var marker = new google.maps.Marker({
        map: map,
        position: results[0].geometry.location
      });
    } else {
      console.log("Geocode was not successful for the following reason: " + status);
    }
  });
}

// para cambiar todos a la vez segun los datos del mapa
function changeInputs(){
  $('input[name="longitude"]').val(map.center.D);
  $('input[name="latitude"').val(map.center.k);
  $('input[name="zoom"').val(map.zoom);
}

// para cambiar o hacer una nueva vista del mapa segun la direccion a buscar
function make(address){
  // se cambia el zoom
  map.setZoom(10);

  getAdress(address);
  changeInputs();
}

// ajaxStop espera que todas las transacciones ajax culminen antes de ejecutar
$(document).ajaxStop(function () {

  var lng = $('input[name="longitude"]').val();
  var lat = $('input[name="latitude"').val();
  var zoom;
  var address;

  // si por alguna razon la latitud o longitud no son numeros
  if (!$.isNumeric(lng) || !$.isNumeric(lat))
  {
    initialize();
  }
  // se chequea que no sean exactamente 0 (por defecto los campos son 0 en la vista)
  else if (parseFloat(lng) !== 0 && parseFloat(lat) !== 0)
  {
    // se chequea adicionalmente el zoom
    if ($.isNumeric($('input[name="zoom"').val())) {
      zoom = $('input[name="zoom"').val();
    }else{zoom = null;}

    initialize(lng, lat, zoom);
  }
  // si eso falla entonces se busca por el estado
  else if ( $.isNumeric( $('#state_id').val() ) )
  {
    address = 'estado '+$('#state_id :selected').html()+', venezuela';
    initialize();
    make(address);
  }
  // si todo falla se inicia con valores por defecto.
  else
  {
    initialize();
  }

  // si el estado seleccionado cambia se hace el query nuevo
  $('#state_id').change(function(){
    // el "query string"
    address = 'estado '+$('#state_id :selected').html()+', venezuela';
    make(address);
  });

  // cambia segun la posicion del mapa en la vista
  google.maps.event.addListener(map, 'dragend', function() {
    $('input[name="longitude"]').val(map.center.lng());
    $('input[name="latitude"').val(map.center.lat());
  });
  google.maps.event.addListener(map, 'zoom_changed', function() {
    $('input[name="zoom"').val(map.zoom);
  });
});
