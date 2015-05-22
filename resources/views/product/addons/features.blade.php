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
              src="{!! asset($feature->images->first()->path) !!}"
              alt="{{ $feature->images->first()->alt }}"
              class="img-responsive" />

            {!! link_to_asset($feature->files->first()->path, 'descargar archivo') !!}
          </div>
        </div>
      </div>
    @endforeach
    @if(Auth::user()->isOwnerOrAdmin($product->id) && $product->features->count() < 5)
      {!! link_to_action('FeaturesController@create', 'Crear nuevos Features', $product->id) !!}
    @endif
  </div>
@else
  @if(Auth::user())
    @if(Auth::user()->isOwnerOrAdmin($product->id))
      {!! link_to_action('FeaturesController@create', 'Crear nuevos Features', $product->id) !!}
    @endif
  @else
    Sin información detallada
  @endif
@endif
