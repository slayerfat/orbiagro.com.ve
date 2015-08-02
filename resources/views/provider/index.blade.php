@extends('master')

@section('css')
  <link rel="stylesheet" type="text/css" href="{!! asset('css/vendor/bootstrap-table.css') !!}">
@stop

@section('content')
  <div class="container">
    <h1>Proveedores en el Sistema</h1>
    <hr/>
    <div class="row">
      <div class="col-sm-12">
        <table
          id="tabla"
          data-toggle="table"
          data-search="true"
          data-height="400"
          data-pagination="true"
          data-page-list="[10, 25, 50, 100]"
          data-show-toggle="true"
          data-show-columns="true"
          data-click-to-select="true"
          data-maintain-selected="true"
          data-sort-name="name"
          >
          <thead>
            <th data-field="resource" data-sortable="true" data-switchable="true">
              Id
            </th>
            <th data-field="name" data-sortable="true" data-switchable="true">
              Nombre
            </th>
            <th data-field="url" data-sortable="true" data-switchable="false">
              Dirección Url
            </th>
            <th data-field="total" data-sortable="true" data-switchable="true">
              Productos
            </th>
            <th data-field="phone_1" data-sortable="true" data-switchable="true">
              1er. Telefono
            </th>
            <th data-field="contact_title" data-sortable="true" data-switchable="true">
              Titulo de Contacto.
            </th>
            <th data-field="contact_name" data-sortable="true" data-switchable="true">
              Nombre de Contacto
            </th>
            <th data-field="contact_phone_1" data-sortable="true" data-switchable="true">
              1er. Telf. Contacto
            </th>
            <th data-field="operate" data-formatter="operateFormatter" data-events="operateEvents">Acciones</th>
          </thead>
          <tbody>
            @foreach ($providers as $provider)
              <tr>
                <td>
                  {{ $provider->id }}
                </td>
                <td>
                  {{ $provider->name }}
                </td>
                <td>
                  {{ $provider->url }}
                </td>
                <td>
                  {{ $provider->products->count() }}
                </td>
                <td>
                  {{ $provider->phone }}
                </td>
                <td>
                  {{ $provider->contact_title }}
                </td>
                <td>
                  {{ $provider->contact_name }}
                </td>
                <td>
                  {{ $provider->contact_phone_1 }}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@stop

@section('js')
  <script src="{!! asset('js/vendor/bootstrap-table.js') !!}"></script>
  <script src="{!! asset('js/vendor/bootstrap-table-es-CR.js') !!}"></script>
  {{-- añade iconos en la tabla con actividades genericas --}}
  <script src="{!! asset('js/show/bootstrap-table.js') !!}"></script>
  <script type="text/javascript">
    initBootstrapTable("{!! action('ProvidersController@show', 'no-data') !!}")
  </script>
@stop
