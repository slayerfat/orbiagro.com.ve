@foreach($subCats as $subCat)
  <div class="{{$size}}">
    <div class="thumbnail">
      @if($subCat->image)
        <img
          data-related-subCat="{{ $subCat->id }}"
          src="{!! asset($subCat->image->path) !!}"
          alt="{{ $subCat->image->alt }}"
          class="img-responsive"/>
      @endif
      <div class="caption" data-related-subCat="{{ $subCat->id }}">
        <h3>
          {!! link_to_action('SubCategoriesController@show', $subCat->description, $subCat->slug) !!}
        </h3>
      </div>
    </div>
  </div>
@endforeach
