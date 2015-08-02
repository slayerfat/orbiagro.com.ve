<?php namespace Tests\App;

use \Mockery;
use App\Profile;
use Tests\TestCase;

class ProfileTest extends TestCase {

  /**
   * https://phpunit.de/manual/current/en/fixtures.html
   * @method setUp
   */
  public function setUp()
  {
    parent::setUp();

    $this->tester = new Profile;
    $this->mock = Mockery::mock('App\Profile')->makePartial();
  }

  public function tearDown()
  {
    Mockery::close();

    unset($this->tester);
    unset($this->mock);

    parent::tearDown();
  }

  public function testUsersRelationship()
  {
    $this->mock
      ->shouldReceive('hasMany')
      ->once()
      ->with('App\User')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $this->mock->users());
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
