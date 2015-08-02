<?php namespace Tests\App;

use \Mockery;
use Tests\App\Traits\TearsDownMockery;
use App\Maker;
use Tests\TestCase;

class MakerTest extends TestCase {

  use TearsDownMockery;

  /**
   * https://phpunit.de/manual/current/en/fixtures.html
   * @method setUp
   */
  public function setUp()
  {
    parent::setUp();

    $this->tester = new Maker;
    $this->mock = Mockery::mock('App\Maker')->makePartial();
  }

  public function testProductsRelationship()
  {
    $this->mock
      ->shouldReceive('hasMany')
      ->once()
      ->with('App\Product')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $this->mock->products());
  }

  public function testImageRelationship()
  {
    $this->mock
      ->shouldReceive('morphOne')
      ->once()
      ->with('App\Image', 'imageable')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $this->mock->image());
  }

  public function testCorrectFormattedName()
  {
    $this->tester->name = 'akira corp.';
    $this->assertEquals('Akira corp.', $this->tester->name);
  }

  /**
   * @dataProvider defaultDataProvider
   */
  public function testIncorrectNameValueShouldBeNull($data)
  {
    $this->tester->name = $data;
    $this->assertNull($this->tester->name);
  }

  public function testCorrectFormattedSlug()
  {
    $this->tester->name = 'Tetsuo kaneda tetsuo';
    $this->assertEquals('tetsuo-kaneda-tetsuo', $this->tester->slug);
    $this->tester->slug = 'a b c d';
    $this->assertEquals('a-b-c-d', $this->tester->slug);
  }

  /**
   * @dataProvider defaultDataProvider
   */
  public function testIncorrectSlugValueShouldBeNull($data)
  {
    $this->tester->slug = $data;
    $this->assertNull($this->tester->slug);
  }

}
