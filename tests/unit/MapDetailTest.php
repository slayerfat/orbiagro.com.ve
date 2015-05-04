<?php

use App\MapDetail;

class MapDetailTest extends \Codeception\TestCase\Test
{
  /**
   * @var \UnitTester
   */
  protected $tester;

  protected function _before()
  {
    $this->tester = MapDetail::first();
    $this->data = ['', 'a', 200, -200];
  }

  protected function _after()
  {
  }

  // tests
  public function testModelNotNull()
  {
    $this->assertNotNull($this->tester);
  }

  public function testRelatedDirectionCollection()
  {
    $this->assertNotEmpty($this->tester->direction);
  }

  public function testLongitudeFormat()
  {
    foreach($this->data as $value):
      $this->tester->longitude = $value;
      $this->assertNull($this->tester->longitude);
    endforeach;
    $this->tester->longitude = '1';
    $this->assertEquals(1, $this->tester->longitude);
  }

  public function testLatitudeFormat()
  {
    foreach($this->data as $value):
      $this->tester->latitude = $value;
      $this->assertNull($this->tester->latitude);
    endforeach;
    $this->tester->latitude = '1';
    $this->assertEquals(1, $this->tester->latitude);
  }

  public function testZoomFormat()
  {
    foreach($this->data as $value):
      $this->tester->zoom = $value;
      $this->assertNull($this->tester->zoom);
    endforeach;
    $this->tester->zoom = '1';
    $this->assertEquals(1, $this->tester->zoom);
  }

}
