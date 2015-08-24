<?php namespace Tests\Orbiagro;

use \Mockery;
use Tests\Orbiagro\Traits\TearsDownMockery;
use Orbiagro\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{

    use TearsDownMockery;

    /**
     * https://phpunit.de/manual/current/en/fixtures.html
     * @method setUp
     */
    public function setUp()
    {
        parent::setUp();

        $this->tester = new User;
        $this->mock = Mockery::mock('Orbiagro\Models\User')->makePartial();
    }

    public function testPersonRelationship()
    {
        $this->mock
            ->shouldReceive('hasOne')
            ->once()
            ->with('Orbiagro\Models\Person')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->person());
    }

    public function testConfirmationRelationship()
    {
        $this->mock
            ->shouldReceive('hasOne')
            ->once()
            ->with('Orbiagro\Models\UserConfirmation')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->confirmation());
    }

    public function testProfileRelationship()
    {
        $this->mock
            ->shouldReceive('belongsTo')
            ->once()
            ->with('Orbiagro\Models\Profile')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->profile());
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

    public function testProductsRelationship()
    {
        $this->mock
            ->shouldReceive('hasMany')
            ->once()
            ->with('Orbiagro\Models\Product')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->products());
    }

    public function testVisitsRelationship()
    {
        $this->mock
            ->shouldReceive('hasMany')
            ->once()
            ->with('Orbiagro\Models\Visit')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->visits());
    }

    public function testPurchasesRelationship()
    {
        $this->mock
            ->shouldReceive('belongsToMany')
            ->once()
            ->with('Orbiagro\Models\Product')
            ->andReturn(Mockery::self());

        $this->mock
            ->shouldReceive('withPivot')
            ->once()
            ->with('quantity')
            ->andReturn(Mockery::self());

        $this->mock
            ->shouldReceive('withTimestamps')
            ->once()
            ->andReturn('mocked');

        $this->assertEquals('mocked', $this->mock->purchases());
    }

    public function testIsAdmin()
    {
        $this->tester->profile = factory('Orbiagro\Models\Profile')->make();

        $this->assertFalse($this->tester->isAdmin());

        $this->tester->profile->description = 'Administrador';

        $this->assertTrue($this->tester->isAdmin());
    }

    public function testIsOwnerOrAdmin()
    {
        $this->tester->id = 1;
        $this->tester->profile = factory('Orbiagro\Models\Profile')->make();

        $this->assertFalse($this->tester->isOwnerOrAdmin(2));

        $this->tester->profile->description = 'Administrador';

        $this->assertTrue($this->tester->isOwnerOrAdmin(2));
    }

    public function testIsUser()
    {
        $this->tester->profile = factory('Orbiagro\Models\Profile')->make();

        $this->assertFalse($this->tester->isUser());

        $this->tester->profile->description = 'Usuario';

        $this->assertTrue($this->tester->isUser());
    }

    public function testIsDisabledAndIsVerified()
    {
        $this->tester->profile = factory('Orbiagro\Models\Profile')->make();

        $this->assertTrue($this->tester->isVerified());
        $this->assertFalse($this->tester->isDisabled());

        $this->tester->profile->description = 'Desactivado';

        $this->assertTrue($this->tester->isDisabled());
        $this->assertFalse($this->tester->isVerified());
    }

    public function testHasConfirmation()
    {
        $this->tester->confirmation = false;
        $this->assertFalse($this->tester->hasConfirmation());

        $this->tester->confirmation = true;
        $this->assertTrue($this->tester->hasConfirmation());
    }

    public function testIsowner()
    {
        $this->tester->id = 0;
        $this->assertFalse($this->tester->isOwner(1));

        $this->tester->id = 1;
        $this->assertTrue($this->tester->isOwner(1));
    }

    /**
     * @dataProvider defaultDataProvider
     */
    public function testIncorrectPasswordValueShouldBeNull($data)
    {
        $this->tester->password = $data;
        $this->assertNull($this->tester->password);
    }
}
