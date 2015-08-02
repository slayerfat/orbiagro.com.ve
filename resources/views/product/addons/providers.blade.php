@if($product->providers && !Auth::guest() && Auth::user()->isAdmin())
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <h2>Proveedores</h2>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>
                Nombre
              </th>
              <th>
                Telefono
              </th>
              <th>
                Contacto
              </th>
              <th>
                Telefono contacto
              </th>
              <th>
                SKU
              </th>
              <th>
                Acciones
              </th>
            </tr>
          </thead>
          @foreach($product->providers as $provider)
            <tbody>
              <tr>
                <td>
                  {!! link_to_action('ProvidersController@show', $provider->name, $provider->id) !!}
                </td>
                <td>
                  {{$provider->phone_1}}
                </td>
                <td>
                  {{$provider->contact_name}}
                </td>
                <td>
                  {{$provider->contact_phone_1}}
                </td>
                <td>
                  {{$provider->pivot->sku ? $provider->pivot->sku : '-'}}
                </td>
                <td>
                  <a class="provider-table-edit" href="{!! action('ProductsProvidersController@edit', [$product->id, $provider->id]) !!}" data-resource="{{$product->id}}" title="Consultar">
                    <i class="glyphicon glyphicon-edit"></i>
                  </a>
                  <a
                    class="provider-table-destroy"
                    href="{!! action('ProductsProvidersController@destroy', [$product->id, $provider->id]) !!}"
                    data-product="{{$product->id}}"
                    data-provider="{{$provider->id}}"
                    title="Eliminar">
                    <i class="glyphicon glyphicon-remove"></i>
                  </a>
                </td>
              </tr>
            </tbody>
          @endforeach
          <tbody>
            <tr>
              <td colspan="6">
                {!! link_to_action('ProductsProvidersController@create', 'Crear nuevo Proveedor', $product->id) !!}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endif

@section('productProvider-js')
  <script type="text/javascript">
    $(function(){
      $('.provider-table-destroy').click(function(e){

        // se previene el click
        e.preventDefault();

        var element = $(this);

        // se pregunta al usuario
        // TODO: mejorar elementos visuales.
        if (confirm('Esta Seguro?'))
        {
          // http://laravel.com/docs/master/routing#csrf-x-csrf-token
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });

          console.log($(this));

          $.ajax({
            url: element.prop('href'),
            type: 'DELETE',
            dataType: 'json'
          })
          .done(function() {
            element.closest('tr').remove();
            console.log(element.closest('tr'));
            console.log("Deleted resource");
            console.log("success");
          })
          .fail(function() {
            console.log("error");
          });
        }
      });
    });
  </script>
@stop
