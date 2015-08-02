<?php namespace Tests;

class TestCase extends \Illuminate\Foundation\Testing\TestCase {

  /**
   * Laravel 5.1
   */
  protected $baseUrl = 'http://localhost';

  /**
   * El modelo a manipular.
   * @var Illuminate\Database\Eloquent\Model
   */
  protected $tester;

  /**
   * la instancia del Mockery a manipular
   */
  protected $mock;

  /**
   * Creates the application.
   *
   * @return \Illuminate\Foundation\Application
   */
  public function createApplication()
  {
    $app = require __DIR__.'/../bootstrap/app.php';

    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

    return $app;
  }

  /**
   * la informacion necesaria para hacer las pruebas,
   * este arreglo posee datos basicos, si es necesario
   * otros datos se deberia crear un metodo mas especializado en el test.
   *
   * @see Tests\AppFileTest::dataProvider()
   *
   * @method defaultDataProvider
   * @return array
   */
  public function defaultDataProvider()
  {
    return [
      [''],
      ['a'],
      [-1]
    ];
  }
}
