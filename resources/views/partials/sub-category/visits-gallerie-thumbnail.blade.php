@foreach($subCats as $subCat)
  <div class="{{$size}}">
    <div class="thumbnail">
      <img
        data-related-subCat-visits="{{ $subCat->id }}"
        src="{!! asset($subCat->image->path) !!}"
        alt="{{ $subCat->image->alt }}"
        class="img-responsive"/>
      <div class="caption" data-related-subCat-visits="{{ $subCat->id }}">
        <h3>
          {!! link_to_action('SubCategoriesController@show', $subCat->description, $subCat->id) !!}
        </h3>
      </div>
    </div>
  </div>
@endforeach
