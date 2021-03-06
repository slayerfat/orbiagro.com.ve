<?php namespace Tests\Orbiagro\Models;

use \Mockery;
use Tests\TestCase;
use Orbiagro\Models\Product;
use Orbiagro\Models\Provider;
use Tests\Orbiagro\Traits\TearsDownMockery;

class ProviderTest extends TestCase
{

    use TearsDownMockery;

    /**
     * https://phpunit.de/manual/current/en/fixtures.html
     * @method setUp
     */
    public function setUp()
    {
        parent::setUp();

        $this->tester = new Provider;
        $this->mock = Mockery::mock(Provider::class)->makePartial();
    }

    public function testProductsRelationship()
    {
        $this->mock
            ->shouldReceive('belongsToMany')
            ->once()
            ->with(Product::class)
            ->andReturn(Mockery::self());

        $this->mock
            ->shouldReceive('withPivot')
            ->once()
            ->with('sku')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->products());
    }

    public function testCorrectFormattedName()
    {
        $this->tester->name = 'tetsuo kaneda';
        $this->assertEquals('Tetsuo kaneda', $this->tester->name);
        $this->assertEquals('tetsuo-kaneda', $this->tester->slug);
    }

    /**
     * @dataProvider defaultDataProvider
     */
    public function testIncorrectNameValueShouldBeNull($data)
    {
        $this->tester->name = $data;
        $this->assertNull($this->tester->name);
    }

    public function testCorrectFormattedSlug()
    {
        $this->tester->slug = 'Tetsuo kaneda tetsuo kaneda';
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
}
