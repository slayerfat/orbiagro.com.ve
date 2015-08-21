<?php namespace Tests\App;

use \Mockery;
use Tests\App\Traits\TearsDownMockery;
use App\Promotion;
use Tests\TestCase;

class PromotionTest extends TestCase
{

    use TearsDownMockery;

    /**
    * https://phpunit.de/manual/current/en/fixtures.html
    * @method setUp
    */
    public function setUp()
    {
        parent::setUp();

        $this->tester = new Promotion;
        $this->mock = Mockery::mock('App\Promotion')->makePartial();
    }

    public function testProductsRelationship()
    {
        $this->mock
            ->shouldReceive('belongsToMany')
            ->once()
            ->with('App\Product')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->products());
    }

    public function testTypeRelationship()
    {
        $this->mock
            ->shouldReceive('belongsTo')
            ->once()
            ->with('App\PromoType', 'promo_type_id', 'id')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->type());
    }

    public function testImagesRelationship()
    {
        $this->mock
            ->shouldReceive('morphMany')
            ->once()
            ->with('App\Image', 'imageable')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->images());
    }

    public function testCorrectFormattedTitle()
    {
        $this->tester->title = 'tetsuo kaneda';
        $this->assertEquals('Tetsuo kaneda', $this->tester->title);
        $this->assertEquals('tetsuo-kaneda', $this->tester->slug);
    }

    /**
    * @dataProvider defaultDataProvider
    */
    public function testIncorrectTitleValueShouldBeNull($data)
    {
        $this->tester->title = $data;
        $this->assertNull($this->tester->title);
    }

    public function testCorrectFormattedSlug()
    {
        $this->tester->slug = 'kaneda tetsuo kaneda tetsuo';
        $this->assertEquals('kaneda-tetsuo-kaneda-tetsuo', $this->tester->slug);
    }

    /**
    * @dataProvider defaultDataProvider
    */
    public function testIncorrectSlugValueShouldBeNull($data)
    {
        $this->tester->slug = $data;
        $this->assertNull($this->tester->slug);
    }

    public function testCorrectFormattedPercentage()
    {
        $this->tester->percentage = 10;
        $this->assertEquals('10%', $this->tester->readablePercentage());
        $this->assertEquals(0.1, $this->tester->decimalPercentage());
        $this->assertEquals(10, $this->tester->percentage);
        $this->tester->percentage = 0.1;
        $this->assertEquals('10%', $this->tester->readablePercentage());
        $this->assertEquals(0.1, $this->tester->decimalPercentage());
        $this->assertEquals(10, $this->tester->percentage);
    }

    /**
    * @dataProvider defaultDataProvider
    */
    public function testIncorrectPercentageValueShouldBeNull($data)
    {
        $this->tester->percentage = $data;
        $this->assertNull($this->tester->percentage);
    }

    public function testCorrectFormattedStatic()
    {
        $this->assertNull($this->tester->readableStatic('a'));

        $this->assertEquals('101,21', $this->tester->readableStatic(101.21));

        $this->tester->static = 1000.12;
        $this->assertEquals('Bs. 1.000,12', $this->tester->readableStatic());
    }

    /**
    * @dataProvider defaultDataProvider
    */
    public function testIncorrectStaticValueShouldBeNull($data)
    {
        $this->tester->static = $data;
        $this->assertNull($this->tester->static);
    }

    /**
    * @dataProvider defaultDataProvider
    */
    public function testIncorrectBeginsValueShouldBeNull($data)
    {
        $this->tester->begins = $data;
        $this->assertNull($this->tester->begins);
    }
}
