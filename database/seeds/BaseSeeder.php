<?php

use Illuminate\Database\Seeder;

use Orbiagro\Models\User;

class BaseSeeder extends Seeder
{

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
}
