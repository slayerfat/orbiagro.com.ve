@foreach($subCats as $subCat)
  <div class="{{$size}}">
    <div class="thumbnail">
      @if($subCat->image)
        <img
          data-related-subCat-visits="{{ $subCat->id }}"
          src="{!! asset($subCat->image->medium) !!}"
          alt="{{ $subCat->image->alt }}"
          class="img-responsive"/>
      @endif
      <div class="caption" data-related-subCat-visits="{{ $subCat->id }}">
        <h3>
          {!! link_to_action('SubCategoriesController@show', $subCat->description, $subCat->slug) !!}
        </h3>
      </div>
    </div>
  </div>
@endforeach
