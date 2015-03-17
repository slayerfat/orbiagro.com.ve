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

}
