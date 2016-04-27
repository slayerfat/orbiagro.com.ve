<?php namespace Orbiagro\Providers;

use Illuminate\Support\ServiceProvider;
use Orbiagro\Models\Image;
use Orbiagro\Models\Product;
use Orbiagro\Models\Visit;
use Storage;

class ProductServiceProvider extends ServiceProvider
{

    /**
     * El id del producto a manipular.
     *
     * @var int
     */
    protected $id;

    /**
     * Determina si el producto esta siendo borrado forzadamente.
     *
     * @var bool
     */
    protected $forceDeleting;

    /**
     * @var \Orbiagro\Models\Image
     */
    protected $images;


    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Product::deleting(function (Product $model) {
            if ($this->forceDeleting = $model->isForceDeleting()) {
                $this->images = $model->images;
                $this->id     = $model->id;
            }
        });

        Product::deleted(function (Product $model) {
            if ($this->forceDeleting) {
                if ($this->images) {
                    $this->images->each(function (Image $image) {
                        $image->delete();
                    });
                }

                if ($model->visits) {
                    $model->visits->each(function (Visit $visit) {
                        $visit->delete();
                    });
                }

                if ($model->direction) {
                    $model->direction->delete();
                }

                Storage::disk('public')->deleteDirectory("products/{$this->id}");
            }
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
