<?php namespace Tests\Orbiagro\Repositories;

use Mockery;
use Orbiagro\Models\SubCategory;
use Orbiagro\Repositories\Interfaces\CategoryRepositoryInterface;
use Orbiagro\Repositories\SubCategoryRepository;
use Tests\TestCase;

class SubCategoryRepositoryTest extends TestCase
{

    public function testConstruct()
    {
        $mock = Mockery::mock(SubCategory::class);
        $catRepoMock = Mockery::mock(CategoryRepositoryInterface::class);

        $catRepo = new SubCategoryRepository($mock, $catRepoMock);

        $this->assertSame(
            $mock,
            $this->readAttribute($catRepo, 'model')
        );

        $this->assertSame(
            $catRepoMock,
            $this->readAttribute($catRepo, 'catRepo')
        );
    }

    public function testGetRandom()
    {
        $subCatMock = Mockery::mock(SubCategory::class)->makePartial();

        $subCatMock->shouldReceive('has')
                   ->once()
                   ->andReturnSelf();

        $subCatMock->shouldReceive('random')
                   ->once()
                   ->andReturnSelf();

        $subCatMock->shouldReceive('first')
                   ->once()
                   ->andReturnSelf();

        $catRepoMock = Mockery::mock(CategoryRepositoryInterface::class);

        $catRepo = new SubCategoryRepository($subCatMock, $catRepoMock);

        $this->assertSame(
            $subCatMock,
            $catRepo->getRandom()
        );
    }

    public function testGetAll()
    {
        $cat = Mockery::mock(SubCategory::class)->makePartial();
        $catRepoMock = Mockery::mock(CategoryRepositoryInterface::class);

        $cat->shouldReceive('all')
            ->once()
            ->andReturn('mocked collection');

        $catRepo = new SubCategoryRepository($cat, $catRepoMock);

        $this->assertEquals(
            'mocked collection',
            $catRepo->getAll()
        );
    }

    public function testGetLists()
    {
        $mock = Mockery::mock(SubCategory::class)
                       ->makePartial();

        $catRepoMock = Mockery::mock(CategoryRepositoryInterface::class);

        $mock->shouldReceive('pluck')
            ->once()
            ->with('description', 'id')
            ->andReturn('mocked');

        $catRepo = new SubCategoryRepository($mock, $catRepoMock);

        $this->assertEquals(
            'mocked',
            $catRepo->getLists()
        );
    }

    public function testGetEmptyInstance()
    {
        $catRepo = Mockery::mock(SubCategoryRepository::class)
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $catRepo->shouldReceive('getNewInstance')
            ->once()
            ->andReturn('mocked');

        $this->assertEquals(
            'mocked',
            $catRepo->getEmptyInstance()
        );
    }

    public function testGetSibblings()
    {
        $mock = Mockery::mock(SubCategory::class)
                       ->makePartial();

        $catRepoMock = Mockery::mock(CategoryRepositoryInterface::class);

        $mock->shouldReceive('where')
             ->once()
             ->andReturnSelf();

        $mock->shouldReceive('get')
             ->once()
             ->andReturn('mocked');

        $catRepo = new SubCategoryRepository($mock, $catRepoMock);

        $this->assertEquals(
            'mocked',
            $catRepo->getSibblings($mock)
        );
    }
}
