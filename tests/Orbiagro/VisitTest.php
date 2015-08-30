<?php namespace Tests\Orbiagro;

use Mockery;
use Orbiagro\Models\User;
use Orbiagro\Models\Visit;
use Tests\Orbiagro\Traits\TearsDownMockery;
use Tests\TestCase;

class VisitTest extends TestCase
{

    use TearsDownMockery;

    /**
     * https://phpunit.de/manual/current/en/fixtures.html
     * @method setUp
     */
    public function setUp()
    {
        parent::setUp();

        $this->mock = Mockery::mock(Visit::class)->makePartial();
    }

    public function testUserRelationship()
    {
        $this->mock
            ->shouldReceive('belongsTo')
            ->once()
            ->with(User::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->user());
    }

    public function testVisitableRelation()
    {
        $this->mock
            ->shouldReceive('morphTo')
            ->once()
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->visitable());
    }
}
