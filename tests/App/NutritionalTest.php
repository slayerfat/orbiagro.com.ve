<?php namespace Tests\App;

use \Mockery;
use Tests\App\Traits\TearsDownMockery;
use App\Nutritional;
use Tests\TestCase;

class NutritionalTest extends TestCase
{

    use TearsDownMockery;

    /**
     * https://phpunit.de/manual/current/en/fixtures.html
     * @method setUp
     */
    public function setUp()
    {
        parent::setUp();

        $this->tester = new Nutritional;
        $this->mock = Mockery::mock('App\Nutritional')->makePartial();
    }

    public function testProductRelationship()
    {
        $this->mock
            ->shouldReceive('belongsTo')
            ->once()
            ->with('App\Product')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->product());
    }

    public function testCorrectFormattedDueDate()
    {
        $this->tester->due = '2014-09-05';
        $this->assertEquals('2014-09-05', $this->tester->due);
    }

    /**
     * @dataProvider defaultDataProvider
     */
    public function testIncorrectDueDateValueShouldBeNull($data)
    {
        $this->tester->due = $data;
        $this->assertNull($this->tester->due);
    }
}
