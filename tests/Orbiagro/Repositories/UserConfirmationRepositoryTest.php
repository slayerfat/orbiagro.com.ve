<?php namespace Tests\Orbiagro\Repositories;

use Mockery;
use Orbiagro\Repositories\ProfileRepository;
use Tests\TestCase;
use Orbiagro\Models\User;
use Orbiagro\Models\UserConfirmation;
use Orbiagro\Repositories\UserRepository;
use Orbiagro\Repositories\UserConfirmationRepository;

class UserConfirmationRepositoryTest extends TestCase
{

    protected $profileMock;

    public function setUp()
    {
        $this->profileMock = Mockery::mock(ProfileRepository::class);

        parent::setUp();
    }

    public function testConstruct()
    {
        $model = Mockery::mock(UserConfirmation::class)
                       ->makePartial();

        $userRepoMock = Mockery::mock(UserRepository::class)
            ->makePartial();

        $repo = new UserConfirmationRepository($userRepoMock, $this->profileMock, $model);

        $this->assertSame(
            $model,
            $this->readAttribute($repo, 'model')
        );

        $this->assertSame(
            $userRepoMock,
            $this->readAttribute($repo, 'user')
        );
    }

    public function testCreate()
    {
        $model = factory(User::class)->make();

        $userRepoMock = Mockery::mock(UserRepository::class)
                               ->makePartial();

        $repoMock = Mockery::mock(
            UserConfirmationRepository::class,
            [
                $userRepoMock,
                $this->profileMock,
                $model
            ]
        )->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $userMock = Mockery::mock(User::class)->makePartial();

        $userMock->shouldReceive('confirmation')
            ->once()
            ->andReturnSelf();

        $userMock->shouldReceive('save')
            ->once()
            ->andReturnNull();

        $repoMock->shouldReceive('getCurrentUser')
            ->once()
            ->andReturn($userMock);

        $repoMock->shouldReceive('getNewInstance')
             ->once()
             ->andReturn([1, 2, 3]);

        $this->assertSame(
            $userMock,
            $repoMock->create()
        );
    }

    /**
     * @expectedException \LogicException
     */
    public function testCreateShouldThrowExceptionWhenNoUserIsLogged()
    {
        $mock = factory(User::class)->make();

        $userRepoMock = Mockery::mock(UserRepository::class)
                               ->makePartial();

        $repoMock = Mockery::mock(
            UserConfirmationRepository::class,
            [
                $userRepoMock,
                $this->profileMock,
                $mock
            ]
        )->shouldAllowMockingProtectedMethods()
                           ->makePartial();

        $repoMock->shouldReceive('getCurrentUser')
                 ->once()
                 ->andReturnNull();

        $repoMock->create();
    }

    public function testGetConfirmation()
    {
        $model = Mockery::mock(UserConfirmation::class)
            ->makePartial();

        $model->shouldReceive('whereData')
            ->once()
            ->andReturnSelf();

        $model->shouldReceive('get')
              ->once()
              ->andReturnSelf();

        $model->shouldReceive('count')
            ->once()
            ->andReturn(1);

        $model->shouldReceive('first')
              ->once()
              ->andReturn('mocked');

        $userRepoMock = Mockery::mock(UserRepository::class)
            ->makePartial();

        $repo = new UserConfirmationRepository($userRepoMock, $this->profileMock, $model);

        $this->assertEquals(
            'mocked',
            $repo->getConfirmation('')
        );
    }

    public function testGetConfirmationShouldReturnNullWhenEmpty()
    {
        $model = Mockery::mock(UserConfirmation::class)
                        ->makePartial();

        $model->shouldReceive('whereData')
              ->once()
              ->andReturnSelf();

        $model->shouldReceive('get')
              ->once()
              ->andReturnSelf();

        $model->shouldReceive('count')
              ->atLeast()
              ->once()
              ->andReturn(0);

        $userRepoMock = Mockery::mock(UserRepository::class)
                               ->makePartial();

        $repo = new UserConfirmationRepository($userRepoMock, $this->profileMock, $model);

        $this->assertNull($repo->getConfirmation(''));
    }

    /**
     * @expectedException \Orbiagro\Repositories\Exceptions\DuplicateConfirmationException
     */
    public function testGetConfirmationShouldThrowException()
    {
        $model = Mockery::mock(UserConfirmation::class)
                        ->makePartial();

        $model->shouldReceive('whereData')
              ->once()
              ->andReturnSelf();

        $model->shouldReceive('get')
              ->once()
              ->andReturnSelf();

        $model->shouldReceive('count')
              ->atLeast()
              ->once()
              ->andReturn(2);

        $model->shouldReceive('each')
              ->once()
              ->andReturnSelf();

        $userRepoMock = Mockery::mock(UserRepository::class)
                               ->makePartial();

        $repo = new UserConfirmationRepository($userRepoMock, $this->profileMock, $model);

        $this->assertEquals(
            'mocked',
            $repo->getConfirmation('')
        );
    }

    public function testValidateUser()
    {
        $confirmModelMockery = Mockery::mock(UserConfirmation::class)
            ->makePartial();

        $userRepoMock = Mockery::mock(UserRepository::class)
            ->makePartial();

        $profileRepoMock = Mockery::mock(ProfileRepository::class)
            ->makePartial();

        $profileRepoMock->shouldReceive('getByDescription')
            ->once()
            ->andReturnSelf();

        $profileRepoMock->id = 1;

        $repoMock = Mockery::mock(
            UserConfirmationRepository::class,
            [
                $userRepoMock,
                $profileRepoMock,
                $confirmModelMockery
            ]
        )->shouldAllowMockingProtectedMethods()
                           ->makePartial();

        $userMock = Mockery::mock(User::class)->makePartial();

        $userMock->id = 1;
        $userMock->confirmation = true;

        $confirmModelMockery->user_id = 1;

        $userMock->shouldReceive('save')
                 ->once()
                 ->andReturnNull();

        $repoMock->shouldReceive('getCurrentUser')
                 ->once()
                 ->andReturn($userMock);

        $userMock->shouldReceive('confirmation')
                 ->once()
                 ->andReturnSelf();

        $userMock->shouldReceive('delete')
                 ->once()
                 ->andReturnNull();

        $this->assertSame(
            $userMock,
            $repoMock->validateUser($confirmModelMockery)
        );
    }

    /**
     * @expectedException \LogicException
     */
    public function testValidateUserShouldThrowExceptionWhenUserHasNoConfirmations()
    {
        $confirmModelMockery = Mockery::mock(UserConfirmation::class)
                                      ->makePartial();

        $userRepoMock = Mockery::mock(UserRepository::class)
                               ->makePartial();

        $profileRepoMock = Mockery::mock(ProfileRepository::class)
                                  ->makePartial();

        $profileRepoMock->id = 1;

        $repoMock = Mockery::mock(
            UserConfirmationRepository::class,
            [
                $userRepoMock,
                $profileRepoMock,
                $confirmModelMockery
            ]
        )->shouldAllowMockingProtectedMethods()
                           ->makePartial();

        $userMock = Mockery::mock(User::class)->makePartial();

        $userMock->id = 1;
        $userMock->confirmation = null;

        $confirmModelMockery->user_id = 1;

        $repoMock->shouldReceive('getCurrentUser')
                 ->once()
                 ->andReturn($userMock);

        $this->assertSame(
            $userMock,
            $repoMock->validateUser($confirmModelMockery)
        );
    }
}
