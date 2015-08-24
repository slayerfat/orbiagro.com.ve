<?php namespace Tests\Orbiagro;

use \Mockery;
use Tests\Orbiagro\Traits\TearsDownMockery;
use Orbiagro\Models\Bank;
use Orbiagro\Models\Billing;
use Tests\TestCase;

class BankTest extends TestCase
{

    use TearsDownMockery;

    /**
     * https://phpunit.de/manual/current/en/fixtures.html
     * @method setUp
     */
    public function setUp()
    {
        parent::setUp();

        $this->tester = new Bank;
        $this->mock = Mockery::mock(Bank::class)->makePartial();
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
