@if ($product->direction)
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <iframe
          width="100%"
          height="450"
          frameborder="0" style="border:0"
          src="https://www.google.com/maps/embed/v1/place?key={!! env('GOOGLE_MAPS_API') !!}
            &q=municipio+{{ $product->direction->first()->parish->town->description }}+edo+{{ $product->direction->first()->parish->town->state->description }}+Venezuela
            &zoom=10&region=ve">
        </iframe>
      </div>
    </div>
  </div>
@endif
