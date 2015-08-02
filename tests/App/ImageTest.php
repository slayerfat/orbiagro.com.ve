<?php namespace Tests\App;

use App\Image;
use Tests\TestCase;

class ImageTest extends TestCase {

  /**
   * https://phpunit.de/manual/current/en/fixtures.html
   * @method setUp
   */
  public function setUp()
  {
    parent::setUp();

    $this->tester = new Image;
  }

  public function testCorrectFormattedAlt()
  {
    $this->tester->alt = 'tetsuo kaneda tetsuo kaneda';
    $this->assertEquals('tetsuo-kaneda-tetsuo-kaneda en orbiagro.com.ve: subastas, compra y venta de productos y articulos en Venezuela.', $this->tester->alt);
  }

  /**
   * @dataProvider dataProvider
   */
  public function testIncorrectPathValueShouldBeNull($data)
  {
    $this->tester->path = $data;
    $this->assertNull($this->tester->path);
  }

  public function dataProvider()
  {
    return [
      [''],
      ['a'],
      [-1],
      ['nope.png'],
      ['dolares.bat']
    ];
  }

}
