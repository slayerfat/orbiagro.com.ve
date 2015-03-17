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
    $this->assertNotEmpty($this->tester->product);
  }

  public function testTitle()
  {
    $this->assertEquals('Tester', $this->tester->title);
    $this->tester->title = 'akira';
    $this->assertEquals('Akira', $this->tester->title);
    foreach($this->data as $data):
      $this->tester->title = $data;
      $this->assertNull($this->tester->title);
    endforeach;
  }

  public function testSlug()
  {
    $this->assertEquals('tester', $this->tester->slug);
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
    foreach($this->data as $data):
      $this->tester->percentage = $data;
      $this->assertNull($this->tester->percentage);
    endforeach;
    $this->tester->percentage = 10;
    $this->assertEquals('10%', $this->tester->percentage_pc());
    $this->assertEquals(0.1, $this->tester->percentage_raw());
    $this->assertEquals(10, $this->tester->percentage);
    $this->tester->percentage = 0.1;
    $this->assertEquals('10%', $this->tester->percentage_pc());
    $this->assertEquals(0.1, $this->tester->percentage_raw());
    $this->assertEquals(10, $this->tester->percentage);
  }

  public function testStatic()
  {
    foreach($this->data as $data):
      $this->tester->static = $data;
      $this->assertNull($this->tester->static);
    endforeach;
    $this->tester->static = 10;
    $this->assertEquals('10 Bs.', $this->tester->static_bs());
    $this->assertEquals(10, $this->tester->static);
  }

  public function testBegins()
  {
    foreach($this->data as $data):
      $this->tester->begins = $data;
      $this->assertNull($this->tester->begins);
    endforeach;
  }

}
