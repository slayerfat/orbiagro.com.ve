<?php namespace Orbiagro\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Orbiagro\Models\Image;
use Orbiagro\Mamarrachismo\Upload\Image as Upload;
use Orbiagro\Models\Product;
use Orbiagro\Repositories\Interfaces\ImageRepositoryInterface;

class ImageRepository extends AbstractRepository implements ImageRepositoryInterface
{

    /**
     * @var Upload
     */
    private $upload;

    /**
     * @param Image $image
     * @param Upload $upload
     */
    public function __construct(Image $image, Upload $upload)
    {
        $this->upload = $upload;

        parent::__construct($image);
    }

    /**
     * @param Model $parentModel
     * @return Model
     * @throws Exceptions\DefaultImageFileNotFoundException
     */
    public function createDefault(Model $parentModel)
    {
        return $this->upload->createDefaultImage($parentModel);
    }

    /**
     * @param $id
     * @param Request $request
     * @return Image
     */
    public function update($id, Request $request)
    {
        $image = $this->getById($id);

        if (!$this->canUserManipulate($image->imageable->user_id)) {
            return false;
        }

        $user = $this->getCurrentUser();

        $this->upload->userId = $user->id;

        if ($request->file('image')) {
            return $this->upload->update($image, $request->file('image'));
        }

        // http://image.intervention.io/api/crop
        // se ajusta segun estos valores:
        $this->upload->cropImage(
            $image,
            $request->input('dataWidth'),
            $request->input('dataHeight'),
            $request->input('dataX'),
            $request->input('dataY')
        );

        return $image;
    }

    /**
     * @param $id
     * @return Model
     * @throws \Exception
     */
    public function delete($id)
    {
        $image = $this->getById($id);

        /** @var Model $parentModel */
        $parentModel = $image->imageable;

        $this->upload->deleteImageFiles($image, true);

        $image->delete();

        $this->checkModelClass($parentModel);

        return $parentModel;
    }

    /**
     * @param $parentModel
     * @throws Exceptions\DefaultImageFileNotFoundException
     */
    private function checkModelClass($parentModel)
    {
        if (get_class($parentModel) === Product::class) {
            if ($parentModel->images->isEmpty()) {
                $this->upload->createDefaultImage($parentModel);
            }
        } elseif (is_null($parentModel->image)) {
            $this->upload->createDefaultImage($parentModel);
        }
    }
}
