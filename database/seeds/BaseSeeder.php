<?php

use Orbiagro\Models\User;
use Illuminate\Database\Seeder;
use Orbiagro\Mamarrachismo\Upload\Image as Upload;

abstract class BaseSeeder extends Seeder
{

    /**
     * @var Upload
     */
    protected $upload;
    /**
     * El usuario a relacionar con los modelos
     *
     * @param Model
     */
    protected $user;

    /**
     * @uses BaseSeeder::getUser()
     */
    public function __construct()
    {
        $this->user = $this->getUser();
    }

    /**
     * @return User
     */
    protected function getUser()
    {
        $user = User::where('name', 'tester')->first();

        if (!$user) {
            $user = User::where('name', env('APP_USER'))->first();
        }

        return $user;
    }

    /**
     * @param $class
     */
    protected function createDirectory($class)
    {
        $dir = class_basename($class);

        $dir = strtolower($dir);

        // se elimina el directorio de todos los archivos
        Storage::disk('public')->deleteDirectory($dir);
        Storage::disk('public')->makeDirectory($dir);
    }
}
