<?php namespace Tests\App;

use \Mockery;
use Tests\App\Traits\TearsDownMockery;
use Orbiagro\Models\Category;
use Tests\TestCase;

class CategoryTest extends TestCase
{

    use TearsDownMockery;

    /**
     * https://phpunit.de/manual/current/en/fixtures.html
     * @method setUp
     */
    public function setUp()
    {
        parent::setUp();

        $this->tester = new Category;
        $this->mock = Mockery::mock('App\Category')->makePartial();
    }

    public function testSubCategoriesRelationship()
    {
        $this->mock
            ->shouldReceive('hasMany')
            ->once()
            ->with('App\SubCategory')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->subCategories());
    }

    public function testImageRelationship()
    {
        $this->mock
            ->shouldReceive('morphOne')
            ->once()
            ->with('App\Image', 'imageable')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->image());
    }

    public function testProductsRelationship()
    {
        $this->mock
            ->shouldReceive('hasManyThrough')
            ->once()
            ->with('App\product', 'App\SubCategory')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->products());
    }

    public function testCorrectDescriptionFormat()
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
        $this->assertNull($this->tester->slug);
    }

    public function testCorrectSlugFormat()
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

    public function testCorrectInfoFormat()
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
