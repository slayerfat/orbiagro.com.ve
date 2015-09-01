<?php namespace Tests\Orbiagro\Repositories;

use Mockery;
use Orbiagro\Models\Feature;
use Orbiagro\Models\Product;
use Orbiagro\Repositories\FeatureRepository;
use Tests\TestCase;

class FeatureRepositoryTest extends TestCase
{
    public function testConstruct()
    {
        /** @var Feature $mock */
        $mock = Mockery::mock(Feature::class);

        $repo = new FeatureRepository($mock);

        $this->assertSame(
            $mock,
            $this->readAttribute($repo, 'model')
        );
    }

    public function testValidateCreateRequest()
    {
        $mock = Mockery::mock(Feature::class)
            ->makePartial();

        $mock->shouldReceive('whereProductId')
            ->once()
            ->andReturnSelf();

        $mock->shouldReceive('count')
            ->once()
            ->andReturn(1);

        $repo = Mockery::mock(FeatureRepository::class, [$mock])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $repo->shouldReceive('canUserManipulate')
            ->once()
            ->andReturn('mocked');

        $this->assertEquals(
            'mocked',
            $repo->validateCreateRequest(1)
        );
    }

    public function testValidateCreateRequestWillReturnFalseWhenIsFiveOrMore()
    {
        $mock = Mockery::mock(Feature::class)
            ->makePartial();

        $mock->shouldReceive('whereProductId')
            ->once()
            ->andReturnSelf();

        $mock->shouldReceive('count')
            ->once()
            ->andReturn(5);

        $repo = Mockery::mock(FeatureRepository::class, [$mock])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $this->assertFalse($repo->validateCreateRequest(1));
    }

    public function testCreate()
    {
        $mock = Mockery::mock(Feature::class);

        $productMock = Mockery::mock(Product::class)
            ->makePartial();

        $productMock->shouldReceive('features')
            ->once()
            ->andReturnSelf();

        $productMock->shouldReceive('save')
            ->once()
            ->andReturnNull();

        $repo = Mockery::mock(FeatureRepository::class, [$mock])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $repo->shouldReceive('getNewInstance')
            ->once()
            ->andReturn([]);

        $this->assertEquals(
            [],
            $repo->create([], $productMock)
        );
    }

    public function testUpdate()
    {
        $mock = Mockery::mock(Feature::class)
            ->makePartial();

        $repo = Mockery::mock(FeatureRepository::class, [$mock])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $repo->shouldReceive('getById')
            ->once()
            ->andReturn($mock);

        $mock->shouldReceive('update')
            ->once()
            ->andReturnNull();

        $mock->shouldReceive('load')
            ->once()
            ->andReturnNull();

        $this->assertSame(
            $mock,
            $repo->update(1, [])
        );
    }

    public function testDelete()
    {
        $mock = Mockery::mock(Feature::class)
            ->makePartial();

        $mock->product = factory(Product::class)->make();

        $repo = Mockery::mock(FeatureRepository::class, [$mock])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $repo->shouldReceive('getById')
            ->once()
            ->andReturn($mock);

        $repo->shouldReceive('canUserManipulate')
            ->once()
            ->andReturn(true);

        $mock->shouldReceive('delete')
            ->once()
            ->andReturnNull();

        $mock->shouldReceive('load')
            ->once()
            ->andReturnNull();

        $this->assertSame(
            $mock,
            $repo->delete(1)
        );
    }

    public function testDeleteShouldReturnFalseWhenUserCantManipulate()
    {
        $mock = Mockery::mock(Feature::class)
            ->makePartial();

        $mock->product = factory(Product::class)->make();

        $repo = Mockery::mock(FeatureRepository::class, [$mock])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $repo->shouldReceive('getById')
            ->once()
            ->andReturn($mock);

        $repo->shouldReceive('canUserManipulate')
            ->once()
            ->andReturn(true);

        $mock->shouldReceive('delete')
            ->once()
            ->andReturnNull();

        $mock->shouldReceive('load')
            ->once()
            ->andReturnNull();

        $this->assertSame(
            $mock,
            $repo->delete(1)
        );
    }
}
