<?php namespace Tests\Orbiagro\Repositories;

use Mockery;
use Orbiagro\Models\Feature;
use Orbiagro\Models\Image;
use Orbiagro\Mamarrachismo\Upload\Image as Upload;
use Orbiagro\Models\Product;
use Orbiagro\Repositories\ImageRepository;
use Illuminate\Http\Request;
use stdClass;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Tests\TestCase;

class ImageRepositoryTest extends TestCase
{

    public function testConstruct()
    {
        /** @var Image $imageMock */
        $imageMock = Mockery::mock(Image::class);

        $uploadMock = Mockery::mock(Upload::class);

        $repo = new ImageRepository($imageMock, $uploadMock);

        $this->assertSame(
            $imageMock,
            $this->readAttribute($repo, 'model')
        );

        $this->assertSame(
            $uploadMock,
            $this->readAttribute($repo, 'upload')
        );
    }

    public function testCreateDefault()
    {
        /** @var Image $imageMock */
        $imageMock = Mockery::mock(Image::class);

        $uploadMock = Mockery::mock(Upload::class)
                             ->makePartial();

        $uploadMock->shouldReceive('createDefaultImage')
                   ->once()
                   ->andReturn('mocked');

        $repo = new ImageRepository($imageMock, $uploadMock);

        $this->assertEquals(
            'mocked',
            $repo->createDefault($imageMock)
        );
    }

    public function testUpdateReturnsFalseWhenUserCantManipulate()
    {
        /** @var Image $imageMock */
        $imageMock = Mockery::mock(Image::class)
                            ->makePartial();

        $imageMock->imageable          = new StdClass;
        $imageMock->imageable->user_id = 1;

        $uploadMock = Mockery::mock(Upload::class)
                             ->makePartial();

        $requestMock = Mockery::mock(Request::class)
                              ->makePartial();

        $repoMock = Mockery::mock(ImageRepository::class, [$imageMock, $uploadMock])
                           ->shouldAllowMockingProtectedMethods()
                           ->makePartial();

        $repoMock->shouldReceive('getById')
                 ->once()
                 ->andReturn($imageMock);

        $repoMock->shouldReceive('canUserManipulate')
                 ->once()
                 ->andReturnNull();

        $this->assertFalse($repoMock->update(1, $requestMock));
    }

    public function testUpdateWhenRequestHasFile()
    {
        /** @var Image $imageMock */
        $imageMock = Mockery::mock(Image::class)
                            ->makePartial();

        $imageMock->imageable          = new StdClass;
        $imageMock->imageable->user_id = 1;

        $uploadMock = Mockery::mock(Upload::class)
                             ->makePartial();

        $fileUploadMock = Mockery::mock(UploadedFile::class);

        $requestMock = Mockery::mock(Request::class)
                              ->makePartial();

        $requestMock->shouldReceive('file')
                    ->atLeast()
                    ->once()
                    ->with('image')
                    ->andReturn($fileUploadMock);

        $uploadMock->shouldReceive('update')
                   ->once()
                   ->withArgs([$imageMock, $fileUploadMock])
                   ->andReturn('mocked');

        $repoMock = Mockery::mock(
            ImageRepository::class,
            [$imageMock, $uploadMock]
        )->shouldAllowMockingProtectedMethods()
                           ->makePartial();

        $repoMock->shouldReceive('getById')
                 ->once()
                 ->andReturn($imageMock);

        $repoMock->shouldReceive('canUserManipulate')
                 ->once()
                 ->andReturn(true);

        $currentUser     = new StdClass;
        $currentUser->id = 1;

        $repoMock->shouldReceive('getCurrentUser')
                 ->once()
                 ->andReturn($currentUser);

        $this->assertEquals(
            'mocked',
            $repoMock->update(1, $requestMock)
        );
    }

    public function testUpdateWhenRequestDoesntHaveFile()
    {
        /** @var Image $imageMock */
        $imageMock = Mockery::mock(Image::class)
                            ->makePartial();

        $imageMock->imageable          = new StdClass;
        $imageMock->imageable->user_id = 1;

        $uploadMock = Mockery::mock(Upload::class)
                             ->makePartial();

        $requestMock = Mockery::mock(Request::class)
                              ->makePartial();

        $requestMock->shouldReceive('file')
                    ->atLeast()
                    ->once()
                    ->with('image')
                    ->andReturn(false);

        $requestMock->shouldReceive('input')
                    ->atLeast()
                    ->times(4)
                    ->andReturnNull();

        $uploadMock->shouldReceive('cropImage')
                   ->once()
                   ->andReturnNull();

        $repoMock = Mockery::mock(
            ImageRepository::class,
            [$imageMock, $uploadMock]
        )->shouldAllowMockingProtectedMethods()
                           ->makePartial();

        $repoMock->shouldReceive('getById')
                 ->once()
                 ->andReturn($imageMock);

        $repoMock->shouldReceive('canUserManipulate')
                 ->once()
                 ->andReturn(true);

        $currentUser     = new StdClass;
        $currentUser->id = 1;

        $repoMock->shouldReceive('getCurrentUser')
                 ->once()
                 ->andReturn($currentUser);

        $this->assertSame(
            $imageMock,
            $repoMock->update(1, $requestMock)
        );
    }

    public function testDeleteWithProductModel()
    {
        $imageMock = Mockery::mock(Image::class)
                            ->makePartial();

        $imageMock->shouldReceive('delete')
            ->once();

        $imagesCollection = collect();
        $parentModelMock = factory(Product::class)->make(['images' => $imagesCollection]);
        $imageMock->imageable = $parentModelMock;

        $uploadMock = Mockery::mock(Upload::class)
                             ->makePartial();

        $uploadMock->shouldReceive('deleteImageFiles')
                   ->once();

        $uploadMock->shouldReceive('createDefaultImage')
                   ->once();

        $repoMock = Mockery::mock(
            ImageRepository::class,
            [$imageMock, $uploadMock]
        )->shouldAllowMockingProtectedMethods()
                           ->makePartial();

        $repoMock->shouldReceive('getById')
                 ->once()
                 ->andReturn($imageMock);

        $this->assertSame(
            $parentModelMock,
            $repoMock->delete(1)
        );
    }

    public function testDeleteWithoutProductModel()
    {
        $imageMock = Mockery::mock(Image::class)
                            ->makePartial();

        $imageMock->shouldReceive('delete')
                  ->once();

        $parentModelMock = factory(Feature::class)->make(['image' => null]);

        $imageMock->imageable = $parentModelMock;

        $uploadMock = Mockery::mock(Upload::class)
                             ->makePartial();

        $uploadMock->shouldReceive('deleteImageFiles')
                   ->once();

        $uploadMock->shouldReceive('createDefaultImage')
                   ->once();

        $repoMock = Mockery::mock(
            ImageRepository::class,
            [$imageMock, $uploadMock]
        )->shouldAllowMockingProtectedMethods()
                           ->makePartial();

        $repoMock->shouldReceive('getById')
                 ->once()
                 ->andReturn($imageMock);

        $this->assertSame(
            $parentModelMock,
            $repoMock->delete(1)
        );
    }
}
