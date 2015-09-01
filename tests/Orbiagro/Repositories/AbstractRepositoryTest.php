<?php namespace Tests\Orbiagro\Repositories;

use Mockery;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Model;
use Orbiagro\Repositories\FeatureRepository as ConcreteClass;

class AbstractRepositoryTest extends TestCase
{

    public function testConstruct()
    {
        $model = Mockery::mock(Model::class);

        $repo = new ConcreteClass($model);

        $this->assertSame(
            $model,
            $this->readAttribute($repo, 'model')
        );
    }

    public function testGetBySlugOrIdWithSlug()
    {
        $mock = Mockery::mock(Model::class)
            ->makePartial();

        $mock->shouldReceive('where')
            ->once()
            ->andReturnSelf();

        $mock->shouldReceive('orWhere')
            ->once()
            ->andReturnSelf();

        $mock->shouldReceive('firstOrFail')
            ->once()
            ->andReturn('mocked');

        $mockRepo = Mockery::mock(ConcreteClass::class, [$mock])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $mockRepo->shouldReceive('checkId')
            ->once()
            ->andReturnNull();

        $this->assertEquals(
            'mocked',
            $mockRepo->getBySlugOrId(1)
        );
    }

    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function testGetBySlugOrIdShouldThrowHttpException()
    {
        $mock = Mockery::mock(Model::class);

        $mockRepo = Mockery::mock(ConcreteClass::class, [$mock])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $this->assertEquals(
            'mocked',
            $mockRepo->getBySlugOrId('')
        );
    }

    public function testGetById()
    {
        $mock = Mockery::mock(Model::class)
            ->makePartial();

        $mock->shouldReceive('findOrFail')
            ->once()
            ->andReturn('mocked');

        $mockRepo = Mockery::mock(ConcreteClass::class, [$mock])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $mockRepo->shouldReceive('checkId')
            ->once()
            ->andReturnNull();

        $this->assertEquals(
            'mocked',
            $mockRepo->getById(1)
        );
    }

    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function testGetByIdShouldThrowExceptionWhenEmptyStringGiven()
    {
        $mock = Mockery::mock(Model::class);

        $mockRepo = Mockery::mock(ConcreteClass::class, [$mock])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $this->assertEquals(
            'mocked',
            $mockRepo->getById('')
        );
    }
}
