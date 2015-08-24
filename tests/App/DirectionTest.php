<?php namespace Tests\Orbiagro;

use \Mockery;
use Tests\Orbiagro\Traits\TearsDownMockery;
use Orbiagro\Models\Direction;
use Tests\TestCase;

class DirectionTest extends TestCase
{

    use TearsDownMockery;

    /**
     * https://phpunit.de/manual/current/en/fixtures.html
     * @method setUp
     */
    public function setUp()
    {
        parent::setUp();

        $this->tester = new Direction;
        $this->mock = Mockery::mock('Orbiagro\Models\Direction')->makePartial();
    }

    public function testDirectionRelationship()
    {
        $this->mock
            ->shouldReceive('morphTo')
            ->once()
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->directionable());
    }

    public function testMapRelationship()
    {
        $this->mock
            ->shouldReceive('hasOne')
            ->once()
            ->with('Orbiagro\Models\MapDetail')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->map());
    }

    public function testParishRelationship()
    {
        $this->mock
            ->shouldReceive('belongsTo')
            ->once()
            ->with('Orbiagro\Models\Parish')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->parish());
    }

    public function testCorrectFormattedDetails()
    {
        $this->tester->details = 'tetsuo';
        $this->assertEquals('Tetsuo', $this->tester->details);
    }

    /**
     * @dataProvider defaultDataProvider
     */
    public function testIncorrectDetailsValueShouldBeNull($data)
    {
        $this->tester->details = $data;
        $this->assertNull($this->tester->details);
    }
}
