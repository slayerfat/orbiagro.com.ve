<?php namespace Tests\App;

use App\Maker;
use Tests\TestCase;

class AppMakerTest extends TestCase {

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

    $this->tester = new Maker;
  }

  public function testCorrectFormattedName()
  {
    $this->tester->name = 'akira corp.';
    $this->assertEquals('Akira corp.', $this->tester->name);
  }

  /**
   * @dataProvider defaultDataProvider
   */
  public function testIncorrectNameValueShouldBeNull($data)
  {
    $this->tester->name = $data;
    $this->assertNull($this->tester->name);
  }

  public function testCorrectFormattedSlug()
  {
    $this->tester->name = 'Tetsuo kaneda tetsuo';
    $this->assertEquals('tetsuo-kaneda-tetsuo', $this->tester->slug);
    $this->tester->slug = 'a b c d';
    $this->assertEquals('a-b-c-d', $this->tester->slug);
  }

  /**
   * @dataProvider defaultDataProvider
   */
  public function testIncorrectSlugValueShouldBeNull($data)
  {
    $this->tester->slug = $data;
    $this->assertNull($this->tester->slug);
  }

}
