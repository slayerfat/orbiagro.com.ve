<?php namespace Tests\App;

use App\SubCategory;
use Tests\TestCase;

class SubCategoryTest extends TestCase {

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

    $this->tester = new SubCategory;
  }

  public function testCorrectFormattedDescription()
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
  }

  public function testCorrectFormattedSlug()
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

  public function testCorrectFormattedInfo()
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
