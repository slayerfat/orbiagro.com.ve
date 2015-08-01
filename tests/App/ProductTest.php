<?php namespace Tests\App;

use \Mockery;
use App\Product;
use Tests\TestCase;

class ProductTest extends TestCase {

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

    $this->tester = new Product;
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

  public function testCorrectFormattedTitle()
  {
    $this->tester->title = 'tetsuo kaneda tetsuo kaneda';
    $this->assertEquals('Tetsuo kaneda tetsuo kaneda', $this->tester->title);
    $this->assertEquals('tetsuo-kaneda-tetsuo-kaneda', $this->tester->slug);
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

  public function testCheckDollarMethod()
  {
    $dollar = Mockery::mock('App\Mamarrachismo\CheckDollar');

    $dollar->shouldReceive('isValid')->andReturn(true);

    $dollar->dollar = new \stdClass;

    $dollar->dollar->promedio = 1;

    // pasandole el objeto al metodo
    $this->assertEquals(1, $this->tester->check_dollar($dollar));

    // invocando al metodo sin objeto:
    $this->tester->setDollar($dollar);

    $this->assertEquals(1, $this->tester->check_dollar());
  }

  public function testCheckPriceDollarMethod()
  {
    $dollar = Mockery::mock('App\Mamarrachismo\CheckDollar');

    $dollar->shouldReceive('isValid')->andReturn(true);

    $dollar->dollar = new \stdClass;

    $dollar->dollar->promedio = 1;

    // tratar de hacer esto sin precio deberia dar nulo
    $this->assertNull($this->tester->price_dollar($dollar));

    // deberia funcionar normal
    $this->tester->price = 1;
    $this->assertNotNull($this->tester->price_dollar($dollar));

    // invocando al metodo sin objeto:
    unset($this->tester->dollar);
    $this->tester->setDollar($dollar);

    $this->assertNotNull($this->tester->price_dollar());
  }

  public function testCheckPriceBsMethod()
  {
    $this->assertNull($this->tester->price_bs());
  }

  public function testCorrectFormattedPrice()
  {
    $dollar = Mockery::mock('App\Mamarrachismo\CheckDollar');

    $dollar->shouldReceive('isValid')->andReturn(true);

    $dollar->dollar = new \stdClass;

    $dollar->dollar->promedio = 1;

    $this->tester->price = '1000,12';
    $this->assertEquals(1000.12, $this->tester->price);
    $this->assertEquals('Bs. 1.000,12', $this->tester->price_bs());
    $this->assertEquals('1.000,12', $this->tester->price_formatted());
    $this->assertEquals("$ 1.000,12", $this->tester->price_dollar($dollar));

    $this->tester->price = 1000.12;
    $this->assertEquals(1000.12, $this->tester->price);
    $this->assertEquals('Bs. 1.000,12', $this->tester->price_bs());
    $this->assertEquals('1.000,12', $this->tester->price_formatted());
    $this->assertEquals("$ 1.000,12", $this->tester->price_dollar($dollar));
  }

  public function testQuantityAttribute()
  {
    $this->tester->quantity = -1;
    $this->assertEquals(0, $this->tester->quantity);
    $this->tester->quantity = 'a';
    $this->assertEquals(0, $this->tester->quantity);
    $this->tester->quantity = '';
    $this->assertEquals(0, $this->tester->quantity);
  }

  /**
   * @dataProvider defaultDataProvider
   */
  public function testIncorrectPriceValueShouldBeNull($data)
  {
    $this->markTestIncomplete('Faltan Pruebas de Transformer');

    $this->tester->price = $data;
    $this->assertNull($this->tester->price);
  }
}
