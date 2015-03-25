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
  public function testModelNotNull()
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
    $this->assertEquals('tester', $this->tester->purchases()->first()->name);
  }

  public function testPromotionsCollection()
  {
    $this->assertNotEmpty($this->tester->promotions);
    $this->assertEquals('Lleva 2, paga 3!', $this->tester->promotions->first()->title);
  }

  public function testFilesCollection()
  {
    $this->assertNotEmpty($this->tester->files()->first());
  }

  public function testImagesCollection()
  {
    $this->assertNotEmpty($this->tester->images()->first());
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
    $this->assertEquals('Tester', $this->tester->features->first()->title);
  }

  public function testNutritionalModel()
  {
    $this->assertNotEmpty($this->tester->nutritional);
    $this->assertEquals('1999-09-09', $this->tester->nutritional->due);
  }

  public function testMechanicalInfoModel()
  {
    $this->assertNotEmpty($this->tester->mechanical);
  }

  public function testCorrectSlugFormat()
  {
    $this->tester->slug = '';
    $this->assertNull($this->tester->slug);
    $this->tester->slug = 'tetsuo kaneda tetsuo kaneda';
    $this->assertEquals('tetsuo-kaneda-tetsuo-kaneda', $this->tester->slug);
  }

  public function testCorrectTitleFormat()
  {
    $this->tester->title = '';
    $this->assertNull($this->tester->title);
    $this->assertNull($this->tester->slug);
    $this->tester->title = 'tetsuo kaneda tetsuo kaneda';
    $this->assertEquals('Tetsuo kaneda tetsuo kaneda', $this->tester->title);
    $this->assertEquals('tetsuo-kaneda-tetsuo-kaneda', $this->tester->slug);
  }

  public function testCorrectDescriptionFormat()
  {
    $this->tester->description = '';
    $this->assertNull($this->tester->description);
  }

  public function testCheckDollarMethod()
  {
    $this->assertNotNull($this->tester->check_dollar());
  }

  public function testCheckPriceBsMethod()
  {
    $this->assertNotNull($this->tester->price_bs());
  }

  public function testCheckDollar()
  {
    $this->assertNotNull($this->tester->check_dollar());
  }

  public function testCorrectPriceFormats()
  {
    $this->tester->price = '';
    $this->assertNull($this->tester->price);
    $this->tester->price = 'a123';
    $this->assertNull($this->tester->price);
    $this->tester->price = '1000.00';
    $this->assertEquals(1000, $this->tester->price);
    $price = $this->tester->price / $this->tester->check_dollar();
    $this->assertEquals('Bs. 1.000,00', $this->tester->price_bs());
    $this->assertEquals('1.000,00', $this->tester->price_formatted());
    $this->assertEquals("\${$price}", $this->tester->price_dollar());
  }

  public function testQuantityAttribute()
  {
    $this->tester->quantity = 1;
    $this->assertNotNull($this->tester->quantity);
    $this->tester->quantity = '';
    $this->assertNull($this->tester->quantity);
    $this->tester->quantity = -1;
    $this->assertNull($this->tester->quantity);
  }

}
