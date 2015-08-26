@unless(isset($products))
    @foreach($products as $product)
        <div class="{!!isset($size) ? $size : 'col-xs-4'!!}">
            <div class="thumbnail">
                @unless($product->images->isEmpty())
                    <img
                            src="{!! asset($product->image->medium) !!}"
                            alt="{{ $product->image->alt }}"
                            class="img-responsive"/>
                @endunless
                <div class="caption">
                    <h4>
                        {!! link_to_action('ProductsController@show', $product->title, $product->slug) !!}
                    </h4>
                </div>
            </div>
        </div>
    @endforeach
@endunless
