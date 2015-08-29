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
        $mock = Mockery::mock(Feature::class);

        $repo = Mockery::mock(FeatureRepository::class, [$mock])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $repo->shouldReceive('getById')
            ->once()
            ->with(1)
            ->andReturnSelf();

        $repo->shouldReceive('update')
            ->once()
            ->andReturnNull();

        $repo->shouldReceive('load')
            ->once()
            ->andReturnNull();

        $this->markTestIncomplete('Lluvia seria, pushing antes que se vaya la luz, lol');

        $this->assertNull(
            $repo->update(1, [])
        );
    }
}
