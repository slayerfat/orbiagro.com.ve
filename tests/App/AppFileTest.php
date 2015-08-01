<?php namespace Tests\App;

use App\File;
use Tests\TestCase;

class AppFileTest extends TestCase {

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

    $this->tester = new File;
  }

  /**
   * @dataProvider dataProvider
   */
  public function testIncorrectPathValueShouldBeNull($data)
  {
    $this->tester->path = $data;
    $this->assertNull($this->tester->path);
  }

  public function dataProvider()
  {
    return [
      [''],
      ['a'],
      [-1],
      ['dolares.bat']
    ];
  }
}
