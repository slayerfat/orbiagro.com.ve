<?php namespace Orbiagro\Http\Controllers;

use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\View\View;
use Orbiagro\Repositories\Interfaces\CategoryRepositoryInterface;
use Orbiagro\Repositories\Interfaces\PromotionRepositoryInterface;
use Orbiagro\Repositories\Interfaces\SubCategoryRepositoryInterface;

class HomeController extends Controller
{

    use SEOToolsTrait;

    /**
     * @var CategoryRepositoryInterface
     */
    protected $catRepo;

    /**
     * @var SubCategoryRepositoryInterface
     */
    protected $subCatRepo;

    /**
     * @var PromotionRepositoryInterface
     */
    protected $promoRepo;

    /**
     * Create a new controller instance.
     *
     * @param CategoryRepositoryInterface $catRepo
     * @param SubCategoryRepositoryInterface $subCatRepo
     * @param PromotionRepositoryInterface $promoRepo
     */
    public function __construct(
        CategoryRepositoryInterface $catRepo,
        SubCategoryRepositoryInterface $subCatRepo,
        PromotionRepositoryInterface $promoRepo
    ) {
        $this->middleware('auth', ['except' => 'index']);

        $this->catRepo    = $catRepo;
        $this->subCatRepo = $subCatRepo;
        $this->promoRepo  = $promoRepo;
    }

    /**
     * Show the application index to the user.
     *
     * @todo mejorar logica de seleccion de tipos de promociones,
     *       abstraer a una clase o incluirlo dentro de la clase Promotion
     *
     * @return View
     */
    public function index()
    {
        $subCategory = $this->subCatRepo->getRandom();

        $cats = $this->catRepo->getAll();

        $promotions = $this->promoRepo->getHomeRelated();

        $this->seo()->opengraph()->setUrl(route('home'));

        return view('home.index', compact('subCategory', 'promotions', 'cats'));
    }

    /**
     * Muestra la vista para el usuario no verificado.
     *
     * @param  Guard $auth
     * @return View
     */
    public function unverified(Guard $auth)
    {
        $user = $auth->user();

        return view('auth.verification', compact('user'));
    }
}
