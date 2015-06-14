<?php namespace App\Http\Composers;

use Illuminate\Contracts\View\View;
use App\Mamarrachismo\VisitsService;

class Visits {

  function __construct(VisitsService $visits)
  {
    $this->visits = $visits;
  }

  public function composePopularSubCats(View $view)
  {
    $view->with('popularSubCats', $this->visits->getPopular('subCategory'));
  }

  public function composeRelatedProducts(View $view)
  {
    $view->with('visitedProducts', $this->visits->getVisitedProducts());
  }
}
