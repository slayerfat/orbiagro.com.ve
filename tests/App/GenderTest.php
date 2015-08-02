<?php namespace Tests\App;

use \Mockery;
use App\Gender;
use Tests\TestCase;

class GenderTest extends TestCase {

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

  public function tearDown()
  {
    Mockery::close();

    unset($this->tester);
    unset($this->mock);

    parent::tearDown();
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
