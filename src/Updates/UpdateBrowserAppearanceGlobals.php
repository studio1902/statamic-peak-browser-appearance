<?php

namespace Studio1902\PeakBrowserAppearance\Updates;

use Statamic\Facades\Blueprint;
use Statamic\Facades\GlobalSet;
use Statamic\Facades\Site;
use Statamic\UpdateScripts\UpdateScript;

class UpdateBrowserAppearanceGlobals extends UpdateScript
{
    public function shouldUpdate($newVersion, $oldVersion)
    {
        return $this->isUpdatingTo('3.0');
    }

    public function update()
    {
        Site::all()->each(function ($site) {
            $set = GlobalSet::findByHandle('browser_appearance')->in($site->handle);

            $appleTouchIcon = $set->get('apple_touch_icon');
            if ($appleTouchIcon) {
                $set->set('override_180', $appleTouchIcon);
                $set->remove('apple_touch_icon');
            }

            $androidChrome = $set->get('android_chrome');
            if ($androidChrome) {
                $set->set('override_512', $androidChrome);
                $set->remove('android_chrome');
            }

            $iOSColor = $set->get('ios_color');
            if ($iOSColor) {
                $set->set('background', $iOSColor);
                $set->remove('ios_color');
            }

            $set->save();
        });

        $blueprint = Blueprint::find('globals.browser_appearance');
        $contents = $blueprint->contents();
        unset($contents['tabs']['general']['sections'][3]);
        unset($contents['tabs']['general']['sections'][2]);
        $contents['tabs']['general']['sections'] = array_values($contents['tabs']['general']['sections']);
        $blueprint->setContents($contents);
        $blueprint->save();

        $this->console()->info('Browser Appearance globals updated succesfully.');
    }
}
