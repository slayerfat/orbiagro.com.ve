@unless ($product->features->isEmpty())
  <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    @foreach ($product->features as $feature)
      <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="target_{{ $feature->id }}">
          <h4 class="panel-title">
            <a
              class="collapsed"
              data-toggle="collapse"
              data-parent="#accordion"
              href="#collapsed_{{$feature->id}}"
              aria-expanded="false"
              aria-controls="collapsed_{{$feature->id}}">
              {{ $feature->title }}
            </a>
            @if($isUserValid)
              {!! link_to_route('products.features.edit', '| Actualizar', $feature->id) !!}
            @endif
            @if($isUserValid)
            <a
              href="#"
              onclick='deleteResourceFromAnchor({{"\"delete-feature-$feature->id\""}})'>
              | Eliminar
            </a>
            {!! Form::open([
              'method' => 'DELETE',
              'route' => ['products.features.destroy', $feature->id],
              'class' => 'hidden',
              'id' => "delete-feature-{$feature->id}"]) !!}
            {!! Form::close() !!}
            @endif
          </h4>
        </div>
        <div
          id="collapsed_{{$feature->id}}"
          class="panel-collapse collapse"
          role="tabpanel"
          aria-labelledby="target_{{ $feature->id }}">
          <div class="panel-body">
            {{ $feature->description }}

            {{-- TODO mejorar la imagen del feature --}}
            @if($feature->image)
              <img
                src="{!! asset($feature->image->medium) !!}"
                alt="{{ $feature->image->alt }}"
                width="384"
                style="margin:auto;"
                class="img-responsive" />

              @if($isUserValid)
                <div class="col-xs-2">
                  <span>
                    <a href="{{ route('images.edit', $feature->image->id) }}">
                      <button
                        type="button"
                        name="image-edit"
                        class="btn btn-default">Editar Imagen</button>
                    </a>
                  </span>
                </div>
              @endif
            @endif

            @if($feature->file)
              {!! link_to_asset($feature->file->path, 'descargar archivo') !!}
            @endif
          </div>
        </div>
      </div>
    @endforeach
    @if($isUserValid && $product->features->count() < 5)
      {!! link_to_route('products.features.create', 'Crear nuevo Distintivo', $product->id) !!}
    @endif
  </div>
@else
  @if(Auth::user())
    @if(Auth::user()->isOwnerOrAdmin($product->user_id))
      {!! link_to_route('products.features.create', 'Crear nuevo Distintivo', $product->id) !!}
    @endif
  @else
    Sin información detallada
  @endif
@endif

@section('productFeature-js')
  <script type="text/javascript" src="{!! asset('js/show/deleteResourceFromAnchor.js') !!}"></script>
@stop
