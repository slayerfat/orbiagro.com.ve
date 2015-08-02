<?php namespace Tests\App;

use \Mockery;
use Tests\App\Traits\TearsDownMockery;
use App\File;
use Tests\TestCase;

class FileTest extends TestCase {

  use TearsDownMockery;

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
