<div class="container">
  <div class="row">
    @if(isset($title))
      <div class="col-xs-12">
        <h1>{{$title}}</h1>
      </div>
    @endif
    <?php $i = 0; $j = 0 ?>
    @foreach($cats as $cat)
    <?php $i++ ?>
    <?php $j++ ?>
    <div class="col-sm-12 well">
      <div class="row">
        <div class="col-xs-8">
          <h1>{!! link_to_route('cats.show', $cat->description, $cat->slug) !!}</h1>
          <h2>
            <a href="{!! route('cats.show', $cat->slug) !!}">
              <em>{{$cat->subCategories->count()}} Rubros</em>
            </a>
          </h2>
          <h3>{{$cat->info}}</h3>
        </div>
        @if($cat->image)
          <div class="col-xs-4">
            <a href="{!! route('cats.show', $cat->slug) !!}">
              <img
              src="{!! asset($cat->image->medium) !!}"
              alt="{{$cat->image->alt}}"
              class="img-responsive"/>
            </a>
          </div>
        @endif
      </div>
    </div>
    @if($i == 3 || $j == $cats->count())
      {{-- ads --}}
      @include('partials.ads.no-parent', ['class' => 'col-xs-12'])
      <?php $i = 0 ?>
    @endif
    @endforeach
  </div>
</div>
