<?php namespace Tests\Orbiagro\Repositories;

use Mockery;
use Orbiagro\Models\Promotion;
use Orbiagro\Models\PromoType;
use Orbiagro\Repositories\PromotionRepository;
use Tests\TestCase;

class PromotionRepositoryTest extends TestCase
{
    public function testConstruct()
    {
        $promoType = factory(PromoType::class)->make();
        $promotion = factory(Promotion::class)->make();

        $repo = new PromotionRepository($promoType, $promotion);

        $this->assertSame(
            $promoType,
            $this->readAttribute($repo, 'promoType')
        );

        $this->assertSame(
            $promotion,
            $this->readAttribute($repo, 'model')
        );
    }

    public function testHomeRelated()
    {
        $promoType = Mockery::mock(PromoType::class)
            ->makePartial();
        $promotion = Mockery::mock(Promotion::class)
            ->makePartial();

        $promoType->shouldReceive('whereIn')
                  ->once()
                  ->andReturnSelf();

        $promoType->shouldReceive('lists')
                  ->once()
                  ->andReturnNull();

        $promotion->shouldReceive('whereIn')
                  ->once()
                  ->andReturnSelf();

        $promotion->shouldReceive('random')
                  ->once()
                  ->andReturnSelf();

        $promotion->shouldReceive('take')
                  ->once()
                  ->with(3)
                  ->andReturnSelf();

        $promotion->shouldReceive('get')
                  ->once()
                  ->andReturn('mocked');

        $repo = new PromotionRepository($promoType, $promotion);

        $this->assertEquals(
            'mocked',
            $repo->getHomeRelated()
        );
    }
}
