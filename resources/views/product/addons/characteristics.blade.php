@if($product->characteristics)
<table class="table table-striped">
  <tbody>
    @if($isUserValid)
      <tr>
        <td colspan="2">
          {!! link_to_route('products.characteristics.edit', 'Actualizar Caracteristicas', $product->characteristics->id) !!}
        </td>
      </tr>
    @endif
    <tr>
      <td>
        Alto
      </td>
      <td>
        {{ $product->characteristics->height_cm() }}
      </td>
    </tr>
    <tr>
      <td>
        Ancho
      </td>
      <td>
        {{ $product->characteristics->widthCm() }}
      </td>
    </tr>
    <tr>
      <td>
        Profundidad
      </td>
      <td>
        {{ $product->characteristics->depth_cm() }}
      </td>
    </tr>
    <tr>
      <td>
        Peso
      </td>
      <td>
        {{ $product->characteristics->weightKg() }}
      </td>
    </tr>
    <tr>
      <td>
        Unidades
      </td>
      <td>
        {{ $product->characteristics->units }}
      </td>
    </tr>
  </tbody>
</table>
@else
  @if($isUserValid)
    {!! link_to_route('products.characteristics.create', 'Crear Caracteristicas del Producto', $product->id) !!}
  @endif
@endif
