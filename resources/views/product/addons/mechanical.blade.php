@if($product->mechanical)
<table class="table table-striped">
  <tbody>
    @if($isUserValid)
      <tr>
        <td colspan="2">
          {!! link_to_action('MechanicalInfoController@edit', 'Actualizar Informacion Mecanica', $product->mechanical->id) !!}
        </td>
      </tr>
    @endif
    <tr>
      <td>
        Motor
      </td>
      <td>
        {{ $product->mechanical->motor }}
      </td>
    </tr>
    <tr>
      <td>
        Kilometraje
      </td>
      <td>
        {{ $product->mechanical->mileage_km() }}
      </td>
    </tr>
    <tr>
      <td>
        Serial del motor
      </td>
      <td>
        {{ $product->mechanical->motor_serial }}
      </td>
    </tr>
    <tr>
      <td>
        Modelo
      </td>
      <td>
        {{ $product->mechanical->model }}
      </td>
    </tr>
    <tr>
      <td>
        Cilindros
      </td>
      <td>
        {{ $product->mechanical->cylinders }}
      </td>
    </tr>
    <tr>
      <td>
        Caballaje
      </td>
      <td>
        {{ $product->mechanical->horsepower_hp() }}
      </td>
    </tr>
    <tr>
      <td>
        Traccion
      </td>
      <td>
        {{ $product->mechanical->traction }}
      </td>
    </tr>
    <tr>
      <td>
        Capacidad
      </td>
      <td>
        {{ $product->mechanical->lift }}
      </td>
    </tr>
  </tbody>
</table>
@else
  @if($isUserValid)
    {!! link_to_route('products.mechanicals.create', 'Crear Informacion Mecanica', $product->id) !!}
  @endif
@endif
