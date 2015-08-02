<?php namespace Tests\App;

use \Mockery;
use Tests\App\Traits\TearsDownMockery;
use App\Bank;
use Tests\TestCase;

class BankTest extends TestCase {

  use TearsDownMockery;

  /**
   * https://phpunit.de/manual/current/en/fixtures.html
   * @method setUp
   */
  public function setUp()
  {
    parent::setUp();

    $this->tester = new Bank;
    $this->mock = Mockery::mock('App\Bank')->makePartial();
  }

  public function testBillingsRelationship()
  {
    $this->mock
      ->shouldReceive('hasMany')
      ->once()
      ->with('App\Billing')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $this->mock->billings());
  }
}
