<?php

use App\Maker;

class MakerTest extends \Codeception\TestCase\Test
{
  /**
   * @var \UnitTester
   */
  protected $tester;

  protected function _before()
  {
    $this->tester = Maker::first();
  }

  protected function _after()
  {
  }

  // tests
  public function testMakerInModelNotNull()
  {
    $this->assertNotNull($this->tester);
  }

  public function testRelatedProductCollection()
  {
    $this->assertNotEmpty($this->tester->products);
  }

  public function testRelatedSubCategoriesCollection()
  {
    $this->assertNotEmpty($this->tester->sub_categories);
  }

  public function testRelatedCategory()
  {
    $this->assertNotEmpty($this->tester->sub_categories->first()->category);
  }

  public function testNameFormat()
  {
    $this->tester->name = '';
    $this->assertNull($this->tester->name);
    $this->tester->name = 'akira corp.';
    $this->assertEquals('Akira corp.', $this->tester->name);
  }

  public function testSlugFormat()
  {
    $this->tester->slug = '';
    $this->assertNull($this->tester->slug);
    $this->tester->slug = 'a b c d';
    $this->assertEquals('a-b-c-d', $this->tester->slug);
  }

  public function testLogoPath()
  {
    $this->tester->logo_path = '';
    $this->assertNull($this->tester->logo_path);
    $this->tester->logo_path = 'abc';
    $this->assertNull($this->tester->logo_path);
    $this->tester->logo_path = storage_path().'/1500x1500.gif';
    $this->assertEquals(storage_path().'/1500x1500.gif', $this->tester->logo_path);
  }

  public function testLogoAlt()
  {
    $this->assertEquals('orbiagro.com.ve subastas compra y venta: '.$this->tester->slug,
      $this->tester->logo_path);
  }

}
