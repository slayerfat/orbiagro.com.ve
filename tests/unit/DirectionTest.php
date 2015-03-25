<?php

use App\Direction;

class DirectionTest extends \Codeception\TestCase\Test
{
  protected $tester, $dirP;

  protected function _before()
  {
    $this->tester = Direction::first();
    $this->dirP   = Direction::find(2);
    $this->data = ['', 'a', -1];
  }

  protected function _after()
  {
  }

  // tests
  public function testNotNullModels()
  {
    $this->assertNotNull($this->tester);
  }

  public function testRelatedUserModel()
  {
    $this->assertNotEmpty($this->tester->directionable);
  }

  public function testRelatedProductModel()
  {
    $this->assertNotEmpty($this->dirP->directionable);
  }

  public function testCorrectFormattedDetails()
  {
    foreach($this->data as $value):
      $this->tester->details = $value;
      $this->assertNull($this->tester->details);
    endforeach;
    $this->tester->details = 'tetsuo';
    $this->assertEquals('Tetsuo', $this->tester->details);
  }

}
