<?php

namespace Studio1902\PeakBrowserAppearance\Listeners;

use Illuminate\Support\Facades\Artisan;
use Statamic\Events\GlobalSetSaved;
use Statamic\Globals\GlobalSet;

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
        return $globals->handle() === 'browser_appearance';
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

        Artisan::call('statamic:peak:generate-favicons');
    }
}
