<?php namespace Tests\App;

use App\Characteristic;
use Tests\TestCase;

class CharacteristicTest extends TestCase {

  /**
   * https://phpunit.de/manual/current/en/fixtures.html
   * @method setUp
   */
  public function setUp()
  {
    parent::setUp();

    $this->tester = new Characteristic;
  }

  public function testHeightWidthDepthFormats()
  {
    foreach (['height', 'width', 'depth'] as $attr)
    {
      $this->tester->$attr = '2000';

      $this->assertEquals(2000, $this->tester->$attr);
      $method = $attr.'_cm';
      $this->assertEquals('2.000 cm.', $this->tester->$method());
      $method = $attr.'_mm';
      $this->assertEquals('20.000 mm.', $this->tester->$method());
    }
  }

  /**
  * @dataProvider defaultDataProvider
  */
  public function testIncorrectHeightWidthDepthValuesShouldBeNull($data)
  {
    foreach (['height', 'width', 'depth'] as $attr)
    {
      $this->tester->$attr = $data;
      $this->assertNull($this->tester->$attr);
    }
  }

  public function testUnitsFormat()
  {
    $this->tester->units = '2000';

    $this->assertEquals(2000, $this->tester->units);
    $this->assertEquals('2.000 Unidades.', $this->tester->formatted_units());
  }

  /**
  * @dataProvider defaultDataProvider
  */
  public function testIncorrectUnitsValuesShouldBeNull($data)
  {
    $this->tester->units = $data;

    $this->assertNull($this->tester->units);
  }

  public function testWeightFormat()
  {
    $this->tester->weight = '2000';

    $this->assertEquals(2000, $this->tester->weight);
    $this->assertEquals('2.000 Kg.', $this->tester->weight_kg());
    $this->assertEquals('2 T.', $this->tester->weight_tons());
    $this->assertEquals('2.000.000 g.', $this->tester->weight_g());
  }

  /**
  * @dataProvider defaultDataProvider
  */
  public function testIncorrectWeightValuesShouldBeNull($data)
  {
    $this->tester->weight = $data;

    $this->assertNull($this->tester->weight);
  }

  public function testConvertMethod()
  {
    $int = $this->tester->convert(2000, 'mm');
    $this->assertEquals(200, $int);

    $int = $this->tester->convert(2, 'm');
    $this->assertEquals(200, $int);

    $this->tester->convert(2000, 'mm', 'height');
    $this->assertEquals(200, $this->tester->height);

    $this->tester->convert(2000, 'mm', 'width');
    $this->assertEquals(200, $this->tester->width);

    $this->tester->convert(2000, 'mm', 'depth');
    $this->assertEquals(200, $this->tester->depth);

    $this->tester->convert(2, 't', 'weight');
    $this->assertEquals(2000, $this->tester->weight);

    $this->tester->convert(2000, 'g', 'weight');
    $this->assertEquals(2, $this->tester->weight);
  }

}
