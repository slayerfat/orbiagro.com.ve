@unless($product->images->isEmpty())
  <div class="row">
    <div class="col-xm-12">
      <div class="slider slider-for">
        @foreach ($product->images as $image)
          <div>
            @if(Auth::user() and Auth::user()->isOwnerOrAdmin($product->user_id))
              <div class="col-xs-6">
                <a href="{{ route('images.edit', $image->id) }}">
                  <button
                    type="button"
                    name="image-edit"
                    class="btn btn-default btn-block">Editar Imagen</button>
                </a>
              </div>

              <div class="col-xs-6">
                {!! Form::open(['method' => 'DELETE', 'route' => ['images.destroy', $image->id]]) !!}
                {!! Form::submit('Eliminar', ['class' => 'btn btn-danger btn-block', 'onclick' => 'deleteResourceConfirm()']) !!}
                {!! Form::close() !!}
              </div>
            @endif
            <img
              src="{!! asset($image->large) !!}"
              alt="{{ $image->alt }}"
              class="img-responsive"/>
          </div>
        @endforeach
      </div>
      <div class="slider slider-nav">
        @foreach ($product->images as $image)
          <div>
            <img
              src="{!! asset($image->small) !!}"
              alt="{{ $image->alt }}"
              class="img-responsive"/>
          </div>
        @endforeach
      </div>
    </div>
  </div>
@endunless
