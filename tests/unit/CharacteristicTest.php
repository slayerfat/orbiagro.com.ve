<?php

use App\Characteristic;

class CharacteristicTest extends \Codeception\TestCase\Test
{
  /**
   * @var \UnitTester
   */
  protected $tester;

  protected function _before()
  {
    $this->tester = Characteristic::first();
    $this->data = ['', 'a', -1];
  }

  protected function _after()
  {
  }

  // tests
  public function testModelNotNull()
  {
    $this->assertNotNull($this->tester);
  }

  public function testProductModel()
  {
    $this->assertNotEmpty($this->tester->product);
  }

  public function testUserModel()
  {
    $this->assertNotEmpty($this->tester->product->user);
  }

  public function testCharacteristicModel()
  {
    $this->assertGreaterThan(0, $this->tester->height);
    $this->assertGreaterThan(0, $this->tester->width);
    $this->assertGreaterThan(0, $this->tester->depth);
    $this->assertGreaterThan(0, $this->tester->units);
    $this->assertGreaterThan(0, $this->tester->weight);
  }

  public function testHeight()
  {
    $this->tester->height = '2000';
    $this->assertEquals(2000, $this->tester->height);
    $this->assertEquals('2.000 cm.', $this->tester->height_cm());
    $this->assertEquals('20.000 mm.', $this->tester->height_mm());
    foreach($this->data as $value):
      $this->tester->height = $value;
      $this->assertNull($this->tester->height);
    endforeach;
  }

  public function testWidth()
  {
    $this->tester->width = '2000';
    $this->assertEquals(2000, $this->tester->width);
    $this->assertEquals('2.000 cm.', $this->tester->width_cm());
    $this->assertEquals('20.000 mm.', $this->tester->width_mm());
    foreach($this->data as $value):
      $this->tester->width = $value;
      $this->assertNull($this->tester->width);
    endforeach;
  }

  public function testDepth()
  {
    $this->tester->depth = '2000';
    $this->assertEquals(2000, $this->tester->depth);
    $this->assertEquals('2.000 cm.', $this->tester->depth_cm());
    $this->assertEquals('20.000 mm.', $this->tester->depth_mm());
    foreach($this->data as $value):
      $this->tester->depth = $value;
      $this->assertNull($this->tester->depth);
    endforeach;
  }

  public function testUnits()
  {
    $this->tester->units = '2000';
    $this->assertEquals(2000, $this->tester->units);
    $this->assertEquals('2.000 Unidades.', $this->tester->formatted_units());
    foreach($this->data as $value):
      $this->tester->units = $value;
      $this->assertNull($this->tester->units);
    endforeach;
  }

  public function testWeight()
  {
    $this->tester->weight = '2000';
    $this->assertEquals(2000, $this->tester->weight);
    $this->assertEquals('2.000 Kg.', $this->tester->weight_kg());
    $this->assertEquals('2 T.', $this->tester->weight_tons());
    $this->assertEquals('2.000.000 g.', $this->tester->weight_g());
    foreach($this->data as $value):
      $this->tester->weight = $value;
      $this->assertNull($this->tester->weight);
    endforeach;
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
