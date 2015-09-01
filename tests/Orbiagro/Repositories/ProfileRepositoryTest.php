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
}
