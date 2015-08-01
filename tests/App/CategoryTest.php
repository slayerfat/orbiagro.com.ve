<?php namespace Tests\App;

use App\Category;
use Tests\TestCase;

class CategoryTest extends TestCase {

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

    $this->tester = new Category;
  }

  public function testCorrectDescriptionFormat()
  {
    $this->tester->description = 'tetsuo kaneda tetsuo kaneda';
    $this->assertEquals('Tetsuo kaneda tetsuo kaneda', $this->tester->description);
    $this->assertEquals('tetsuo-kaneda-tetsuo-kaneda', $this->tester->slug);
  }

  /**
   * @dataProvider defaultDataProvider
   */
  public function testIncorrectDescriptionValueShouldBeNull($data)
  {
    $this->tester->description = $data;

    $this->assertNull($this->tester->description);
    $this->assertNull($this->tester->slug);
  }

  public function testCorrectSlugFormat()
  {
    $this->tester->slug = 'tetsuo kaneda tetsuo kaneda';
    $this->assertEquals('tetsuo-kaneda-tetsuo-kaneda', $this->tester->slug);
  }

  /**
   * @dataProvider defaultDataProvider
   */
  public function testIncorrectSlugValueShouldBeNull($data)
  {
    $this->tester->slug = $data;

    $this->assertNull($this->tester->slug);
  }

  public function testCorrectInfoFormat()
  {
    $this->tester->info = 'tetsuo kaneda tetsuo kaneda';
    $this->assertEquals('Tetsuo kaneda tetsuo kaneda.', $this->tester->info);
    $this->tester->info = 'tetsuo kaneda tetsuo kaneda...';
    $this->assertEquals('Tetsuo kaneda tetsuo kaneda...', $this->tester->info);
  }

  /**
   * @dataProvider defaultDataProvider
   */
  public function testIncorrectInfoValueShouldBeNull($data)
  {
    $this->tester->info = $data;

    $this->assertNull($this->tester->info);
  }

}
