<?php

use App\Promotion;

class PromotionTest extends \Codeception\TestCase\Test
{
  /**
   * @var \UnitTester
   */
  protected $tester;

  protected function _before()
  {
    $this->tester = Promotion::first();
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
    $this->assertNotEmpty($this->tester->products);
  }

  public function testTitle()
  {
    $this->assertEquals('Lleva 2, paga 3!', $this->tester->title);
    $this->tester->title = 'akira';
    $this->assertEquals('Akira', $this->tester->title);
    foreach($this->data as $data):
      $this->tester->title = $data;
      $this->assertNull($this->tester->title);
    endforeach;
  }

  public function testSlug()
  {
    $this->assertEquals('lleva-2-paga-3', $this->tester->slug);
    $this->tester->title = 'tetsuo kaneda tetsuo kaneda';
    $this->assertEquals('tetsuo-kaneda-tetsuo-kaneda', $this->tester->slug);
    $this->tester->slug = 'kaneda tetsuo kaneda tetsuo';
    $this->assertEquals('kaneda-tetsuo-kaneda-tetsuo', $this->tester->slug);
    foreach($this->data as $data):
      $this->tester->slug = $data;
      $this->assertNull($this->tester->slug);
    endforeach;
  }

  public function testPercentage()
  {
    $obj = new Promotion;
    foreach($this->data as $data):
      $obj->percentage = $data;
      $this->assertNull($obj->percentage);
    endforeach;
    $obj->percentage = 10;
    $this->assertEquals('10%', $obj->percentage_pc());
    $this->assertEquals(0.1, $obj->percentage_raw());
    $this->assertEquals(10, $obj->percentage);
    $obj->percentage = 0.1;
    $this->assertEquals('10%', $obj->percentage_pc());
    $this->assertEquals(0.1, $obj->percentage_raw());
    $this->assertEquals(10, $obj->percentage);
  }

  public function testStatic()
  {
    $obj = new Promotion;
    foreach($this->data as $data):
      $obj->static = $data;
      $this->assertNull($obj->static);
    endforeach;
    $obj->static = 10;
    $this->assertEquals('10 Bs.', $obj->static_bs());
    $this->assertEquals(10, $obj->static);
  }

  public function testBegins()
  {
    foreach($this->data as $data):
      $this->tester->begins = $data;
      $this->assertNull($this->tester->begins);
    endforeach;
  }

}
