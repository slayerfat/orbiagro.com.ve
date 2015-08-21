<?php namespace Tests\App;

use \Mockery;
use Tests\App\Traits\TearsDownMockery;
use App\Nationality;
use Tests\TestCase;

class NationalityTest extends TestCase
{

    use TearsDownMockery;

    /**
    * https://phpunit.de/manual/current/en/fixtures.html
    * @method setUp
    */
    public function setUp()
    {
        parent::setUp();

        $this->tester = new Nationality;
        $this->mock = Mockery::mock('App\Nationality')->makePartial();
    }

    public function testPeopleRelationship()
    {
        $this->mock
            ->shouldReceive('hasMany')
            ->once()
            ->with('App\Person')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->people());
    }

    public function testCorrectFormattedDescription()
    {
        $this->tester->description = 'tetsuo kaneda';
        $this->assertEquals('Tetsuo kaneda', $this->tester->description);
    }

    /**
    * @dataProvider defaultDataProvider
    */
    public function testIncorrectDescriptionValueShouldBeNull($data)
    {
        $this->tester->description = $data;
        $this->assertNull($this->tester->description);
    }
}
