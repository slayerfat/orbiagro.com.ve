@extends('master')

@section('css')
  <link rel="stylesheet" type="text/css" href="{!! asset('css/vendor/bootstrap-table.css') !!}">
@stop

@section('content')
  <div class="container">
    <h1>Fabricantes en el sistema</h1>
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
              Slug
            </th>
            <th data-field="name" data-sortable="true" data-switchable="true">
              Name
            </th>
            <th data-field="domain" data-sortable="true" data-switchable="true">
              Dominio
            </th>
            <th data-field="url" data-sortable="true" data-switchable="false">
              Dirección Url
            </th>
            <th data-field="total" data-sortable="true" data-switchable="true">
              Productos
            </th>
            <th data-field="operate" data-formatter="operateFormatter" data-events="operateEvents">Acciones</th>
          </thead>
          <tbody>
            @foreach ($makers as $maker)
              <tr>
                <td>
                  {{ $maker->slug }}
                </td>
                <td>
                  {{ $maker->name }}
                </td>
                <td>
                  {{ $maker->domain }}
                </td>
                <td>
                  {{ $maker->url }}
                </td>
                <td>
                  {{ $maker->products->count() }}
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
    initBootstrapTable("{!! route('makers.show', 'no-data') !!}")
  </script>
@stop
