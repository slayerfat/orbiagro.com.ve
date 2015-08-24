<?php namespace App\Http\Composers;

use Illuminate\Contracts\View\View;

use App\Mamarrachismo\Business;

class OrbiagroInfo
{

    /**
     * @param  View   $view
     * @return Response
     */
    public function composeInfo(View $view)
    {
        $view->with('business', new Business);
    }
}
