<?php

use App\Category;

class CategoryTest extends \Codeception\TestCase\Test
{
  /**
   * @var \UnitTester
   */
  protected $tester;

  protected function _before()
  {
    $this->tester = Category::first();
    $this->data = ['', 'a', -1];
  }

  protected function _after()
  {
  }

  // tests
  public function testCategoryInModelNotNull()
  {
    $this->assertNotNull($this->tester);
  }

  public function testRelatedSubCategoryCollection()
  {
    $this->assertNotEmpty($this->tester->sub_categories);
  }

  public function testRelatedMakerCollection()
  {
    $this->assertNotEmpty($this->tester->sub_categories()->first()->makers);
  }

  public function testRelatedProductCollection()
  {
    $this->assertNotEmpty($this->tester->sub_categories()->first()->products);
  }

  public function testRelatedImageModel()
  {
    $this->assertNotEmpty($this->tester->image);
  }

  public function testDescriptionFormat()
  {
    foreach($this->data as $value):
      $this->tester->description = $value;
      $this->assertNull($this->tester->description);
    endforeach;
    $this->tester->description = 'tetsuo';
    $this->assertEquals('Tetsuo', $this->tester->description);
  }

}
