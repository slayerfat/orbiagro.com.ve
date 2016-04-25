<?php

use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
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
     * Determina el usuario a utilizar.
     *
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
     * Crea el directorio necesario para introducir imagenes relacionadas a un modelo.
     *
     * @param $class
     */
    protected function createDirectory($class)
    {
        $dir = strtolower(class_basename($class));

        // se elimina el directorio de todos los archivos
        File::deleteDirectory(public_path($dir));
        File::makeDirectory(public_path($dir), 0775, true);
        chgrp(public_path($dir), env('APP_GROUP'));
    }

    /**
     * Permite la creacion de una imagen relacionada a un modelo.
     *
     * @param array $data
     * @return \Symfony\Component\HttpFoundation\File\UploadedFile
     */
    protected function createUploadedFileImg($data)
    {
        $this->command->comment("Creando archivo {$data['url']}");

        if (!Storage::disk('local')->exists($data['temp'])) {
            Storage::disk('local')->put(
                $data['temp'],
                file_get_contents($data['url'])
            );
        }

        $name = str_random() . '.' . $data['ext'];

        Storage::disk('local')->copy($data['temp'], $name);

        // este objeto simula un archivo subido por medio de un usuario.
        return new UploadedFile(
            storage_path('app/' . $name),
            $name,
            $data['mime'],
            Storage::disk('local')->size($data['temp']),
            UPLOAD_ERR_OK,
            true
        );
    }
}
