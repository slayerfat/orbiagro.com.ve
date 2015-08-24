<?php namespace Tests\Orbiagro;

use \Mockery;
use Tests\Orbiagro\Traits\TearsDownMockery;
use Orbiagro\Models\Billing;
use Tests\TestCase;

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
        $this->mock = Mockery::mock('Orbiagro\Models\Billing')->makePartial();
    }

    public function testBankRelationship()
    {
        $this->mock
            ->shouldReceive('belongsTo')
            ->once()
            ->with('Orbiagro\Models\Bank')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->bank());
    }

    public function testCardTypeRelationship()
    {
        $this->mock
            ->shouldReceive('belongsTo')
            ->once()
            ->with('Orbiagro\Models\CardType')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->cardType());
    }

    public function testUserRelationship()
    {
        $this->mock
            ->shouldReceive('belongsTo')
            ->once()
            ->with('Orbiagro\Models\User')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->user());
    }
}
