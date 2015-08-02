<?php namespace Tests\App;

use \Mockery;
use App\PromoType;
use Tests\TestCase;

class PromoTypeTest extends TestCase {

  /**
   * https://phpunit.de/manual/current/en/fixtures.html
   * @method setUp
   */
  public function setUp()
  {
    parent::setUp();

    $this->tester = new PromoType;
    $this->mock = Mockery::mock('App\PromoType')->makePartial();
  }

  public function tearDown()
  {
    Mockery::close();

    unset($this->tester);
    unset($this->mock);

    parent::tearDown();
  }

  public function testPromotionsRelationship()
  {
    $this->mock
      ->shouldReceive('hasMany')
      ->once()
      ->with('App\Promotion')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $this->mock->promotions());
  }
}
