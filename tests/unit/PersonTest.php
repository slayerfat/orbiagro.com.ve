<?php

use App\Person;

class PersonTest extends \Codeception\TestCase\Test
{
  /**
   * @var \UnitTester
   */
  protected $tester;

  protected function _before()
  {
    $this->tester = Person::where('first_name', 'tester')->first();
  }

  protected function _after()
  {
  }

  // tests

  public function testPersonInModelNotNull()
  {
    $this->assertNotNull($this->tester);
  }

  public function testSeeMatchingNamesInPersonModel()
  {
    $this->assertEquals('Tester', $this->tester->first_name);
    $this->assertNotEquals('Neo', $this->tester->first_name);
  }

  public function testRelatedUserModel()
  {
    $this->assertNotEmpty($this->tester->user);
    $this->assertEquals('tester', $this->tester->user->name);
  }

  public function testRelatedDirectionModel()
  {
    $this->assertNotEmpty($this->tester->direction);
    $this->assertEquals(1, $this->tester->direction->first()->parish_id);
  }

  public function testRelatedGenderModel()
  {
    $this->assertNotEmpty($this->tester->gender);
    $this->assertEquals('Masculino', $this->tester->gender->description);
  }

  public function testRelatedNationalityModel()
  {
    $this->assertNotEmpty($this->tester->nationality);
    $this->assertEquals('Venezolano', $this->tester->nationality->description);
  }

  public function testCorrectFormattedNames()
  {
    $this->assertEquals('Tester Tester', $this->tester->formatted_names());
  }

  public function testCorrectFormattedFirstNames()
  {
    $this->tester->last_name = 'tester';
    $this->assertEquals('Tester', $this->tester->first_name);
    $this->assertEquals('Tester', $this->tester->last_name);
  }

  public function testCorrectFormattedLastNames()
  {
    $this->tester->last_surname = 'tester';
    $this->assertEquals('Tester', $this->tester->first_surname);
    $this->assertEquals('Tester', $this->tester->last_surname);
  }

  public function testReturnNullWhenNamesAreEmpty()
  {
    $person = new Person;
    $person->first_name    = '';
    $person->last_name     = '';
    $person->first_surname = '';
    $person->last_surname  = '';
    $this->assertNull($person->first_name);
    $this->assertNull($person->last_name);
    $this->assertNull($person->first_surname);
    $this->assertNull($person->last_surname);
  }

  public function testCorrectFormattedPhones()
  {
    $this->tester->phone = '02123332211';
    $this->assertEquals('(212)-333-2211', $this->tester->phone);
  }

  public function testCorrectFormattedIdentityCard()
  {
    $this->assertEquals('10000001', $this->tester->identity_card);

    $this->tester->identity_card = 'tester';
    $this->assertNull($this->tester->identity_card);

    $this->tester->identity_card = '11122211';
    $this->assertEquals('11122211', $this->tester->identity_card);
  }

}
