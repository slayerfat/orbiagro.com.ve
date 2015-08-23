@if($product->nutritional)
<table class="table table-striped">
  <tbody>
    <tr>
      @if($isUserValid)
        <tr>
          <td colspan="2">
            {!! link_to_action('NutritionalsController@edit', 'Actualizar Valores Nutricionales', $product->nutritional->id) !!}
          </td>
        </tr>
      @endif
      <td>
        Fecha de vencimiento
      </td>
      <td>
        {{ $product->nutritional->due }}
      </td>
    </tr>
  </tbody>
</table>
@else
  @if($isUserValid)
    {!! link_to_route('products.nutritionals.create', 'Crear Valores Nutricionales', $product->id) !!}
  @endif
@endif
