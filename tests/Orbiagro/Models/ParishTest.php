<?php namespace Tests\Orbiagro\Models;

use Mockery;
use Orbiagro\Models\Direction;
use Orbiagro\Models\Parish;
use Orbiagro\Models\Town;
use Tests\Orbiagro\Traits\TearsDownMockery;
use Tests\TestCase;

class ParishTest extends TestCase
{

    use TearsDownMockery;

    /**
     * https://phpunit.de/manual/current/en/fixtures.html
     * @method setUp
     */
    public function setUp()
    {
        parent::setUp();

        $this->mock = Mockery::mock(Parish::class)->makePartial();
    }

    public function testPDirectionsRelationship()
    {
        $this->mock
            ->shouldReceive('hasMany')
            ->once()
            ->with(Direction::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->directions());
    }

    public function testTownRelationship()
    {
        $this->mock
            ->shouldReceive('belongsTo')
            ->once()
            ->with(Town::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->town());
    }
}
