<?php namespace Tests\App;

use \Mockery;
use Tests\App\Traits\TearsDownMockery;
use App\Person;
use Tests\TestCase;

class PersonTest extends TestCase {

  use TearsDownMockery;

  /**
   * https://phpunit.de/manual/current/en/fixtures.html
   * @method setUp
   */
  public function setUp()
  {
    parent::setUp();

    $this->tester = new Person;
    $this->mock = Mockery::mock('App\Person')->makePartial();
  }

  public function testGenderRelationship()
  {
    $this->mock
      ->shouldReceive('belongsTo')
      ->once()
      ->with('App\Gender')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $this->mock->gender());
  }

  public function testNationalityRelationship()
  {
    $this->mock
      ->shouldReceive('belongsTo')
      ->once()
      ->with('App\Nationality')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $this->mock->nationality());
  }

  public function testUserRelationship()
  {
    $this->mock
      ->shouldReceive('belongsTo')
      ->once()
      ->with('App\User')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $this->mock->user());
  }

  public function testDirectionRelationship()
  {
    $this->mock
      ->shouldReceive('morphMany')
      ->once()
      ->with('App\Direction', 'directionable')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $this->mock->direction());
  }

  public function testCorrectFormattedNames()
  {
    $this->tester->first_name = 'tester';
    $this->tester->first_surname = 'tester';
    $this->assertEquals('Tester Tester', $this->tester->formatted_names());
  }

  public function testFormattedNamesShouldNotThrowException()
  {
    $this->assertNull($this->tester->formatted_names());

    $this->tester->first_name = 'tester';
    $this->assertEquals('Tester', $this->tester->formatted_names());

    $this->tester->last_name = 'tester';
    $this->assertEquals('Tester', $this->tester->formatted_names());

    $this->tester->last_surname = 'tester';
    $this->assertEquals('Tester', $this->tester->formatted_names());
  }

  public function testCorrectFormattedFirstNames()
  {
    $this->tester->first_name = 'tester';
    $this->tester->last_name  = 'tester';
    $this->assertEquals('Tester', $this->tester->first_name);
    $this->assertEquals('Tester', $this->tester->last_name);
  }

  /**
   * @dataProvider defaultDataProvider
   */
  public function testIncorrectFirstNamesValueShouldBeNull($data)
  {
    $this->tester->first_name = $data;
    $this->tester->last_name = $data;
    $this->assertNull($this->tester->first_name);
    $this->assertNull($this->tester->last_name);
  }

  public function testCorrectFormattedLastNames()
  {
    $this->tester->first_surname = 'tester';
    $this->tester->last_surname  = 'tester';
    $this->assertEquals('Tester', $this->tester->first_surname);
    $this->assertEquals('Tester', $this->tester->last_surname);
  }

  /**
   * @dataProvider defaultDataProvider
   */
  public function testIncorrectLastNamesValueShouldBeNull($data)
  {
    $this->tester->first_surname = $data;
    $this->tester->last_surname = $data;
    $this->assertNull($this->tester->first_surname);
    $this->assertNull($this->tester->last_surname);
  }

  public function testCorrectFormattedPhone()
  {
    $this->tester->phone = '02123332211';
    $this->assertEquals('(212)-333-2211', $this->tester->phone);
  }

  /**
   * @dataProvider defaultDataProvider
   */
  public function testIncorrectPhoneValueShouldBeNull($data)
  {
    $this->tester->phone = $data;
    $this->assertNull($this->tester->phone);
  }

  public function testCorrectFormattedIdentityCardNumber()
  {
    $this->tester->identity_card = 'tester';
    $this->assertNull($this->tester->identity_card);

    $this->tester->identity_card = '12345678';
    $this->assertEquals('12345678', $this->tester->identity_card);
  }

  /**
   * @dataProvider defaultDataProvider
   */
  public function testIncorrectIdentityCardNumberValueShouldBeNull($data)
  {
    $this->tester->identity_card = $data;
    $this->assertNull($this->tester->identity_card);
  }
}
