<?php namespace Tests\App;

use \Mockery;
use Tests\App\Traits\TearsDownMockery;
use App\Gender;
use Tests\TestCase;

class GenderTest extends TestCase {

  use TearsDownMockery;

  /**
   * https://phpunit.de/manual/current/en/fixtures.html
   * @method setUp
   */
  public function setUp()
  {
    parent::setUp();

    $this->tester = new Gender;
    $this->mock = Mockery::mock('App\Gender')->makePartial();
  }

  public function testPeopleRelationship()
  {
    $this->mock
      ->shouldReceive('hasMany')
      ->once()
      ->with('App\Person')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $this->mock->people());
  }

  public function testCorrectFormattedDescription()
  {
    $this->tester->description = 'tetsuo kaneda';
    $this->assertEquals('Tetsuo kaneda', $this->tester->description);
  }

  /**
   * @dataProvider defaultDataProvider
   */
  public function testIncorrectDescriptionValueShouldBeNull($data)
  {
    $this->tester->description = $data;
    $this->assertNull($this->tester->description);
  }
}
