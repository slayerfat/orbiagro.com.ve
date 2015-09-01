<?php namespace Tests\Orbiagro\Models;

use \Mockery;
use Tests\TestCase;
use Orbiagro\Models\Billing;
use Orbiagro\Models\CardType;
use Tests\Orbiagro\Traits\TearsDownMockery;

class CardTypeTest extends TestCase
{

    use TearsDownMockery;

    /**
     * https://phpunit.de/manual/current/en/fixtures.html
     * @method setUp
     */
    public function setUp()
    {
        parent::setUp();

        $this->tester = new CardType;
        $this->mock = Mockery::mock(CardType::class)->makePartial();
    }

    public function testBillingsRelationship()
    {
        $this->mock
            ->shouldReceive('hasMany')
            ->once()
            ->with(Billing::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->billings());
    }
}
