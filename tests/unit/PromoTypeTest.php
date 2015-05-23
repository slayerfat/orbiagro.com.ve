<?php
use App\PromoType;

class PromoTypeTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
      $this->tester = PromoType::where('description', 'primavera')->first();
    }

    protected function _after()
    {
    }

    // tests
    public function testModelNotNull()
    {
      $this->assertNotNull($this->tester);
    }

    public function testPromotionModel()
    {
      $this->assertNotEmpty($this->tester->promotions);
    }

}
