<?php namespace Tests\Orbiagro;

use Mockery;
use Orbiagro\Models\Parish;
use Orbiagro\Models\State;
use Orbiagro\Models\Town;
use Tests\Orbiagro\Traits\TearsDownMockery;
use Tests\TestCase;

class TownTest extends TestCase
{

    use TearsDownMockery;

    /**
     * https://phpunit.de/manual/current/en/fixtures.html
     * @method setUp
     */
    public function setUp()
    {
        parent::setUp();

        $this->mock = Mockery::mock(Town::class)->makePartial();
    }

    public function testParishesRelationship()
    {
        $this->mock
            ->shouldReceive('hasMany')
            ->once()
            ->with(Parish::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->parishes());
    }

    public function testStateRelationship()
    {
        $this->mock
            ->shouldReceive('belongsTo')
            ->once()
            ->with(State::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->state());
    }
}
