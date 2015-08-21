<?php

use Illuminate\Database\Seeder;

use App\User;

class BaseSeeder extends Seeder
{

    /**
     * El usuario a relacionar con los modelos
     *
     * @param Model
     */
    protected $user;

    public function __construct()
    {
        $this->user = $this->getUser();
    }

    protected function getUser()
    {
        $user = User::where('name', 'tester')->first();

        if (!$user) {
            $user = User::where('name', env('APP_USER'))->first();
        }

        return $user;
    }
}
