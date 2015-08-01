<?php namespace Tests\App;

use App\Direction;
use Tests\TestCase;

class DirectionTest extends TestCase {

  /**
   * El modelo a manipular.
   * @var Illuminate\Database\Eloquent\Model
   */
  protected $tester;

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
