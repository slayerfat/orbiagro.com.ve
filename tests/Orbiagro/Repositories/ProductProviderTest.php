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

        $providerRepo = new ProductRepository(
            $productMock,
            $catRepoMock,
            $subCatRepoMock
        );

        $this->assertSame(
            $productMock,
            $this->readAttribute($providerRepo, 'model')
        );

        $this->assertSame(
            $catRepoMock,
            $this->readAttribute($providerRepo, 'catRepo')
        );

        $this->assertSame(
            $subCatRepoMock,
            $this->readAttribute($providerRepo, 'subCatRepo')
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

        $providerRepo = new ProductRepository(
            $productMock,
            $catRepoMock,
            $subCatRepoMock
        );

        $this->assertSame(
            $productMock,
            $providerRepo->getPaginated(1)
        );
    }
}
