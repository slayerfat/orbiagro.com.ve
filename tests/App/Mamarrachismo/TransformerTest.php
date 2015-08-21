<?php namespace Tests\App\Mamarrachismo;

use App\Mamarrachismo\Transformer;
use Tests\TestCase;

class TransformerTest extends TestCase
{

    /**
    * https://phpunit.de/manual/current/en/fixtures.html
    * @method setUp
    */
    public function setUp()
    {
        parent::setUp();

        $this->tester = new Transformer;
    }

    public function testTransformTo()
    {
        $this->tester->number = 1;
        $this->assertEquals(10, $this->tester->transformTo('mm'));
        $this->tester->number = 1;
        $this->assertEquals(1000, $this->tester->transformTo('g'));
        $this->tester->number = 100;
        $this->assertEquals(0.1, $this->tester->transformTo('t'));
    }

    public function testMake()
    {
        $this->tester->number = 100;
        $this->assertEquals(10, $this->tester->make('mm'));
        $this->tester->number = 100;
        $this->assertEquals(100, $this->tester->make('cm'));
        $this->tester->number = 1;
        $this->assertEquals(100, $this->tester->make('m'));
        $this->tester->number = 1000;
        $this->assertEquals(1, $this->tester->make('g'));
        $this->tester->number = 1;
        $this->assertEquals(1, $this->tester->make('kg'));
        $this->tester->number = 1;
        $this->assertEquals(1000, $this->tester->make('t'));
    }

    public function testGetArrayByPattern()
    {
        $data = ['foo' => 'bar', 'another' => 1, 'baz' => ['foo']];
        $exp  = ['foo' => 'bar'];

        $this->assertEquals($exp, $this->tester->getArrayByPattern('/(foo)/', $data));
    }

    public function testConversionMethods()
    {
        $this->tester->number = 10;
        $this->assertEquals(1, $this->tester->fromMillimeter());
        $this->assertEquals(10, $this->tester->toMillimeter());
        $this->assertEquals(1000, $this->tester->fromMeter());
        $this->assertEquals(1, $this->tester->fromGram());
        $this->assertEquals(1000, $this->tester->toGram());
        $this->assertEquals(1, $this->tester->toTon());
        $this->assertEquals(1000, $this->tester->fromTon());
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
