<?php namespace Orbiagro\Repositories\Interfaces;

use Illuminate\Http\Request;
use Orbiagro\Models\Image;

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
}
