@unless($promotions->isEmpty())
<div class="container-fluid bloque-4-4-4-info">
  <div class="container">
    <div class="row">
      <!-- elimina first child -->
      <div class="media"><div class="media-body"></div></div>
      <!-- importante -->
      @foreach($promotions as $promo)
        <div class="media col-md-4">
          <a class="pull-left" href="#">
            <img class="media-object" src="{{ $promo->images->first()->path }}" alt="{{ $promo->slug }}" style="max-height:150px;">
          </a>
          <div class="media-body">
            <h4 class="media-heading">{{$promo->title}}</h4>
            {{$promo->description}}
            <p>
              <a href="#">Mas Información</a>
            </p>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>
@endunless
