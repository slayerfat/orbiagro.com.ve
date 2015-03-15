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
    $this->assertNotEmpty($this->tester->sub_categories->first()->makers);
  }

  public function testRelatedProductCollection()
  {
    $this->assertNotEmpty($this->tester->sub_categories->first()->products);
  }

  public function testDescriptionFormat()
  {
    $this->tester->description = '';
    $this->assertNull($this->tester->description);
    $this->tester->description = 'tetsuo';
    $this->assertEquals('Tetsuo', $this->tester->description);
  }

}
