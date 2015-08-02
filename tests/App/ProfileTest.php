<?php namespace Tests\App;

use App\Profile;
use Tests\TestCase;

class ProfileTest extends TestCase {

  /**
   * https://phpunit.de/manual/current/en/fixtures.html
   * @method setUp
   */
  public function setUp()
  {
    parent::setUp();

    $this->tester = new Profile;
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
