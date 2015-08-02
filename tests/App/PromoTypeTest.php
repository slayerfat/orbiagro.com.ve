<?php namespace Tests\App;

use \Mockery;
use Tests\App\Traits\TearsDownMockery;
use App\PromoType;
use Tests\TestCase;

class PromoTypeTest extends TestCase {

  use TearsDownMockery;

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
