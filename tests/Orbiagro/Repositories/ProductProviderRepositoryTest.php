<?php namespace Tests\Orbiagro\Repositories;

use Mockery;
use Orbiagro\Models\Provider;
use Orbiagro\Repositories\ProductProviderRepository;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;

class ProductProviderRepositoryTest extends TestCase
{

    public function testConstruct()
    {
        $mock = Mockery::mock(Provider::class)
                             ->makePartial();

        $providerRepo = new ProductProviderRepository($mock);

        $this->assertSame(
            $mock,
            $this->readAttribute($providerRepo, 'model')
        );
    }

    public function testGetLists()
    {
        $mock = Mockery::mock(Provider::class)
                       ->makePartial();

        $mock->shouldReceive('lists')
            ->once()
            ->with('name', 'id')
            ->andReturn('mocked');

        $providerRepo = new ProductProviderRepository($mock);

        $this->assertEquals(
            'mocked',
            $providerRepo->getLists()
        );
    }

    public function testGetEmptyInstance()
    {
        $mock = Mockery::mock(Provider::class);

        $providerRepo = Mockery::mock(ProductProviderRepository::class, [$mock])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $providerRepo->shouldReceive('getNewInstance')
            ->once()
            ->andReturn('mocked');

        $this->assertEquals(
            'mocked',
            $providerRepo->getEmptyInstance()
        );
    }

    public function testGetAll()
    {
        $provider = Mockery::mock(Provider::class)
                              ->makePartial();

        $provider->shouldReceive('with')
            ->once()
            ->with('products')
            ->andReturnSelf();

        $provider->shouldReceive('get')
            ->once()
            ->andReturn('mocked collection');

        $providerRepo = new ProductProviderRepository($provider);

        $this->assertEquals(
            'mocked collection',
            $providerRepo->getAll()
        );
    }

    public function testGetById()
    {
        $provider = Mockery::mock(Provider::class)
                           ->makePartial();

        $provider->shouldReceive('with')
                 ->once()
                 ->with('products')
                 ->andReturnSelf();

        $provider->shouldReceive('findOrFail')
                 ->once()
                 ->andReturn('mocked');

        $providerRepo = new ProductProviderRepository($provider);

        $this->assertEquals(
            'mocked',
            $providerRepo->getById(1)
        );
    }

    public function testStore()
    {
        $providerRepo = Mockery::mock(ProductProviderRepository::class)
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $providerRepo->shouldReceive('getNewInstance')
            ->once()
            ->andReturnSelf();

        $providerRepo->shouldReceive('save')
                 ->once()
                 ->andReturn('mocked');

        $this->assertSame(
            $providerRepo,
            $providerRepo->store([])
        );
    }

    public function testUpdate()
    {
        $mock = Mockery::mock(Provider::class);

        $mock->shouldReceive('with')
             ->once()
             ->with('products')
             ->andReturnSelf();

        $mock->shouldReceive('findOrFail')
             ->once()
             ->andReturnSelf();

        $mock->shouldReceive('fill')
             ->once()
             ->with([])
             ->andReturnSelf();

        $mock->shouldReceive('update')
             ->once()
             ->andReturnSelf();

        $providerRepo = new ProductProviderRepository($mock);

        $this->assertSame(
            $mock,
            $providerRepo->update(1, [])
        );
    }

    public function testDestroy()
    {
        $mock = Mockery::mock(Provider::class);

        $providerRepo = Mockery::mock(ProductProviderRepository::class, [$mock])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $providerRepo->shouldReceive('executeDelete')->andReturn('mocked');

        $this->assertEquals(
            'mocked',
            $providerRepo->destroy(1)
        );
    }
}
