<?php namespace Tests\Orbiagro\Repositories;

use Mockery;
use Tests\TestCase;
use Orbiagro\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Orbiagro\Repositories\CategoryRepository;

class CategoryRepositoryTest extends TestCase
{

    public function testConstruct()
    {
        $mock = Mockery::mock(Category::class)
                             ->makePartial();

        $catRepo = new CategoryRepository($mock);

        $this->assertSame(
            $mock,
            $this->readAttribute($catRepo, 'model')
        );
    }

    public function testGetAll()
    {
        $cat = Mockery::mock(Category::class)
                              ->makePartial();

        $cat->shouldReceive('has')
            ->once()
            ->with('subCategories')
            ->andReturnSelf();

        $cat->shouldReceive('with')
            ->once()
            ->with('subCategories')
            ->andReturnSelf();

        $cat->shouldReceive('get')
            ->once()
            ->andReturn('mocked collection');

        $catRepo = new CategoryRepository($cat);

        $this->assertEquals(
            'mocked collection',
            $catRepo->getAll()
        );
    }

    public function testGetRelatedProducts()
    {
        $cat = Mockery::mock(Category::class)
                      ->makePartial();

        $catRepo = new CategoryRepository($cat);

        $collectionMock = Mockery::mock(Collection::class)->makePartial();

        $collectionMock->shouldReceive('each')
            ->once()
            ->andReturn('mocked collection');

        $this->assertEquals(
            'mocked collection',
            $catRepo->getRelatedProducts($collectionMock)
        );
    }

    public function testCreate()
    {
        $mock = Mockery::mock(Category::class)
                      ->makePartial();

        $mock->shouldReceive('save')
            ->once()->andReturnNull();
        $mock->shouldReceive('newInstance')
            ->once()->andReturnSelf();

        $mockRepo = new CategoryRepository($mock);

        $this->assertSame(
            $mock,
            $mockRepo->create([])
        );
    }

    public function testGetSubCats()
    {
        $mock = Mockery::mock(Category::class)
                       ->makePartial();

        $mock->subCategories = 'mocked';

        $mockRepo = new CategoryRepository($mock);

        $this->assertEquals(
            'mocked',
            $mockRepo->getSubCats($mock)
        );
    }

    public function testUpdate()
    {
        $mock = Mockery::mock(Category::class)
                       ->makePartial();

        $mock->shouldReceive('findOrFail')
            ->once()
            ->andReturnSelf();

        $mock->shouldReceive('load')
            ->with('image')
            ->once()
            ->andReturnSelf();

        $mock->shouldReceive('update')
            ->once()
            ->andReturnNull();

        $mockRepo = new CategoryRepository($mock);

        $this->assertSame(
            $mock,
            $mockRepo->update(1, [])
        );
    }

    public function testDelete()
    {
        $mock = Mockery::mock(Category::class)
                       ->makePartial();

        $mock->shouldReceive('findOrFail')
             ->once()
             ->andReturnSelf();

        $mock->shouldReceive('delete')
             ->once()
             ->andReturn('mocked');

        $mockRepo = new CategoryRepository($mock);

        $this->assertEquals(
            'mocked',
            $mockRepo->delete(1)
        );
    }

    public function testGetById()
    {
        $mock = Mockery::mock(Category::class)
                       ->makePartial();

        $mock->shouldReceive('findOrFail')
             ->once()
             ->andReturn('mocked');

        $mockRepo = new CategoryRepository($mock);

        $this->assertEquals(
            'mocked',
            $mockRepo->getById(1)
        );
    }
}
