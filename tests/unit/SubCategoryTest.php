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

  public function testDescriptionFormat()
  {
    $this->tester->description = '';
    $this->assertNull($this->tester->description);
    $this->tester->description = 'tetsuo';
    $this->assertEquals('Tetsuo', $this->tester->description);
  }

}
