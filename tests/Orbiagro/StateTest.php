<?php namespace Tests\Orbiagro;

use Mockery;
use Orbiagro\Models\State;
use Orbiagro\Models\Town;
use Tests\Orbiagro\Traits\TearsDownMockery;
use Tests\TestCase;

class StateTest extends TestCase
{

    use TearsDownMockery;

    /**
     * https://phpunit.de/manual/current/en/fixtures.html
     * @method setUp
     */
    public function setUp()
    {
        parent::setUp();

        $this->mock = Mockery::mock(State::class)->makePartial();
    }

    public function testTownsRelationship()
    {
        $this->mock
            ->shouldReceive('hasMany')
            ->once()
            ->with(Town::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->towns());
    }
}
