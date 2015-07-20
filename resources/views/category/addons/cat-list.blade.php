<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <div class="categorias-listado">
        <h1>{!! link_to_action('CategoriesController@index', 'Categorías en orbiagro.com.ve') !!}</h1>
        <ul class="lista">
          <?php $tercio = ceil($cats->count() / 3); $i = 0; ?>
          @foreach($cats as $cat)
            <li class="categorias-listado-descripcion">
              {!! link_to_action('CategoriesController@show', $cat->description, $cat->slug) !!}
            </li>
            @if($i % $tercio == 0 && $i != 0 && $i + 1 != $cats->count())
              </ul>
              <ul class="lista">
            @elseif($i + 1 == $cats->count())
              </ul>
            @endif
            <?php $i++ ?>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</div>
