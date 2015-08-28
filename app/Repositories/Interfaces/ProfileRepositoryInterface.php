<?php namespace Orbiagro\Repositories\Interfaces;

interface ProfileRepositoryInterface
{

    /**
     * @param string $desc
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getByDescription($desc);
}
