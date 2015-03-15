<?php

use App\Product;

class ProductTest extends \Codeception\TestCase\Test
{
  /**
   * @var \UnitTester
   */
  protected $tester;

  protected function _before()
  {
    $this->tester = Product::first();
  }

  protected function _after()
  {
  }

  // tests
  public function testCategoryInModelNotNull()
  {
    $this->assertNotNull($this->tester);
  }

  public function testMakerModel()
  {
    $this->assertNotEmpty($this->tester->maker);
  }

  public function testUserModel()
  {
    $this->assertNotEmpty($this->tester->user);
  }

  public function testSubCategoriesCollection()
  {
    $this->assertNotEmpty($this->tester->sub_categories);
    $this->assertNotEmpty($this->tester->sub_categories->first());
  }

  public function testCategoryModel()
  {
    $this->assertNotEmpty($this->tester->sub_categories->first()->category);
  }

  public function testPurchasesCollection()
  {
    $this->assertNotEmpty($this->tester->purchases);
    $this->assertEquals('tester', $this->tester->purchases->first()->user->name);
  }

  public function testPromotionsCollection()
  {
    $this->assertNotEmpty($this->tester->promotions);
    $this->assertEquals('tester', $this->tester->promotions->first()->title);
  }

  public function testFilesCollection()
  {
    $this->assertNotEmpty($this->tester->files);
    $this->assertEquals('tester', $this->tester->files->first()->path);
  }

  public function testImagesCollection()
  {
    $this->assertNotEmpty($this->tester->images);
    $this->assertEquals('tester', $this->tester->images->first()->path);
  }

  public function testCharacteristicModel()
  {
    $this->assertNotEmpty($this->tester->characteristics);
    $this->assertGreaterThan(0, $this->tester->characteristics->height);
    $this->assertGreaterThan(0, $this->tester->characteristics->width);
    $this->assertGreaterThan(0, $this->tester->characteristics->depth);
    $this->assertGreaterThan(0, $this->tester->characteristics->units);
    $this->assertGreaterThan(0, $this->tester->characteristics->weight);
  }

  public function testfeaturesCollection()
  {
    $this->assertNotEmpty($this->tester->features);
    $this->assertEquals('tester', $this->tester->features->first()->title);
  }

  public function testNutritionalModel()
  {
    $this->assertNotEmpty($this->tester->nutritional);
    $this->assertEquals('1999-09-09', $this->tester->nutritional->due_date);
  }

  public function testMechanicalInfoModel()
  {
    $this->assertNotEmpty($this->tester->mechanical_info);
  }

}
