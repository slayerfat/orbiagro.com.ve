<?php namespace Tests\Orbiagro\Models;

use \Mockery;
use Tests\Orbiagro\Traits\TearsDownMockery;
use Orbiagro\Models\Profile;
use Tests\TestCase;

class ProfileTest extends TestCase
{

    use TearsDownMockery;

    /**
     * https://phpunit.de/manual/current/en/fixtures.html
     * @method setUp
     */
    public function setUp()
    {
        parent::setUp();

        $this->tester = new Profile;
        $this->mock = Mockery::mock('Orbiagro\Models\Profile')->makePartial();
    }

    public function testUsersRelationship()
    {
        $this->mock
            ->shouldReceive('hasMany')
            ->once()
            ->with('Orbiagro\Models\User')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->users());
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
