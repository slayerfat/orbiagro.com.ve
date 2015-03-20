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
    $this->data = ['', 'a', -1];
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
    foreach($this->data as $value):
      $this->tester->name = $value;
      $this->assertNull($this->tester->name);
    endforeach;
    $this->tester->name = 'akira corp.';
    $this->assertEquals('Akira corp.', $this->tester->name);
  }

  public function testSlugFormat()
  {
    foreach($this->data as $value):
      $this->tester->slug = $value;
      $this->assertNull($this->tester->slug);
    endforeach;
    $this->tester->name = 'Tetsuo kaneda tetsuo';
    $this->assertEquals('tetsuo-kaneda-tetsuo', $this->tester->slug);
    $this->tester->slug = 'a b c d';
    $this->assertEquals('a-b-c-d', $this->tester->slug);
  }

  public function testLogoAlt()
  {
    $this->assertEquals('orbiagro.com.ve subastas compra y venta: '.$this->tester->slug,
      $this->tester->images()->first()->alt);
  }

}
