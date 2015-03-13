<?php

use App\Gender;

class GendersTest extends \Codeception\TestCase\Test
{
  /**
   * @var \UnitTester
   */
  protected $tester;

  protected function _before()
  {
    $this->tester = Gender::where('description', 'Masculino')->first();
  }

  protected function _after()
  {
  }

  public function testGendersInModelNotNull()
  {
    $this->assertNotNull($this->tester);
  }

  public function testRelatedPeopleModel()
  {
    $this->assertNotEmpty($this->tester->people);
  }

}
