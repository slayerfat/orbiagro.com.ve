<?php namespace Orbiagro\Providers;

use File;
use Illuminate\Support\ServiceProvider;
use Orbiagro\Models\Image;

class ImageDeleteServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Image::deleted(function ($image) {
            $paths = [
                $image->path,
                $image->original,
                $image->small,
                $image->medium,
                $image->large,
            ];

            foreach ($paths as $path) {
                if (File::isFile($path)) {
                    return File::delete($path);
                }
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
