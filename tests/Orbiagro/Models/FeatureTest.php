<?php namespace Tests\Orbiagro\Models;

use \Mockery;
use Tests\TestCase;
use Orbiagro\Models\File;
use Orbiagro\Models\Image;
use Orbiagro\Models\Feature;
use Orbiagro\Models\Product;
use Tests\Orbiagro\Traits\TearsDownMockery;

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
        $this->mock = Mockery::mock(Feature::class)->makePartial();
    }

    public function testProductRelationship()
    {
        $this->mock
            ->shouldReceive('belongsTo')
            ->once()
            ->with(Product::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->product());
    }

    public function testImageRelationship()
    {
        $this->mock
            ->shouldReceive('morphOne')
            ->once()
            ->with(Image::class, 'imageable')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->image());
    }

    public function testFileRelationship()
    {
        $this->mock
            ->shouldReceive('morphOne')
            ->once()
            ->with(File::class, 'fileable')
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
