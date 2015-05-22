<?php

use App\Feature;

class FeatureTest extends \Codeception\TestCase\Test
{
  /**
   * @var \UnitTester
   */
  protected $tester;

  protected function _before()
  {
    $this->tester = Feature::first();
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

  public function testImageModel()
  {
    $this->assertNotEmpty($this->tester->image);
  }

  public function testFileModel()
  {
    $this->assertNotEmpty($this->tester->file);
  }

  public function testCorrectTitleFormat()
  {
    $this->assertEquals('Tester', $this->tester->title);
    $obj = new Feature;
    foreach($this->data as $value):
      $obj->title = $value;
      $this->assertNull($obj->title);
    endforeach;
  }

  public function testCorrectDescriptionFormat()
  {
    $this->assertEquals('tester', $this->tester->description);
    $obj = new Feature;
    foreach($this->data as $value):
      $obj->description = $value;
      $this->assertNull($obj->description);
    endforeach;
  }

}
