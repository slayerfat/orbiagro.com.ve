<?php namespace Tests\Orbiagro\Repositories;

use Mockery;
use Orbiagro\Models\User;
use Orbiagro\Repositories\UserRepository;
use stdClass;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{

    public function testConstruct()
    {
        $mock = Mockery::mock(User::class);

        $userRepo = new UserRepository($mock);

        $this->assertSame(
            $mock,
            $this->readAttribute($userRepo, 'model')
        );
    }

    public function testGetAllWithTrashed()
    {
        $mock = Mockery::mock(User::class)->makePartial();

        $mock->shouldReceive('with')
            ->once()
            ->with('person')
            ->andReturnSelf();

        $mock->shouldReceive('withTrashed')
             ->once()
             ->andReturnSelf();

        $mock->shouldReceive('get')
             ->once()
             ->andReturn('mocked');

        $userRepo = new UserRepository($mock);

        $this->assertEquals(
            'mocked',
            $userRepo->getAllWithTrashed()
        );
    }

    public function testGetEmptyPersonInstance()
    {
        $userMock = Mockery::mock(User::class);

        $userRepo = new UserRepository($userMock);

        $this->assertNotEmpty($userRepo->getEmptyPersonInstance());
    }

    public function testValidateCreatePersonRequest()
    {
        $userMock = Mockery::mock(User::class)->makePartial();

        $userRepo = Mockery::mock(UserRepository::class, [$userMock])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $userRepo->id = 1;

        $userRepo->shouldReceive('getCurrentUser')
            ->once()
            ->andReturnSelf();

        $userRepo->shouldReceive('canUserManipulate')
            ->once()
            ->andReturn(true);

        $userRepo->shouldReceive('getByNameOrId')
            ->once()
            ->andReturn('mocked');

        $this->assertEquals(
            'mocked',
            $userRepo->validateCreatePersonRequest(1)
        );
    }

    public function testValidateCreatePersonRequestWithNoUser()
    {
        $userMock = Mockery::mock(User::class)->makePartial();

        $userRepo = Mockery::mock(UserRepository::class, [$userMock])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $userRepo->id = 1;

        $userRepo->shouldReceive('getCurrentUser')
            ->once()
            ->andReturnSelf();

        $userRepo->shouldReceive('canUserManipulate')
            ->once();

        $this->assertFalse($userRepo->validateCreatePersonRequest(1));
    }

    public function testValidateCreatePersonRequestWithInvalidUser()
    {
        $userMock = Mockery::mock(User::class)->makePartial();

        $userRepo = Mockery::mock(UserRepository::class, [$userMock])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $userRepo->id = 1;

        $userRepo->shouldReceive('getCurrentUser')
            ->once();

        $this->assertFalse($userRepo->validateCreatePersonRequest(1));
    }
}
