<div class="container-fluid">
  <div class="carrusel-main slide">
    @if(isset($carruselCollection) && !$carruselCollection->isEmpty())
      @foreach($carruselCollection as $item)
        @if($item->image)
          <div>
            <a href="{!! action($item->controller, $item->slug) !!}">
              <img
                class="img-responsive"
                src="{!! $item->image->medium !!}"
                alt="{!! $item->image->alt !!}" />
            </a>
            <div class="slide__caption">
              <h3>
                <?php $title = $item->name ? $item->name : $item->title ?>
                {{ $title ? $title : $item->description }}
              </h3>
            </div>
          </div>
        @endif
      @endforeach
    @endif
  </div>
</div>

@section('carrusel-main-js')
  <script charset="utf-8">
    $(document).ready(function(){
      $('.carrusel-main').slick({
        arrows: false,
        autoplay: true,
        autoplaySpeed: 3000,
        centerMode: false,
        dots: true,
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        speed: 600,
        variableWidth: false,
        responsive: [
          {
            breakpoint: 768,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 1
            }
          },
          {
            breakpoint: 512,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }
        ]
      });
    });
  </script>
@endsection
