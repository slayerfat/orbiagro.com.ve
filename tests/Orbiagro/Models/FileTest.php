<?php namespace Tests\Orbiagro\Models;

use \Mockery;
use Tests\Orbiagro\Traits\TearsDownMockery;
use Orbiagro\Models\File;
use Tests\TestCase;

class FileTest extends TestCase
{

    use TearsDownMockery;

    /**
     * https://phpunit.de/manual/current/en/fixtures.html
     * @method setUp
     */
    public function setUp()
    {
        parent::setUp();

        $this->tester = new File;
        $this->mock = Mockery::mock('Orbiagro\Models\File')->makePartial();
    }

    public function testFilableRelationship()
    {
        $this->mock
            ->shouldReceive('morphTo')
            ->once()
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->filable());
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
            ['dolares.bat']
        ];
    }
}
