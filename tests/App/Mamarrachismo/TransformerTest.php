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

  public function testParseReadableToNumber()
  {
    $this->tester->number = '123.456,789';
    $this->assertEquals(123456.789, $this->tester->parseReadableToNumber());
    $this->tester->number = '-123,4';
    $this->assertEquals(-123.4, $this->tester->parseReadableToNumber());
  }

  public function testToNumberShouldReturnNegativeIFProvidedOne()
  {
    $this->tester->number = -1;
    $this->assertEquals(-1, $this->tester->parseReadableToNumber());
    $this->tester->number = '-123,4';
    $this->assertEquals(-123.4, $this->tester->parseReadableToNumber());
  }

  public function testNumberToReadable()
  {
    $this->tester->number = 123456.123;
    $this->assertEquals('123.456,123', $this->tester->parseNumberToReadable());
    $this->tester->number = -123.4;
    $this->assertEquals('-123,4', $this->tester->parseNumberToReadable());
  }
}
