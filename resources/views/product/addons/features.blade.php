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
              {!! link_to_action('FeaturesController@edit', '| Actualizar', $feature->id) !!}
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
            <img
              src="{!! asset($feature->image->path) !!}"
              alt="{{ $feature->image->alt }}"
              class="img-responsive" />

            @if($feature->file)
              {!! link_to_asset($feature->file->path, 'descargar archivo') !!}
            @endif
          </div>
        </div>
      </div>
    @endforeach
    @if($isUserValid && $product->features->count() < 5)
      {!! link_to_action('FeaturesController@create', 'Crear nuevo Distintivo', $product->id) !!}
    @endif
  </div>
@else
  @if(Auth::user())
    @if(Auth::user()->isOwnerOrAdmin($product->id))
      {!! link_to_action('FeaturesController@create', 'Crear nuevo Distintivo', $product->id) !!}
    @endif
  @else
    Sin información detallada
  @endif
@endif
