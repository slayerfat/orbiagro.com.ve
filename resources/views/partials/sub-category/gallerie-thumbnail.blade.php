@foreach($subCats as $subCat)
  <div class="{{$size}}">
    <div class="thumbnail">
      @if($subCat->image)
        <img
          data-related-subCat="{{ $subCat->id }}"
          src="{!! asset($subCat->image->medium) !!}"
          alt="{{ $subCat->image->alt }}"
          class="img-responsive"/>
      @endif
      <div class="caption" data-related-subCat="{{ $subCat->id }}">
        <h3>
          {!! link_to_route('subCats.show', $subCat->description, $subCat->slug) !!}
        </h3>
      </div>
    </div>
  </div>
@endforeach
