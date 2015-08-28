<?php namespace Tests\Orbiagro\Repositories;

use Mockery;
use Orbiagro\Models\Feature;
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
}
