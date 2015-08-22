@if(!$product->details && !Auth::guest() && Auth::user()->isOwnerOrAdmin(Auth::id()))
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="container">
        <div class="col-xs-12">
            <textarea class="hidden" id="product-hero-details"></textarea>
        </div>

        <div class="col-xs-4 col-xs-offset-4">
            <a
                href="#"
                class="btn btn-primary btn-block"
                id="product-hero-details-button">Crear Detalles</a>

            <a
                href="#"
                class="btn btn-default btn-block hidden"
                id="send-hero-details-button">Guardar Detalles</a>
        </div>
    </div>
@endif

@section('product-hero-details-js')
<script type="text/javascript" src="{!! asset('js/vendor/ckeditor/ckeditor.js') !!}"></script>
<script type="text/javascript">
    $(function(){

        var productDetailsJs  = '{!! asset('js/editor/product-hero-details.js') !!}';

        var productDetailsUrl = '{!! route('productos.details', $product->id) !!}';

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
                url: productDetailsJs,
                type: 'post',
                dataType: 'script'
            })
            .done(function() {
                console.log("product-hero-details.js success");

                $('#product-hero-details').empty();

                element.addClass('hidden');

                $('#product-hero-details, #send-hero-details-button').removeClass('hidden');

                $('html, body').animate({
                    scrollTop: $("#product-hero-details").offset().top
                }, 2000);
            })
            .fail(function(e) {
                console.log("product-hero-details.js error");
                console.log(e);
            });
        });

        $('#send-hero-details-button').click(function(e){

            e.preventDefault();

            // actualiza el elemento asociado al editor
            // para poder ser enviado al controlador.
            for ( instance in CKEDITOR.instances ) {
                CKEDITOR.instances[instance].updateElement();
            }

            $.ajax({
                url: productDetailsUrl,
                type: 'post',
                dataType: 'json',
                data: {
                    name: "John",
                    location: "Boston",
                    heroDetails: $('#product-hero-details').val(),
                }
            })
            .done(function(data) {
                console.log("send-hero-details-button success");

                if (data.status === true) {
                    console.log(data.status); // stuff
                }
            })
            .fail(function() {
                console.log("send-hero-details-button error");
            });
        });
    });
</script>
@stop
