<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\State;
use App\Town;
use App\Parish;
use Illuminate\Http\Request;

class DirectionsController extends Controller
{

    /**
    * todos los estados
    */
    public function states()
    {
        return State::all();
    }

    /**
    * los municipios del estado $id
    *
    * @param $id el id del municipio tal
    */
    public function towns($id)
    {
        return Town::where('state_id', $id)->get();
    }

    /**
    * todos los municipios que tengan el mismo estado del municipio $id
    *
    * @param $id el id del municipio tal
    */
    public function town($id)
    {
        $town = Town::where('id', $id)->first();
        $number = $town->state_id;
        return Town::where('state_id', $number)->get();
    }

    /**
    * las parroquias del municipio $id
    *
    * @param $id el id de la parroquia tal
    */
    public function parishes($id)
    {
        return Parish::where('town_id', $id)->get();
    }

    /**
    * todas las parroquias que tengan el mismo municipio de la parroquia $id
    *
    * @param $id el id de la parroquia tal
    */
    public function parish($id)
    {
        $parish = Parish::where('id', $id)->first();
        $number = $parish->town_id;
        return Parish::where('town_id', $number)->get();
    }
}
