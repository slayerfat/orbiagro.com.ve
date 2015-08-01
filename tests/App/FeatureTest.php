<?php namespace Tests\App;

use App\Feature;
use Tests\TestCase;

class FeatureTest extends TestCase {

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

    $this->tester = new Feature;
  }

  public function testCorrectFormattedTitle()
  {
    $this->tester->title = 'tetsuo kaneda';
    $this->assertEquals('Tetsuo kaneda', $this->tester->title);
  }

  /**
   * @dataProvider defaultDataProvider
   */
  public function testIncorrectTitleValueShouldBeNull($data)
  {
    $this->tester->title = $data;
    $this->assertNull($this->tester->title);
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
