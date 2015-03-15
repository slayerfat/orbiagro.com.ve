<?php

use App\Direction;

class DirectionTest extends \Codeception\TestCase\Test
{
  protected $tester, $dirP;

  protected function _before()
  {
    $this->tester = Direction::first();
    $this->dirP   = Direction::find(2);
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
    $this->assertNotEmpty($this->tester->person);
  }

  public function testRelatedProductModel()
  {
    $this->assertNotEmpty($this->dirP->product);
  }

  public function testCorrectFormattedDetails()
  {
    $this->tester->details = '';
    $this->assertfalse($this->tester->details);
    $this->tester->details = 'tetsuo';
    $this->assertEquals('Tetsuo', $this->tester->details);
  }

}
