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

    public function testGetByDescription()
    {
        $model = Mockery::mock(Profile::class)
            ->makePartial();

        $model->shouldReceive('whereDescription')
            ->once()
            ->andReturnSelf();

        $model->shouldReceive('first')
            ->once()
            ->andReturn('mocked');

        $repo = new ProfileRepository($model);

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
}
