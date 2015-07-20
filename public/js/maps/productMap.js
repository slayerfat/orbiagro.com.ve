// el objeto que contiene los detalles del mapa
var map;
// opciones para la iniciacion del mapa
var mapOptions;

// crea el canvas inicial segun los valores otorgados
function initialize(latitude, longitude, zoom) {
  if (latitude === undefined || longitude === undefined)
  {
    latitude  = 7.0695837;
    longitude = -65.582422;
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
  $('input[name="longitude"]').val(map.center.lng());
  $('input[name="latitude"').val(map.center.lat());
  $('input[name="zoom"').val(map.zoom);
}

// para cambiar o hacer una nueva vista del mapa segun la direccion a buscar
function make(address, zoom){
  var zoomLvl;

  if (zoom === undefined) {
    zoomLvl = 10;
  }else {zoomLvl = zoom;}
  // se cambia el zoom
  map.setZoom(zoomLvl);

  getAdress(address);
  changeInputs();
}

function determineZoomLvl(address) {
  switch (parseInt(address)) {
    case 2:
      return 7;
    case 3:
      return 7;
    case 4:
      return 8;
    case 6:
      return 9;
    case 7:
      return 8;
    case 9:
      return 9;
    case 10:
      return 8;
    case 11:
      return 9;
    case 12:
      return 8;
    case 13:
      return 8;
    case 16:
      return 8;
    case 18:
      return 8;
    case 19:
      return 9;
    case 22:
      return 9;
    case 24:
      return 8;
    default:
      return 10;
  }
}

$(document).ready(function () {

  var lng = parseFloat($('input[name="longitude"]').val());
  var lat = parseFloat($('input[name="latitude"').val());
  var zoom;
  var address;

  // si por alguna razon la latitud o longitud no son numeros
  if (!$.isNumeric(lng) || !$.isNumeric(lat))
  {
    initialize();
  }
  // se chequea que no sean exactamente 0 (por defecto los campos son 0 en la vista)
  else if (lng !== 0 && lat !== 0)
  {
    // se chequea adicionalmente el zoom
    if ($.isNumeric($('input[name="zoom"').val())) {
      zoom = parseInt($('input[name="zoom"').val());
    }else{zoom = null;}

    initialize(lat, lng, zoom);
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

    zoom = determineZoomLvl($('#state_id :selected').val());
    make(address, zoom);
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
