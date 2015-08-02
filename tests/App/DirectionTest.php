<?php namespace Tests\App;

use \Mockery;
use Tests\App\Traits\TearsDownMockery;
use App\Direction;
use Tests\TestCase;

class DirectionTest extends TestCase {

  use TearsDownMockery;

  /**
   * https://phpunit.de/manual/current/en/fixtures.html
   * @method setUp
   */
  public function setUp()
  {
    parent::setUp();

    $this->tester = new Direction;
  }

  public function testCorrectFormattedDetails()
  {
    $this->tester->details = 'tetsuo';
    $this->assertEquals('Tetsuo', $this->tester->details);
  }

  /**
   * @dataProvider defaultDataProvider
   */
  public function testIncorrectDetailsValueShouldBeNull($data)
  {
    $this->tester->details = $data;
    $this->assertNull($this->tester->details);
  }

}
