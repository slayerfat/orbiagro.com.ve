<?php namespace App\Mamarrachismo;

class Transformer {

  public $number;

  public function fromMm()
  {
    if (is_numeric($this->number)) :
      return $this->number / 10;
    else:
      return null;
    endif;
  }

  public function toMm()
  {
    if (is_numeric($this->number)) :
      return $this->number * 10;
    else:
      return null;
    endif;
    return null;
  }

  public static function transform($value, $base)
  {
    $transformer = new Transformer;
    $transformer->number = $value;

    switch ($base) {
      case 'mm':
        return $transformer->fromMm();
        break;

      default:
        return null;
        break;
    }
  }
}
