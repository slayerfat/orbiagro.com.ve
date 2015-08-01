<?php namespace Tests\App;

use App\Nutritional;
use Tests\TestCase;

class AppNutritionalTest extends TestCase {

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

    $this->tester = new Nutritional;
  }

  public function testCorrectFormattedDueDate()
  {
    $this->tester->due = '2014-09-05';
    $this->assertEquals('2014-09-05', $this->tester->due);
  }

  /**
   * @dataProvider defaultDataProvider
   */
  public function testIncorrectDueDateValueShouldBeNull($data)
  {
    $this->tester->due = $data;
    $this->assertNull($this->tester->due);
  }

}
