<?php

namespace Ndeblauw\BlueAdmin;

use Spatie\BladeX\Facades\BladeX;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Ndeblauw\BlueAdmin\FormDataBinder;

class BlueAdminServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Get the configuration (and include changes from config/blueadmin.php)
        $this->mergeConfigFrom( $this->getConfigFile(), 'blueadmin' );

        // For data binding
        $this->app->singleton(FormDataBinder::class, fn() => new FormDataBinder);

        // Building blocks for the lay-out
        $this->loadViewsFrom(__DIR__.'/../resources/views/components/template', 'BlueAdminTemplate');
        $this->loadViewsFrom(__DIR__.'/../resources/views/layouts', 'BlueAdminLayouts');
        $this->loadViewsFrom(__DIR__.'/../resources/views/components', 'BlueAdminComponents');

        // Pages for the generic BlueAdminController
        $this->loadViewsFrom(__DIR__.'/../resources/views/pages', 'BlueAdminPages');
    }

    public function boot()
    {
        Blade::directive('bind', function ($bind) {
            return '<?php app(Ndeblauw\BlueAdmin\FormDataBinder::class)->bind(' . $bind . '); ?>';
        });

        Blade::directive('endbind', function () {
            return '<?php app(Ndeblauw\BlueAdmin\FormDataBinder::class)->pop(); ?>';
        });

        // For the template
        Blade::component('blueadmin-leftmenu', View\Components\Layout\LeftMenu::class);
        Blade::component('blueadmin-topbar-menu', View\Components\Layout\TopbarMenu::class);
        Blade::component('blueadmin-topbar-messages', View\Components\Layout\TopbarMessages::class);
        Blade::component('blueadmin-topbar-notifications', View\Components\Layout\TopbarNotifications::class);

        // Building blocks for admin lay-outs
        Blade::component('blueadmin-card', View\Components\Blocks\Card::class);
        Blade::component('ba-infopanel-text', View\Components\Blocks\InfopanelText::class);

        // Building blocks for admin forms
        Blade::component('ba-info', View\Components\FormElements\Info::class);
        Blade::component('ba-hidden', View\Components\FormElements\Hidden::class);
        Blade::component('ba-text', View\Components\FormElements\Textfield::class);
        Blade::component('ba-textarea', View\Components\FormElements\Textarea::class);
        Blade::component('ba-select', View\Components\FormElements\Select::class);
        Blade::component('ba-radiobuttons', View\Components\FormElements\Radiobuttons::class);
        Blade::component('ba-checkboxes', View\Components\FormElements\Checkboxes::class);
        Blade::component('ba-boolean', View\Components\FormElements\Boolean::class);
        Blade::component('ba-datepicker', View\Components\FormElements\Datepicker::class);
        Blade::component('ba-mediafile', View\Components\FormElements\MediaFile::class);
        Blade::component('ba-fileupload', View\Components\FormElements\FileUpload::class);
        Blade::component('ba-tagselect', View\Components\FormElements\TagSelect::class);
        Blade::component('ba-searchbox', View\Components\FormElements\Searchbox::class);

        Blade::component('ba-belongsto', View\Components\FormElements\BelongsTo::class);


        // For publishing the configuration file
        $this->publishes([ $this->getConfigFile() => config_path('blueadmin.php') ], 'config');


/*
        BladeX::component('BlueAdminFormElements::text')->tag('form-text');
        BladeX::component('BlueAdminFormElements::textarea')->tag('form-textarea');
        BladeX::component('BlueAdminFormElements::switch')->tag('form-switch');
        BladeX::component('BlueAdminFormElements::belongsto')->tag('form-belongsto');
        BladeX::component('BlueAdminFormElements::info')->tag('form-info');
        BladeX::component('BlueAdminFormElements::datetime')->tag('form-datetime');
        BladeX::component('BlueAdminFormElements::hidden')->tag('form-hidden');
        BladeX::component('BlueAdminFormElements::select2')->tag('form-select2');

        BladeX::component('BlueAdminFormElements::mediafile')->tag('form-mediafile');
*/
    }

    protected function getConfigFile(): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'blueadmin.php';
    }
}
