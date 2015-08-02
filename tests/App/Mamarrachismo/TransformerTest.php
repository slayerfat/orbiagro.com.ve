<?php namespace Tests\App\Mamarrachismo;

use App\Mamarrachismo\Transformer;
use Tests\TestCase;

class TransformerTest extends TestCase {

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

    $this->tester = new Transformer;
  }

  public function testToNumberShouldReturnNegativeIFProvidedOne()
  {
    $this->markTestIncomplete();
    $t = new Transformer(-1);
    $this->assertEquals(-1, $t->parseReadableToNumber());
  }
}
