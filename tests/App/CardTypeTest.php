<?php namespace Tests\Orbiagro;

use \Mockery;
use Tests\Orbiagro\Traits\TearsDownMockery;
use Orbiagro\Models\CardType;
use Tests\TestCase;

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
        $this->mock = Mockery::mock('Orbiagro\Models\CardType')->makePartial();
    }

    public function testBillingsRelationship()
    {
        $this->mock
            ->shouldReceive('hasMany')
            ->once()
            ->with('Orbiagro\Models\Billing')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->billings());
    }
}
