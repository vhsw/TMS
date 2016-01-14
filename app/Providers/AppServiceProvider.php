<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Resource;

class AppServiceProvider extends ServiceProvider
{
    protected $resources;
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //$this->resources = Resource::all();
        //view()->share('resources', $this->resources);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
