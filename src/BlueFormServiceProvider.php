<?php

namespace Ndeblauw\BlueAdmin;

use Spatie\BladeX\Facades\BladeX;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BlueAdminServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadViewsFrom(__DIR__.'/views/components/formelements', 'BlueAdminFormElements');
        $this->loadViewsFrom(__DIR__.'/views/pages', 'BlueAdminPages');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__.'/routes.php';

        Blade::directive('widget', function ($expression) {
            $name = trim($expression, "'");
            return "<?= resolve({$name})->loadView(); ?>";
        });

        BladeX::component('BlueAdminFormElements::text')->tag('form-text');
        BladeX::component('BlueAdminFormElements::textarea')->tag('form-textarea');
        BladeX::component('BlueAdminFormElements::switch')->tag('form-switch');
        BladeX::component('BlueAdminFormElements::belongsto')->tag('form-belongsto');
        BladeX::component('BlueAdminFormElements::info')->tag('form-info');
        BladeX::component('BlueAdminFormElements::datetime')->tag('form-datetime');
    }
}
