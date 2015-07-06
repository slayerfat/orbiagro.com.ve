@extends('master')

@section('title')
  - Actualizar - Información Personal - {{ $user->name }}
@stop

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">Actualizar Información Personal</div>
          <div class="panel-body">
            @include('errors.bag')
            {!! Form::model($person, [
              'method' => 'PATCH',
              'action' => ['PeopleController@update', $user->id],
              'class' => 'form-horizontal',
              ]) !!}
              @include('people.forms.body', ['textoBotonSubmit' => 'Actualizar Información Personal'])
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@stop

@section('css')
  @yield('people-edit-css')
@stop

@section('js')
  @yield('people-edit-js')
@endsection
