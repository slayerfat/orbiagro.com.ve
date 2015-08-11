<?php namespace Tests\App;

use \Mockery;
use Tests\App\Traits\TearsDownMockery;
use App\Product;
use Tests\TestCase;

class ProductTest extends TestCase {

  use TearsDownMockery;

  /**
   * https://phpunit.de/manual/current/en/fixtures.html
   * @method setUp
   */
  public function setUp()
  {
    parent::setUp();

    $this->tester = new Product;
    $this->mock = Mockery::mock('App\Product')->makePartial();
  }

  public function testUserRelationship()
  {
    $this->mock
      ->shouldReceive('belongsTo')
      ->once()
      ->with('App\User')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $this->mock->user());
  }

  public function testMakerRelationship()
  {
    $this->mock
      ->shouldReceive('belongsTo')
      ->once()
      ->with('App\Maker')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $this->mock->maker());
  }

  public function testSubCategoryRelationship()
  {
    $this->mock
      ->shouldReceive('belongsTo')
      ->once()
      ->with('App\SubCategory')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $this->mock->subCategory());
  }

  public function testFeaturesRelationship()
  {
    $this->mock
      ->shouldReceive('hasMany')
      ->once()
      ->with('App\Feature')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $this->mock->features());
  }

  public function testCharacteristicsRelationship()
  {
    $this->mock
      ->shouldReceive('hasOne')
      ->once()
      ->with('App\Characteristic')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $this->mock->characteristics());
  }

  public function testNutritionalRelationship()
  {
    $this->mock
      ->shouldReceive('hasOne')
      ->once()
      ->with('App\Nutritional')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $this->mock->nutritional());
  }

  public function testPurchasesRelationship()
  {
    $this->mock
      ->shouldReceive('belongsToMany')
      ->once()
      ->with('App\User')
      ->andReturn(Mockery::self());

    $this->mock
      ->shouldReceive('withPivot')
      ->once()
      ->with('quantity')
      ->andReturn(Mockery::self());

    $this->mock
      ->shouldReceive('withTimestamps')
      ->once()
      ->andReturn('mocked');

    $this->assertEquals('mocked', $this->mock->purchases());
  }

  public function testProvidersRelationship()
  {
    $this->mock
      ->shouldReceive('belongsToMany')
      ->once()
      ->with('App\Provider')
      ->andReturn(Mockery::self());

    $this->mock
      ->shouldReceive('withPivot')
      ->once()
      ->with('sku')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $this->mock->providers());
  }

  public function testDirectionRelationship()
  {
    $this->mock
      ->shouldReceive('morphOne')
      ->once()
      ->with('App\Direction', 'directionable')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $this->mock->direction());
  }

  public function testFilesRelationship()
  {
    $this->mock
      ->shouldReceive('morphMany')
      ->once()
      ->with('App\File', 'fileable')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $this->mock->files());
  }

  public function testImagesRelationship()
  {
    $this->mock
      ->shouldReceive('morphMany')
      ->once()
      ->with('App\Image', 'imageable')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $this->mock->images());
  }

  public function testVisitsRelationship()
  {
    $this->mock
      ->shouldReceive('morphMany')
      ->once()
      ->with('App\Visit', 'visitable')
      ->andReturn('mocked');

    $this->assertEquals('mocked', $this->mock->visits());
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
    $this->tester->price = $data;
    $this->assertNull($this->tester->price);
  }

  public function testReadableQuantityMethodAttribute()
  {
    $this->markTestIncomplete('No implementado');
    $this->tester->quantity = 1;
    $this->assertEquals('1 Unidad.', $this->tester->readableQuantity());
    $this->tester->quantity = 2;
    $this->assertEquals('2 Unidades.', $this->tester->readableQuantity());
    $this->tester->quantity = 0;
    $this->assertEquals('0 Unidades.', $this->tester->readableQuantity());
    $this->tester->quantity = -1;
    $this->assertEquals('0 Unidades.', $this->tester->readableQuantity());
  }
}
