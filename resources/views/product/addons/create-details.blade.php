@if($isUserValid)
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <div class="container">
    <div class="col-xs-12">
      <div id="product-hero-details">{!! $product->heroDetails !!}</div>
    </div>

    <div class="col-xs-4 col-xs-offset-4">
      <a
        href="#"
        class="btn btn-primary btn-block"
        id="product-hero-details-button">
          {{ $product->heroDetails ? 'Actualizar' : 'Crear' }} Detalles
      </a>

      <a
        href="#"
        class="btn btn-default btn-block hidden"
        id="send-hero-details-button">Guardar Detalles</a>
    </div>
    <div class="product-hero-details-message alert" style="display:none;">
      <p></p>
    </div>
  </div>
@endif

@section('product-hero-details-js')
<script type="text/javascript" src="{!! asset('js/vendor/ckeditor/ckeditor.js') !!}"></script>
<script type="text/javascript">
  $(function(){

    var ckEditor  = '{!! asset('js/editor/ckEditor.js') !!}';

    var productDetailsUrl = '{!! route('productos.details', $product->id) !!}';

    var toggleMessage = function(){
      return $('.product-hero-details-message').fadeToggle(1000, function(){
        $(this)
          .children().empty();
      });
    }

    var createMessage = function(msg, classes){
      $('.product-hero-details-message')
        .removeClass('alert alert-danger alert-success')
        .addClass(classes)
        .show()
        .children()
        .html(msg);

      setTimeout(toggleMessage, 10000);
    }

    // http://laravel.com/docs/master/routing#csrf-x-csrf-token
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $('#product-hero-details-button').click(function(e){
      e.preventDefault();

      var element = $(this);

      $.ajax({
        url: ckEditor,
        type: 'post',
        dataType: 'script'
      }).done(function() {
        $('#product-hero-details').prop("contenteditable", true);

        startEditor('product-hero-details', 'inline');

        element.addClass('hidden');

        $('#send-hero-details-button').removeClass('hidden');
      }).fail(function(e) {
        createMessage(
          'Los archivos necesarios no pudieron ser cargados.',
          'alert alert-warning'
        );
      });
    });

    $('#send-hero-details-button').click(function(e){

      // var details = $('#product-hero-details').val();
      // var details = CKEDITOR.inline().getData();
      var details;

      e.preventDefault();

      // actualiza el elemento asociado al editor
      // para poder ser enviado al controlador.
      for ( instance in CKEDITOR.instances ) {
        details = CKEDITOR.instances[instance].getData();
      }

      if (!details) {
        return createMessage(
          'Error, los cambios no pueden ser procesados.',
          'alert alert-warning'
        );
      }

      $.ajax({
        url: productDetailsUrl,
        type: 'post',
        dataType: 'json',
        data: {
          heroDetails: details
        }
      }).done(function(data) {
        if (data.status === true) {
          createMessage(
            'Los detalles fueron guardados.',
            'alert alert-success'
          );
        }
      }).fail(function(data) {
        if (data.responseJSON === undefined) {
          return createMessage(
            'Error Desconocido en el servidor.',
            'alert alert-warning'
          );
        }
        if (data.responseJSON['heroDetails'] !== undefined) {
          createMessage(
            data.responseJSON['heroDetails'],
            'alert alert-danger'
          );
        }
      });
    });
  });
</script>
@stop
