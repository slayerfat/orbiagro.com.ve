<?php namespace Tests;

class TestCase extends \Illuminate\Foundation\Testing\TestCase {

  /**
   * 5.1
   */
  protected $baseUrl = 'http://localhost';

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

  public function defaultDataProvider()
  {
    return [
      [''],
      ['a'],
      [-1]
    ];
  }

}
