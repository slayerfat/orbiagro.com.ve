<?php namespace Orbiagro\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Orbiagro\Models\Image;
use Orbiagro\Repositories\Exceptions;

interface ImageRepositoryInterface
{

    /**
     * @param  mixed $id
     *
     * @return Image
     */
    public function getById($id);

    /**
     * @param $id
     * @param Request $request
     * @return Image
     */
    public function update($id, Request $request);

    /**
     * @param $id
     * @return Model
     * @throws \Exception
     */
    public function delete($id);

    /**
     * @param Model $parentModel
     * @return Model
     * @throws Exceptions\DefaultImageFileNotFoundException
     */
    public function createDefault(Model $parentModel);
}
