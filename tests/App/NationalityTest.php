<?php namespace Tests\App;

use App\Nationality;
use Tests\TestCase;

class NationalityTest extends TestCase {

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

    $this->tester = new Nationality;
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
