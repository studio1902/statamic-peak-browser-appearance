<?php

namespace Studio1902\PeakBrowserAppearance;

use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $routes = [
        'web' => __DIR__ . '/../routes/web.php',
    ];

    public function bootAddon()
    {
        $this->registerPublishableFieldsets();
    }

    protected function registerPublishableFieldsets()
    {
        $this->publishes([
            __DIR__ . '/../resources/fieldsets' => resource_path('fieldsets/vendor/statamic-peak-browser-appearance'),
        ], 'statamic-peak-browser-appearance-fieldsets');
    }
}
