<?php namespace Tests\App;

use \Mockery;
use Tests\App\Traits\TearsDownMockery;
use App\CardType;
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
        $this->mock = Mockery::mock('App\CardType')->makePartial();
    }

    public function testBillingsRelationship()
    {
        $this->mock
            ->shouldReceive('hasMany')
            ->once()
            ->with('App\Billing')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->billings());
    }
}
