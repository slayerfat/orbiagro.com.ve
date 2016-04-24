<?php

use Illuminate\Database\Seeder;
use Orbiagro\Mamarrachismo\Upload\Image as Upload;
use Orbiagro\Models\User;

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
     * Para crear data aleatoria
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * @uses BaseSeeder::getUser()
     */
    public function __construct()
    {
        $this->user  = $this->getUser();
        $this->faker = Faker::create('es_ES');
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
