<?php namespace Tests\Orbiagro\Repositories;

use Mockery;
use Orbiagro\Models\Profile;
use Orbiagro\Repositories\ProfileRepository;
use Tests\TestCase;

class ProfileRepositoryTest extends TestCase
{

    public function testConstruct()
    {
        $model = Mockery::mock(Profile::class);

        $repo = new ProfileRepository($model);

        $this->assertSame(
            $model,
            $this->readAttribute($repo, 'model')
        );
    }

    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function testGetByDescriptionShouldThrowExceptionWhenNoIdGiven()
    {
        $model = Mockery::mock(Profile::class)
            ->makePartial();

        $repo = new ProfileRepository($model);

        $this->assertEquals(
            'mocked',
            $repo->getByDescription('')
        );
    }

    public function testGetByDescription()
    {
        $model = Mockery::mock(Profile::class)
                        ->makePartial();

        $repo = Mockery::mock(ProfileRepository::class, [$model])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $repo->shouldReceive('getByIdOrAnother')
            ->once()
            ->andReturn('mocked');

        $this->assertEquals(
            'mocked',
            $repo->getByDescription('')
        );
    }

    public function testGetById()
    {
        $model = Mockery::mock(Profile::class)
                       ->makePartial();

        $model->shouldReceive('findOrFail')
             ->once()
             ->andReturn('mocked');

        $repoMock = new ProfileRepository($model);

        $this->assertEquals(
            'mocked',
            $repoMock->getById(1)
        );
    }

    public function testGetPaginated()
    {
        $model = Mockery::mock(Profile::class)
            ->makePartial();

        $model->shouldReceive('with')
            ->once()
            ->with('users')
            ->andReturnSelf();

        $model->shouldReceive('paginate')
            ->once()
            ->with(1)
            ->andReturn('mocked');

        $repoMock = new ProfileRepository($model);

        $this->assertEquals(
            'mocked',
            $repoMock->getPaginated(1)
        );
    }

    public function testGetLists()
    {
        $model = Mockery::mock(Profile::class)
            ->makePartial();

        $model->shouldReceive('lists')
            ->once()
            ->with('description', 'id')
            ->andReturn('mocked');

        $repoMock = new ProfileRepository($model);

        $this->assertEquals(
            'mocked',
            $repoMock->getLists()
        );
    }

    public function testStore()
    {
        $model = Mockery::mock(Profile::class)
            ->makePartial();

        $model->shouldReceive('newInstance')
            ->once()
            ->andReturnSelf();

        $model->shouldReceive('fill')
            ->once();

        $model->shouldReceive('save')
            ->once();

        $repoMock = new ProfileRepository($model);

        $this->assertSame(
            $model,
            $repoMock->store([])
        );
    }

    public function testUpdate()
    {
        $model = Mockery::mock(Profile::class)
            ->makePartial();

        $model->shouldReceive('fill')
            ->once();

        $model->shouldReceive('update')
            ->once();

        $repoMock = Mockery::mock(ProfileRepository::class, [$model])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $repoMock->shouldReceive('getById')
            ->once()
            ->andReturn($model);

        $this->assertSame(
            $model,
            $repoMock->update(1, [])
        );
    }

    public function testDestroy()
    {
        $model = Mockery::mock(Profile::class)
            ->makePartial();

        $model->users = collect();

        $model->shouldReceive('delete')
            ->once()
            ->andReturn('mocked');

        $repoMock = Mockery::mock(ProfileRepository::class, [$model])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $repoMock->shouldReceive('getById')
            ->once()
            ->andReturn($model);

        $this->assertSame(
            'mocked',
            $repoMock->destroy(4)
        );
    }

    public function testDestroyShouldNotAllowWithUsers()
    {
        $model = Mockery::mock(Profile::class)
            ->makePartial();

        $model->users = collect([1,2,3]);

        $repoMock = Mockery::mock(ProfileRepository::class, [$model])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $repoMock->shouldReceive('getById')
            ->once()
            ->andReturn($model);

        $this->assertFalse($repoMock->destroy(4));
    }

    /**
     * @expectedException \Orbiagro\Repositories\Exceptions\InvalidProfileRequestException
     */
    public function testDestroyShouldThrowExceptionIfPrimaryAreBeingDeleted()
    {
        $model = Mockery::mock(Profile::class)
            ->makePartial();

        $repoMock = Mockery::mock(ProfileRepository::class, [$model])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $this->assertFalse($repoMock->destroy(1));
    }

    public function testGetEmptyInstance()
    {
        $model = Mockery::mock(Profile::class)
            ->makePartial();

        $model->shouldReceive('newInstance')
            ->once()
            ->andReturnSelf();

        $repoMock = new ProfileRepository($model);

        $this->assertSame(
            $model,
            $repoMock->getEmptyInstance()
        );
    }
}
