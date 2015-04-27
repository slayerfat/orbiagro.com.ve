<table class="table table-striped">
  <tbody>
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
        {{ $product->characteristics->width_cm() }}
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
        {{ $product->characteristics->weight_kg() }}
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
