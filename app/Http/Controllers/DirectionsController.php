<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\State;
use App\Town;
use App\Parish;

class DirectionsController extends Controller
{

    /**
    * Regresa todos los estados.
    *
    * @return \Collection
    */
    public function states()
    {
        return State::all();
    }

    /**
    * Regresa los municipios del estado tal ($id).
    *
    * @param int $id el id del estado tal
    *
    * @return \Collection
    */
    public function towns($id)
    {
        return Town::where('state_id', $id)->get();
    }

    /**
    * Regresa todos los municipios que tengan
    * el mismo estado del municipio tal ($id)
    *
    * @param int $id el id del municipio tal
    *
    * @return \Collection
    */
    public function town($id)
    {
        $town = Town::where('id', $id)->first();
        $number = $town->state_id;
        return Town::where('state_id', $number)->get();
    }

    /**
    * Regresa las parroquias del municipio tal ($id)
    *
    * @param int $id el id de la municipio tal
    *
    * @return \Collection
    */
    public function parishes($id)
    {
        return Parish::where('town_id', $id)->get();
    }

    /**
    * Regresa todas las parroquias que tengan
    * el mismo municipio de la parroquia tal ($id)
    *
    * @param int $id el id de la parroquia tal
    *
    * @return \Collection
    */
    public function parish($id)
    {
        $parish = Parish::where('id', $id)->first();
        $number = $parish->town_id;
        return Parish::where('town_id', $number)->get();
    }
}
