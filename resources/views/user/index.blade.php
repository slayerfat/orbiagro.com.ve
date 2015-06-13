@extends('master')

@section('title')
  - Usuarios en el sistema
@stop

@section('css')
  <link rel="stylesheet" type="text/css" href="{!! asset('css/vendor/bootstrap-table.css') !!}">
@stop

@section('content')
  <div class="container">
    <h1>Usuarios en el sistema</h1>
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
          data-sort-name="first_name"
          >
          <thead>
            <th data-field="name" data-sortable="true" data-switchable="true">
              Seudónimo
            </th>
            <th data-field="email" data-sortable="true" data-switchable="true">
              Correo Electrónico
            </th>
            <th data-field="first_name" data-sortable="true" data-switchable="false">
              Primer Nombre
            </th>
            <th data-field="first_surname" data-sortable="true" data-switchable="false">
              Primer Apellido
            </th>
            <th data-field="phone" data-sortable="true" data-switchable="true">
              Teléfono
            </th>
          </thead>
          <tbody>
            @foreach ($users as $user)
              <tr>
                <td>
                  {{ $user->name }}
                </td>
                <td>
                  {{ $user->email }}
                </td>
                @if($user->person)
                  <td>
                    {{ $user->person->first_name }}
                  </td>
                  <td>
                    {{ $user->person->first_surname }}
                  </td>
                  <td>
                    {{ $user->person->phone }}
                  </td>
                @endif
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
@stop
