<?php namespace Orbiagro\Http\Composers;

use Illuminate\Contracts\View\View;

use Orbiagro\Mamarrachismo\Business;

class OrbiagroInfo
{

    /**
     * @param  View   $view
     * @return Response
     */
    public function composeInfo(View $view)
    {
        $obj = new Business; // no necesita parametros, por ahora.

        $view->with('business', $obj);
    }
}
