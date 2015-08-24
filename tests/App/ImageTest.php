<?php namespace Tests\App;

use \Mockery;
use Tests\App\Traits\TearsDownMockery;
use App\Image;
use Tests\TestCase;

class ImageTest extends TestCase
{

    use TearsDownMockery;

    /**
     * https://phpunit.de/manual/current/en/fixtures.html
     * @method setUp
     */
    public function setUp()
    {
        parent::setUp();

        $this->tester = new Image;
        $this->mock = Mockery::mock('App\Image')->makePartial();
    }

    public function testImageableRelationship()
    {
        $this->mock
        ->shouldReceive('morphTo')
        ->once()
        ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->imageable());
    }

    public function testCorrectFormattedAlt()
    {
        $this->tester->alt = 'tetsuo kaneda tetsuo kaneda';
        $this->assertEquals('tetsuo-kaneda-tetsuo-kaneda en orbiagro.com.ve: subastas, compra y venta de productos y articulos en Venezuela.', $this->tester->alt);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testIncorrectPathValueShouldBeNull($data)
    {
        $this->tester->path = $data;
        $this->assertNull($this->tester->path);
    }

    public function dataProvider()
    {
        return [
            [''],
            ['a'],
            [-1],
            ['nope.png'],
            ['dolares.bat']
        ];
    }
}
