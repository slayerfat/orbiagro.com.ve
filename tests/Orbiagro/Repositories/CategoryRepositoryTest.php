<?php namespace Tests\Orbiagro\Repositories;

use Mockery;
use Tests\TestCase;
use Orbiagro\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Orbiagro\Repositories\CategoryRepository;
use Tests\Orbiagro\Traits\TearsDownMockery;

class CategoryRepositoryTest extends TestCase
{

    use TearsDownMockery;

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

        $cat->shouldReceive('all')
            ->once()
            ->andReturnSelf();

        $cat->shouldReceive('load')
            ->once()
            ->with('subCategories')
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

        $collectionMock->shouldReceive('each')->once()->andReturn('mocked collection');

        $this->assertEquals(
            'mocked collection',
            $catRepo->getRelatedProducts($collectionMock)
        );
    }
}
