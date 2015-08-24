<?php namespace Tests\Orbiagro;

use \Mockery;
use Tests\TestCase;
use Orbiagro\Models\Bank;
use Orbiagro\Models\User;
use Orbiagro\Models\Billing;
use Orbiagro\Models\CardType;
use Tests\Orbiagro\Traits\TearsDownMockery;

class BillingTest extends TestCase
{

    use TearsDownMockery;

    /**
     * https://phpunit.de/manual/current/en/fixtures.html
     * @method setUp
     */
    public function setUp()
    {
        parent::setUp();

        $this->tester = new Billing;
        $this->mock = Mockery::mock(Billing::class)->makePartial();
    }

    public function testBankRelationship()
    {
        $this->mock
            ->shouldReceive('belongsTo')
            ->once()
            ->with(Bank::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->bank());
    }

    public function testCardTypeRelationship()
    {
        $this->mock
            ->shouldReceive('belongsTo')
            ->once()
            ->with(CardType::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->cardType());
    }

    public function testUserRelationship()
    {
        $this->mock
            ->shouldReceive('belongsTo')
            ->once()
            ->with(User::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->user());
    }
}
