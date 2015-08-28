<?php namespace Tests\Orbiagro\Repositories;

use Mockery;
use Orbiagro\Models\User;
use Orbiagro\Models\UserConfirmation;
use Orbiagro\Repositories\UserConfirmationRepository;
use Orbiagro\Repositories\UserRepository;
use Tests\Orbiagro\Traits\TearsDownMockery;
use Tests\TestCase;

class UserConfirmationRepositoryTest extends TestCase
{
    use TearsDownMockery;

    public function testConstruct()
    {
        $mock = Mockery::mock(UserConfirmation::class)
                       ->makePartial();

        $userRepoMock = Mockery::mock(UserRepository::class)
            ->makePartial();

        $repo = new UserConfirmationRepository($userRepoMock, $mock);

        $this->assertSame(
            $mock,
            $this->readAttribute($repo, 'model')
        );

        $this->assertSame(
            $userRepoMock,
            $this->readAttribute($repo, 'user')
        );
    }

    public function testCreate()
    {
        $mock = factory(User::class)->make();

        $userRepoMock = Mockery::mock(UserRepository::class)
                               ->makePartial();

        $repoMock = Mockery::mock(
            UserConfirmationRepository::class,
            [
                $userRepoMock,
                $mock
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
}
