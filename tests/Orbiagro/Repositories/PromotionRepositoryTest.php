<?php namespace Tests\Orbiagro\Repositories;

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
}
