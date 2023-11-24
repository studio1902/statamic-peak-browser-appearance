<?php

namespace Studio1902\PeakBrowserAppearance\Updates;

use Statamic\Facades\Asset;
use Statamic\UpdateScripts\UpdateScript;
use Studio1902\PeakBrowserAppearance\Generators\Favicons;

class UpdateFaviconsPath extends UpdateScript
{
    public function shouldUpdate($newVersion, $oldVersion): bool
    {
        return $this->isUpdatingTo('3.3.0');
    }

    public function update(): void
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
            ->each->delete();
    }

    protected function generateIcons(): void
    {
        Favicons::generate();
    }
}
