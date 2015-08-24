<?php namespace Orbiagro\Http\Composers;

use Illuminate\Contracts\View\View;
use Orbiagro\Mamarrachismo\VisitsService;

use Orbiagro\Models\Product;
use Orbiagro\Models\SubCategory;

class Visits
{

    /**
     * @var VisitsService
     */
    public $visits;

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
        $view->with('popularSubCats', $this->visits->getPopular(SubCategory::class));
    }

    /**
     * @param  View   $view
     * @return Response
     */
    public function composeRelatedProducts(View $view)
    {
        $view->with('visitedProducts', $this->visits->getVisitedResources(Product::class));
    }

    /**
     * @param  View   $view
     * @return Response
     */
    public function composeVisitedSubCats(View $view)
    {
        $view->with('visitedSubCats', $this->visits->getVisitedResources(SubCategory::class));
    }
}
