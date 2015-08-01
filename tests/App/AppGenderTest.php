<?php namespace Tests\App;

use App\Gender;
use Tests\TestCase;

class AppGenderTest extends TestCase {

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

    $this->tester = new Gender;
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
