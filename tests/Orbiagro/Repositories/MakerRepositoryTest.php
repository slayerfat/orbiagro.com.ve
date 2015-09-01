<?php namespace Tests\Orbiagro\Repositories;

use Exception;
use Mockery;
use Orbiagro\Models\Maker;
use Orbiagro\Repositories\MakerRepository;
use Tests\TestCase;

class MakerRepositoryTest extends TestCase
{

    public function testConstruct()
    {
        /** @var Maker $mock */
        $mock = Mockery::mock(Maker::class);

        $repo = new MakerRepository($mock);

        $this->assertSame(
            $mock,
            $this->readAttribute($repo, 'model')
        );
    }

    public function testGetAll()
    {
        $mock = Mockery::mock(Maker::class)->makePartial();

        $mock->shouldReceive('with')
            ->once()
            ->with('products')
            ->andReturnSelf();

        $mock->shouldReceive('get')
            ->once()
            ->andReturn('mocked');

        $repo = new MakerRepository($mock);

        $this->assertEquals(
            'mocked',
            $repo->getAll()
        );
    }

    public function testGetEmptyInstance()
    {
        $mock = Mockery::mock(Maker::class);

        $repo = Mockery::mock(MakerRepository::class, [$mock])
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $repo->shouldReceive('getNewInstance')
            ->once()
            ->andReturn('mocked');

        $this->assertEquals(
            'mocked',
            $repo->getEmptyInstance()
        );
    }

    public function testCreate()
    {
        $mock = Mockery::mock(Maker::class)->makePartial();

        $mock->shouldReceive('save')
             ->once()
             ->with([])
             ->andReturn(true);

        $repo = Mockery::mock(MakerRepository::class, [$mock])
                       ->makePartial()
                       ->shouldAllowMockingProtectedMethods();

        $repo->shouldReceive('getNewInstance')
             ->once()
             ->andReturn($mock);

        $this->assertSame(
            $mock,
            $repo->create([])
        );
    }

    /**
     * @expectedException \LogicException
     */
    public function testCreateShouldThrowExceptionIfNoSave()
    {
        $mock = Mockery::mock(Maker::class)->makePartial();

        $mock->shouldReceive('save')
             ->once()
             ->with([])
             ->andReturn(false);

        $repo = Mockery::mock(MakerRepository::class, [$mock])
                       ->makePartial()
                       ->shouldAllowMockingProtectedMethods();

        $repo->shouldReceive('getNewInstance')
             ->once()
             ->andReturn($mock);

        $repo->create([]);
    }

    public function testUpdate()
    {
        $mock = Mockery::mock(Maker::class)->makePartial();

        $mock->shouldReceive('update')
            ->once()
            ->with([]);

        $mock->shouldReceive('load')
             ->once()
             ->with('image');

        $repo = Mockery::mock(MakerRepository::class, [$mock])
                       ->makePartial()
                       ->shouldAllowMockingProtectedMethods();

        $repo->shouldReceive('getBySlugOrId')
             ->once()
             ->andReturn($mock);

        $this->assertSame(
            $mock,
            $repo->update(1, [])
        );
    }

    public function testDelete()
    {
        $mock = Mockery::mock(Maker::class)->makePartial();

        $mock->shouldReceive('delete')
             ->once()
             ->with();

        $repo = Mockery::mock(MakerRepository::class, [$mock])
                       ->makePartial()
                       ->shouldAllowMockingProtectedMethods();

        $repo->shouldReceive('getById')
             ->once()
             ->andReturn($mock);

        $this->assertNull(
            $repo->delete(1)
        );
    }

    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function testDeleteShouldThrowExceptionWhenNoDelete()
    {
        $mock = Mockery::mock(Maker::class)->makePartial();

        $mock->shouldReceive('delete')
             ->once()
             ->with()
            ->andThrow(new Exception);

        $repo = Mockery::mock(MakerRepository::class, [$mock])
                       ->makePartial()
                       ->shouldAllowMockingProtectedMethods();

        $repo->shouldReceive('getById')
             ->once()
             ->andReturn($mock);

        $this->assertNull(
            $repo->delete(1)
        );
    }
}
