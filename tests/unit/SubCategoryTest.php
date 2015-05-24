<?php

use App\SubCategory;

class SubCategoryTest extends \Codeception\TestCase\Test
{
  /**
   * @var \UnitTester
   */
  protected $tester;

  protected function _before()
  {
    $this->tester = SubCategory::first();
    $this->data = ['', 'a', -1];
  }

  protected function _after()
  {
  }

  // tests
  public function testSubCategoryInModelNotNull()
  {
    $this->assertNotNull($this->tester);
  }

  public function testRelatedProductCollection()
  {
    $this->assertNotEmpty($this->tester->products);
  }

  public function testRelatedMakerCollection()
  {
    $this->assertNotEmpty($this->tester->makers);
  }

  public function testRelatedCategoryModel()
  {
    $this->assertNotEmpty($this->tester->category);
  }

  public function testRelatedImageModel()
  {
    $this->assertNotEmpty($this->tester->image);
  }

  public function testCorrectDescriptionFormat()
  {
    $obj = new SubCategory;
    foreach($this->data as $value):
      $obj->description = $value;
      $this->assertNull($obj->description);
      $this->assertNull($obj->slug);
    endforeach;
    $this->tester->description = 'tetsuo kaneda tetsuo kaneda';
    $this->assertEquals('Tetsuo kaneda tetsuo kaneda', $this->tester->description);
    $this->assertEquals('tetsuo-kaneda-tetsuo-kaneda', $this->tester->slug);
  }

  public function testCorrectSlugFormat()
  {
    foreach($this->data as $value):
      $this->tester->slug = $value;
      $this->assertNull($this->tester->slug);
    endforeach;
    $this->tester->slug = 'tetsuo kaneda tetsuo kaneda';
    $this->assertEquals('tetsuo-kaneda-tetsuo-kaneda', $this->tester->slug);
  }

  public function testCorrectInfoFormat()
  {
    $obj = new SubCategory;
    foreach($this->data as $value):
      $obj->info = $value;
      $this->assertNull($obj->info);
    endforeach;
    $this->tester->info = 'tetsuo kaneda tetsuo kaneda';
    $this->assertEquals('Tetsuo kaneda tetsuo kaneda.', $this->tester->info);
    $this->tester->info = 'tetsuo kaneda tetsuo kaneda...';
    $this->assertEquals('Tetsuo kaneda tetsuo kaneda...', $this->tester->info);
  }

}
