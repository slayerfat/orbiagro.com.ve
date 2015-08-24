<?php namespace Tests\Orbiagro;

use \Mockery;
use Tests\Orbiagro\Traits\TearsDownMockery;
use Orbiagro\Models\Feature;
use Tests\TestCase;

class FeatureTest extends TestCase
{

    use TearsDownMockery;

    /**
     * https://phpunit.de/manual/current/en/fixtures.html
     * @method setUp
     */
    public function setUp()
    {
        parent::setUp();

        $this->tester = new Feature;
        $this->mock = Mockery::mock('Orbiagro\Models\Feature')->makePartial();
    }

    public function testProductRelationship()
    {
        $this->mock
            ->shouldReceive('belongsTo')
            ->once()
            ->with('Orbiagro\Models\Product')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->product());
    }

    public function testImageRelationship()
    {
        $this->mock
            ->shouldReceive('morphOne')
            ->once()
            ->with('Orbiagro\Models\Image', 'imageable')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->image());
    }

    public function testFileRelationship()
    {
        $this->mock
            ->shouldReceive('morphOne')
            ->once()
            ->with('Orbiagro\Models\File', 'fileable')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->file());
    }

    public function testCorrectFormattedTitle()
    {
        $this->tester->title = 'tetsuo kaneda';
        $this->assertEquals('Tetsuo kaneda', $this->tester->title);
    }

    /**
     * @dataProvider defaultDataProvider
     */
    public function testIncorrectTitleValueShouldBeNull($data)
    {
        $this->tester->title = $data;
        $this->assertNull($this->tester->title);
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
