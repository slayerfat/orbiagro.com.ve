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
    $this->correct = [
      '1500x1500.gif' => 'image/gif'
    ];
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
      $this->test->path = $path;
      $this->assertNull($this->test->path);
    endforeach;
    $this->test->path = '1500x1500.gif';
    $this->assertNotNull($this->test->path);
  }

  public function testMime()
  {
    $this->assertNotEmpty($this->tester->mime);
    foreach($this->data as $mime):
      $this->test->mime = $mime;
      $this->assertNull($this->test->mime);
    endforeach;
    foreach($this->correct as $path => $mime):
      $this->test->path = $path;
      $this->assertEquals($mime, $this->test->mime);
    endforeach;
  }

  public function testAlt()
  {
    $this->assertNotEmpty($this->tester->alt);
    $this->tester->alt = 'tetsuo kaneda tetsuo kaneda';
    $this->assertEquals('tetsuo-kaneda-tetsuo-kaneda');
  }
}
