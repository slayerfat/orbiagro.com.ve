<?php namespace App\Http\Composers;

use Illuminate\Contracts\View\View;
use App\Mamarrachismo\VisitsService;

use App\Product;
use App\SubCategory;

class Visits {

  function __construct(VisitsService $visits)
  {
    $this->visits = $visits;
  }

  public function composePopularSubCats(View $view)
  {
    $view->with('popularSubCats', $this->visits->getPopular(new SubCategory));
  }

  public function composeRelatedProducts(View $view)
  {
    $view->with('visitedProducts', $this->visits->getVisitedResources(new Product));
  }

  public function composeVisitedSubCats(View $view)
  {
    $view->with('visitedSubCats', $this->visits->getVisitedResources(new SubCategory));
  }
}
