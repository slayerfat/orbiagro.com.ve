<?php

use App\Profile;

class ProfileTest extends \Codeception\TestCase\Test
{
  /**
   * @var \UnitTester
   */
  protected $tester;

  protected function _before()
  {
    $this->tester = Profile::where('description', 'Administrador')->first();
  }

  protected function _after()
  {
  }

  public function testProfilesInModelNotNull()
  {
    $this->assertNotNull($this->tester);
  }

  public function testRelatedPeopleModel()
  {
    $this->assertNotEmpty($this->tester->users);
  }

  public function testCorrectFormattedDescription()
  {
    $this->tester->description = 'akira';
    $this->assertEquals('Akira', $this->tester->description);
  }

}
