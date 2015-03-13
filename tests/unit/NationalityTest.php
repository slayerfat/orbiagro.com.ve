<?php

use App\Nationality;

class NationalityTest extends \Codeception\TestCase\Test
{
  /**
   * @var \UnitTester
   */
  protected $tester;

  protected function _before()
  {
    $this->tester = Nationality::where('description', 'Venezolano')->first();
  }

  protected function _after()
  {
  }

  public function testNationalityInModelNotNull()
  {
    $this->assertNotNull($this->tester);
  }

  public function testRelatedPeopleModel()
  {
    $this->assertNotEmpty($this->tester->people);
  }

}
