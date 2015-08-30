<?php namespace Tests\Orbiagro\Models;

use \Mockery;
use Tests\Orbiagro\Traits\TearsDownMockery;
use Orbiagro\Models\PromoType;
use Tests\TestCase;

class PromoTypeTest extends TestCase
{

    use TearsDownMockery;

    /**
     * https://phpunit.de/manual/current/en/fixtures.html
     * @method setUp
     */
    public function setUp()
    {
        parent::setUp();

        $this->tester = new PromoType;
        $this->mock = Mockery::mock('Orbiagro\Models\PromoType')->makePartial();
    }

    public function testPromotionsRelationship()
    {
        $this->mock
            ->shouldReceive('hasMany')
            ->once()
            ->with('Orbiagro\Models\Promotion')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->promotions());
    }
}
