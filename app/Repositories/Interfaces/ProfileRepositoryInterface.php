<?php namespace Orbiagro\Repositories\Interfaces;

interface ProfileRepositoryInterface
{

    /**
     * @param $desc
     *
     * @return mixed|static
     */
    public function getByDescription($desc);
}
