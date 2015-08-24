<?php namespace Tests\Orbiagro;

use \Mockery;
use Tests\Orbiagro\Traits\TearsDownMockery;
use Orbiagro\Models\SubCategory;
use Tests\TestCase;

class SubCategoryTest extends TestCase
{

    use TearsDownMockery;

    /**
     * https://phpunit.de/manual/current/en/fixtures.html
     * @method setUp
     */
    public function setUp()
    {
        parent::setUp();

        $this->tester = new SubCategory;

        $this->mock = Mockery::mock('Orbiagro\Models\SubCategory')->makePartial();
    }

    public function testCategoryRelationship()
    {
        $this->mock
            ->shouldReceive('belongsTo')
            ->once()
            ->with('Orbiagro\Models\Category')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->category());
    }

    public function testProductsRelationship()
    {
        $this->mock
            ->shouldReceive('hasMany')
            ->once()
            ->with('Orbiagro\Models\Product')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->products());
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

    public function testVisitsRelationship()
    {
        $this->mock
            ->shouldReceive('morphMany')
            ->once()
            ->with('Orbiagro\Models\Visit', 'visitable')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->visits());
    }

    public function testCorrectFormattedDescription()
    {
        $this->tester->description = 'tetsuo kaneda tetsuo kaneda';
        $this->assertEquals('Tetsuo kaneda tetsuo kaneda', $this->tester->description);
        $this->assertEquals('tetsuo-kaneda-tetsuo-kaneda', $this->tester->slug);
    }

    /**
     * @dataProvider defaultDataProvider
     */
    public function testIncorrectDescriptionValueShouldBeNull($data)
    {
        $this->tester->description = $data;
        $this->assertNull($this->tester->description);
    }

    public function testCorrectFormattedSlug()
    {
        $this->tester->slug = 'tetsuo kaneda tetsuo kaneda';
        $this->assertEquals('tetsuo-kaneda-tetsuo-kaneda', $this->tester->slug);
    }

    /**
     * @dataProvider defaultDataProvider
     */
    public function testIncorrectSlugValueShouldBeNull($data)
    {
        $this->tester->slug = $data;
        $this->assertNull($this->tester->slug);
    }

    public function testCorrectFormattedInfo()
    {
        $this->tester->info = 'tetsuo kaneda tetsuo kaneda';
        $this->assertEquals('Tetsuo kaneda tetsuo kaneda.', $this->tester->info);
        $this->tester->info = 'tetsuo kaneda tetsuo kaneda...';
        $this->assertEquals('Tetsuo kaneda tetsuo kaneda...', $this->tester->info);
    }

    /**
     * @dataProvider defaultDataProvider
     */
    public function testIncorrectInfoValueShouldBeNull($data)
    {
        $this->tester->info = $data;
        $this->assertNull($this->tester->info);
    }
}
