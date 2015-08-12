<div class="container">
  <div class="carrusel-main">
    @if(isset($carruselCollection))
      @unless($carruselCollection->isEmpty())
        @foreach($carruselCollection as $item)
          @if($item->image)
            <div><img src="{!! $item->image->medium !!}" alt="{!! $item->image->alt !!}" /></div>
          @endif
        @endforeach
      @endunless
    @endif
  </div>
</div>

@section('carrusel-main-js')
  <script charset="utf-8">
    $(document).ready(function(){
      $('.carrusel-main').slick({
        autoplay: true,
        autoplaySpeed: 2000,
        dots: true,
        arrows: false,
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        centerMode: true,
        variableWidth: true
      });
    });
  </script>
@endsection
