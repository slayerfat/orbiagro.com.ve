@if(isset($image))
  <div class="col-xs-2">
  <span>
    <a href="{{ route('images.edit', $image->id) }}">
      <button
        type="button"
        name="image-edit"
        class="btn btn-default btn-block">Editar Imagen</button>
    </a>
  </span>
  </div>
  <div class="col-xs-2">
    {!! Form::open(['method' => 'DELETE', 'route' => ['images.destroy', $image->id]]) !!}
    {!! Form::submit('Eliminar Imagen', ['class' => 'btn btn-danger btn-block', 'onclick' => 'deleteResourceConfirm()']) !!}
    {!! Form::close() !!}
  </div>
  <div>
    <img
      src="{!! asset($image->small) !!}"
      alt="{{ $image->alt }}"
      class="img-responsive"/>
  </div>
@endif
