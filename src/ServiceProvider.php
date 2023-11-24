<?php

namespace Studio1902\PeakBrowserAppearance;

use Statamic\Events\GlobalSetSaved;
use Statamic\Providers\AddonServiceProvider;
use Studio1902\PeakBrowserAppearance\Listeners\GenerateFavicons;
use Studio1902\PeakBrowserAppearance\Updates\UpdateBrowserAppearanceGlobals;
use Studio1902\PeakBrowserAppearance\Updates\UpdateFaviconsPath;

class ServiceProvider extends AddonServiceProvider
{
    protected $listen = [
        GlobalSetSaved::class => [
            GenerateFavicons::class,
        ],
    ];

    protected $routes = [
        'web' => __DIR__ . '/../routes/web.php',
    ];

    protected $updateScripts = [
        UpdateBrowserAppearanceGlobals::class,
        UpdateFaviconsPath::class,
    ];

    public function bootAddon()
    {
        $this->registerPublishableFieldsets();
        $this->registerPublishableViews();
    }

    protected function registerPublishableFieldsets()
    {
        $this->publishes([
            __DIR__ . '/../resources/fieldsets' => resource_path('fieldsets/vendor/statamic-peak-browser-appearance'),
        ], 'statamic-peak-browser-appearance-fieldsets');
    }

    protected function registerPublishableViews()
    {
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/statamic-peak-browser-appearance'),
        ], 'statamic-peak-browser-appearance-views');
    }
}
