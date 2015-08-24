<?php namespace App\Http\Composers;

use Illuminate\Contracts\View\View;
use App\Mamarrachismo\VisitsService;

use App\Product;
use App\SubCategory;

class Visits
{

    /**
     * @param VisitsService $visits
     *
     * @return void
     */
    public function __construct(VisitsService $visits)
    {
        $this->visits = $visits;
    }

    /**
     * @param  View   $view
     * @return Response
     */
    public function composePopularSubCats(View $view)
    {
        $view->with('popularSubCats', $this->visits->getPopular(new SubCategory));
    }

    /**
     * @param  View   $view
     * @return Response
     */
    public function composeRelatedProducts(View $view)
    {
        $view->with('visitedProducts', $this->visits->getVisitedResources(new Product));
    }

    /**
     * @param  View   $view
     * @return Response
     */
    public function composeVisitedSubCats(View $view)
    {
        $view->with('visitedSubCats', $this->visits->getVisitedResources(new SubCategory));
    }
}
