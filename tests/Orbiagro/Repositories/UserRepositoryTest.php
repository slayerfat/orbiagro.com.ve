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

    public function testStorePerson()
    {
        $userMock = Mockery::mock(User::class)->makePartial();

        // por alguna razon mockery no quiere duplicar save correctamente
        // asi que se hizo un mock del metodo por medio de esta clase
        $saveMock = Mockery::mock(StdClass::class)->makePartial();
        $saveMock->shouldReceive('save')
            ->once()
            ->withAnyArgs();

        $userMock->shouldReceive('person')
            ->once()
            ->andReturn($saveMock);

        $userRepo = Mockery::mock(UserRepository::class, [$userMock])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $userRepo->shouldReceive('getById')
            ->once()
            ->andReturn($userMock);

        $userRepo->shouldReceive('getEmptyPersonInstance')
            ->once()
            ->andReturnSelf();

        $userRepo->shouldReceive('fill')
            ->once();

        $this->assertSame(
            $userMock,
            $userRepo->storePerson(
                1,
                [
                    'gender_id' => 'infinity',
                    'nationality_id' => '2 * infinity',
                ]
            )
        );
    }

    public function testUpdatePerson()
    {
        $userMock = Mockery::mock(User::class)->makePartial();

        // mismo problema, esta vez con Eloquent.
        $personMock = Mockery::mock(StdClass::class);

        $personMock->gender_id = 1;
        $personMock->nationality_id = 1;


        $personMock->shouldReceive('fill')
            ->once()
            ->withAnyArgs()
            ->andReturnNull();

        $personMock->shouldReceive('update')
            ->once()
            ->withAnyArgs()
            ->andReturnNull();

        $userMock->person = $personMock;

        $userRepo = Mockery::mock(UserRepository::class, [$userMock])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $userRepo->shouldReceive('getById')
            ->once()
            ->andReturn($userMock);

        $this->assertSame(
            $userMock,
            $userRepo->updatePerson(
                1,
                [
                    'gender_id' => 'infinity',
                    'nationality_id' => '2 * infinity',
                ]
            )
        );
    }

    public function testRestore()
    {
        $userMock = Mockery::mock(User::class)->makePartial();

        $userMock->shouldReceive('restore')
            ->once();

        $userRepo = Mockery::mock(UserRepository::class, [$userMock])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $userRepo->shouldReceive('checkId')
            ->once();

        $userRepo->shouldReceive('findTrashedUser')
            ->once()
            ->andReturn($userMock);

        $this->assertSame(
            $userMock,
            $userRepo->restore(1)
        );
    }
}
