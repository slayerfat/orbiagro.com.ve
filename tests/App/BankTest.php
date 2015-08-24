<?php namespace Tests\Orbiagro;

use \Mockery;
use Tests\Orbiagro\Traits\TearsDownMockery;
use Orbiagro\Models\Bank;
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
        $this->mock = Mockery::mock('Orbiagro\Models\Bank')->makePartial();
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
