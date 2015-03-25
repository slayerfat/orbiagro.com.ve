<?php

use App\Image;

class ImagesTest extends \Codeception\TestCase\Test
{
  /**
   * @var \UnitTester
   */
  protected $tester;

  protected function _before()
  {
    $this->tester  = Image::first();
    $this->data    = ['', 'a', -1, 'dolares.bat', 'another.png'];
  }

  protected function _after()
  {
  }

  // tests
  public function testModelNotNull()
  {
    $this->assertNotNull($this->tester);
  }

  public function testPolymorphicModel()
  {
    $this->assertNotEmpty($this->tester->imageable_type);
    $this->assertNotEmpty($this->tester->imageable_id);
  }

  public function testPath()
  {
    $this->assertNotEmpty($this->tester->path);
    foreach($this->data as $path):
      $this->tester->path = $path;
      $this->assertNull($this->tester->path);
    endforeach;
  }

  public function testAlt()
  {
    $this->assertNotEmpty($this->tester->alt);
    $this->tester->alt = 'tetsuo kaneda tetsuo kaneda';
    $this->assertEquals('orbiagro.com.ve subastas compra y venta: tetsuo-kaneda-tetsuo-kaneda', $this->tester->alt);
  }
}
