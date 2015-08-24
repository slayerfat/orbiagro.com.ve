<?php namespace Orbiagro\Providers;

use Illuminate\Support\ServiceProvider;

use Orbiagro\Models\Image;
use File;

class ImageDeleteServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Image::deleting(function ($image) {
            if (File::isFile($image->path)) {
                return File::delete($image->path);
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
