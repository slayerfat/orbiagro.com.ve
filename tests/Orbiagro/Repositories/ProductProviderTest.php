<?php namespace Tests\Orbiagro\Repositories;

use Mockery;
use Orbiagro\Models\Product;
use Orbiagro\Repositories\CategoryRepository;
use Orbiagro\Repositories\ProductRepository;
use Orbiagro\Repositories\SubCategoryRepository;
use Tests\TestCase;

class ProductProviderTest extends TestCase
{

    public function testConstruct()
    {
        $productMock    = Mockery::mock(Product::class);
        $catRepoMock    = Mockery::mock(CategoryRepository::class);
        $subCatRepoMock = Mockery::mock(SubCategoryRepository::class);

        $productRepo = new ProductRepository(
            $productMock,
            $catRepoMock,
            $subCatRepoMock
        );

        $this->assertSame(
            $productMock,
            $this->readAttribute($productRepo, 'model')
        );

        $this->assertSame(
            $catRepoMock,
            $this->readAttribute($productRepo, 'catRepo')
        );

        $this->assertSame(
            $subCatRepoMock,
            $this->readAttribute($productRepo, 'subCatRepo')
        );
    }

    public function testGetPaginated()
    {
        $productMock    = Mockery::mock(Product::class)->makePartial();
        $catRepoMock    = Mockery::mock(CategoryRepository::class);
        $subCatRepoMock = Mockery::mock(SubCategoryRepository::class);

        $productMock->shouldReceive('paginate')
            ->once()
            ->with(1)
            ->andReturnSelf();

        $productRepo = new ProductRepository(
            $productMock,
            $catRepoMock,
            $subCatRepoMock
        );

        $this->assertSame(
            $productMock,
            $productRepo->getPaginated(1)
        );
    }

    public function testGetByIdWithTrashed()
    {
        $productMock    = Mockery::mock(Product::class)->makePartial();
        $catRepoMock    = Mockery::mock(CategoryRepository::class);
        $subCatRepoMock = Mockery::mock(SubCategoryRepository::class);

        $productMock->shouldReceive('withTrashed')
                    ->once()
                    ->andReturnSelf();

        $productMock->shouldReceive('findOrFail')
                    ->once()
                    ->with(1)
                    ->andReturn('mocked');

        $productRepo = new ProductRepository(
            $productMock,
            $catRepoMock,
            $subCatRepoMock
        );

        $this->assertEquals(
            'mocked',
            $productRepo->getByIdWithTrashed(1)
        );
    }

    public function testStore()
    {
        $productMock = Mockery::mock(Product::class)
                              ->shouldAllowMockingProtectedMethods()
                              ->makePartial();

        $productMock->shouldReceive('fill')
                    ->once()
                    ->andReturnNull();

        $catRepoMock    = Mockery::mock(CategoryRepository::class);
        $subCatRepoMock = Mockery::mock(SubCategoryRepository::class);

        $productRepo = Mockery::mock(
            ProductRepository::class,
            [
                $productMock,
                $catRepoMock,
                $subCatRepoMock
            ]
        )->shouldAllowMockingProtectedMethods()->makePartial();

        $productRepo->shouldReceive('getEmptyInstance')
            ->once()
            ->andReturn($productMock);

        $productRepo->shouldReceive('storeModels')
                    ->once()
                    ->andReturn('mocked');

        $this->assertEquals(
            'mocked',
            $productRepo->store([1])
        );
    }

    public function testUpdate()
    {
        $productMock = Mockery::mock(Product::class)
                              ->shouldAllowMockingProtectedMethods()
                              ->makePartial();

        $productMock->shouldReceive('update')
                    ->once()
                    ->andReturnNull();

        $catRepoMock    = Mockery::mock(CategoryRepository::class);
        $subCatRepoMock = Mockery::mock(SubCategoryRepository::class);

        $productRepo = Mockery::mock(
            ProductRepository::class,
            [
                $productMock,
                $catRepoMock,
                $subCatRepoMock
            ]
        )->shouldAllowMockingProtectedMethods()->makePartial();

        $productRepo->shouldReceive('getById')
                    ->once()
                    ->andReturn($productMock);

        $productRepo->shouldReceive('updateRelatedModels')
                    ->once()
                    ->andReturn('mocked');

        $this->assertSame(
            $productMock,
            $productRepo->update(1, [])
        );
    }

    public function testGetByParentSlugOrId()
    {
        $productMock = Mockery::mock(Product::class);

        $catRepoMock = Mockery::mock(CategoryRepository::class)
            ->makePartial();

        $catRepoMock->shouldReceive('getBySlugOrId')
                    ->once()
                    ->andReturnSelf();

        $catRepoMock->shouldReceive('products')
                    ->once()
                    ->andReturnSelf();

        $catRepoMock->shouldReceive('paginate')
                    ->once()
                    ->andReturn($productMock);


        $subCatRepoMock = Mockery::mock(SubCategoryRepository::class);

        $productRepo = Mockery::mock(
            ProductRepository::class,
            [
                $productMock,
                $catRepoMock,
                $subCatRepoMock
            ]
        )->shouldAllowMockingProtectedMethods()->makePartial();

        $this->assertSame(
            $productMock,
            $productRepo->getByParentSlugOrId('category', 1)
        );
    }

    /**
     * @expectedException \LogicException
     */
    public function testGetByParentSlugOrIdShouldThrowException()
    {
        $productMock    = Mockery::mock(Product::class);
        $catRepoMock    = Mockery::mock(CategoryRepository::class);
        $subCatRepoMock = Mockery::mock(SubCategoryRepository::class);

        $productRepo = Mockery::mock(
            ProductRepository::class,
            [
                $productMock,
                $catRepoMock,
                $subCatRepoMock
            ]
        )->shouldAllowMockingProtectedMethods()->makePartial();

        $this->assertSame(
            $productMock,
            $productRepo->getByParentSlugOrId('hello boxxy', 1)
        );
    }
}
