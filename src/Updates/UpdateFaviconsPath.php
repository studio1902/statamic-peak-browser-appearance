<?php

namespace Studio1902\PeakBrowserAppearance\Updates;

use Illuminate\Support\Facades\Artisan;
use Statamic\Facades\Asset;
use Statamic\UpdateScripts\UpdateScript;

class UpdateFaviconsPath extends UpdateScript
{
    public function shouldUpdate($newVersion, $oldVersion)
    {
        return $this->isUpdatingTo('3.3.0');
    }

    public function update()
    {
        $this->deleteOldIcons();
        $this->generateIcons();
        $this->console()->info('Favicon paths adjusted.');
    }

    protected function deleteOldIcons(): void
    {
        $icons = collect([
            'icon-180.png',
            'icon-512.png',
            'favicon-16x16.png',
            'favicon-32x32.png',
        ]);

        Asset::whereFolder('/', 'favicons')
            ?->filter(fn(\Statamic\Assets\Asset $asset) => $icons->contains($asset->path()))
            ->each
            ->delete();
    }

    protected function generateIcons(): void
    {
        Artisan::call('statamic:peak:generate-favicons');
    }
}
