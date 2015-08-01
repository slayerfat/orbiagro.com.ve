<?php namespace Tests\App;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Category;
use Tests\TestCase;

class AppCategoryTest extends TestCase {

  use DatabaseTransactions;

  /**
   * El modelo a manipular.
   * @var Illuminate\Database\Eloquent\Model
   */
  protected $model;

  /**
   * https://phpunit.de/manual/current/en/fixtures.html
   * @method setUp
   */
  public function setUp()
  {
    parent::setUp();

    $this->model = new Category;
  }

  public function testCorrectDescriptionFormat()
  {
    $this->model->description = 'tetsuo kaneda tetsuo kaneda';
    $this->assertEquals('Tetsuo kaneda tetsuo kaneda', $this->model->description);
    $this->assertEquals('tetsuo-kaneda-tetsuo-kaneda', $this->model->slug);
  }

  /**
   * @dataProvider defaultDataProvider
   */
  public function testIncorrectDescriptionValueShouldBeNull($data)
  {
    $this->model->description = $data;

    $this->assertNull($this->model->description);
    $this->assertNull($this->model->slug);
  }

  public function testCorrectSlugFormat()
  {
    $this->model->slug = 'tetsuo kaneda tetsuo kaneda';
    $this->assertEquals('tetsuo-kaneda-tetsuo-kaneda', $this->model->slug);
  }

  /**
   * @dataProvider defaultDataProvider
   */
  public function testIncorrectSlugValueShouldBeNull($data)
  {
    $this->model->slug = $data;

    $this->assertNull($this->model->slug);
  }

  public function testCorrectInfoFormat()
  {
    $this->model->info = 'tetsuo kaneda tetsuo kaneda';
    $this->assertEquals('Tetsuo kaneda tetsuo kaneda.', $this->model->info);
    $this->model->info = 'tetsuo kaneda tetsuo kaneda...';
    $this->assertEquals('Tetsuo kaneda tetsuo kaneda...', $this->model->info);
  }

  /**
   * @dataProvider defaultDataProvider
   */
  public function testIncorrectInfoValueShouldBeNull($data)
  {
    $this->model->info = $data;

    $this->assertNull($this->model->info);
  }

}
