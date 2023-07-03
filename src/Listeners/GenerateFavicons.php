<?php

namespace Studio1902\PeakBrowserAppearance\Listeners;

use Illuminate\Support\Facades\Artisan;
use Statamic\Events\GlobalSetSaved;
use Statamic\Globals\GlobalSet;
use Illuminate\Support\Facades\Storage;
use Statamic\Facades\URL;

class GenerateFavicons
{
    /**
     * Determine whether this event should be handled.
     *
     * @param GlobalSet $globals
     * @return bool
     */
    private function shouldHandle(GlobalSet $globals): bool
    {
        return $globals->handle() === 'browser_appearance'
            && $globals->inDefaultSite()->get('use_favicons');
    }

    /**
     * Handle the event.
     *
     * @param GlobalSetSaved $event
     * @return void
     */
    public function handle(GlobalSetSaved $event)
    {
        /** @var GlobalSet $globals */
        $globals = $event->globals;

        if (!$this->shouldHandle($globals)) {
            return;
        }

        $svg = $globals->inDefaultSite()->get('svg');
        $background = $globals->inDefaultSite()->get('background');

        $this->createThumbnail($svg, 'icon-180.png', 180, 180, $background, 15);
        $this->createThumbnail($svg, 'icon-512.png', 512, 512, $background, 15);
        $this->createThumbnail($svg, 'favicon-16x16.png', 16, 16, 'transparent', false);
        $this->createThumbnail($svg, 'favicon-32x32.png', 32, 32, 'transparent', false);

        Artisan::call('cache:clear');
    }

    private function createThumbnail($import, $export, $width, $height, $background, $border)
    {
        $svg = file_get_contents(URL::makeAbsolute(Storage::disk('favicons')->url($import)));
        $svgObj = simplexml_load_string($svg);
        $viewBox = explode(' ', $svgObj['viewBox']);
        $viewBoxWidth = $viewBox[2];
        $viewBoxHeight = $viewBox[3];
        if ($viewBoxWidth >= $viewBoxHeight) {
            $ratio = $width / $viewBoxWidth;
        } else {
            $ratio = $height / $viewBoxHeight;
        }

        $im = new \Imagick();
        $im->setResolution($viewBoxWidth * $ratio * 2, $viewBoxHeight * $ratio * 2);
        $im->setBackgroundColor(new \ImagickPixel($background));
        $im->readImageBlob($svg);
        $im->resizeImage($viewBoxWidth * $ratio, $viewBoxHeight * $ratio, \imagick::FILTER_LANCZOS, 1);

        if ($viewBoxWidth >= $viewBoxHeight) {
            $compensateHeight = $height - ($viewBoxHeight * $ratio);
            $im->extentImage($width, $height - $compensateHeight / 2, 0, $compensateHeight * -.5);
            $im->extentImage($width, $height, 0, 0);
        } else {
            $compensateWidth = $width - ($viewBoxWidth * $ratio);
            $im->extentImage($width - $compensateWidth / 2, $height, $compensateWidth * -.5, 0);
            $im->extentImage($width, $height, 0, 0);
        }

        if ($border) {
            $im->borderImage($background, $border, $border);
            $im->resizeImage($width, $height, \imagick::FILTER_LANCZOS, 1);
        }

        $im->setImageFormat('png32');
        Storage::disk('favicons')->put($export, $im->getImageBlob());
        $im->clear();
        $im->destroy();
    }
}
