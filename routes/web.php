<?php

use Illuminate\Support\Facades\Route;
use Statamic\Facades\Site;
use Statamic\Facades\URL;

Site::all()->each(function (\Statamic\Sites\Site $site) {
    $relativeSiteUrl = URL::makeRelative($site->url());

    // The Manifest route to the manifest.json
    $manifest = Site::all()->count() === 1
        ? 'site.webmanifest'
        : $site->handle() . '/site.webmanifest';

    Route::statamic(URL::tidy($relativeSiteUrl . '/' . $manifest), 'statamic-peak-browser-appearance::manifest/manifest', [
        'layout' => null,
        'content_type' => 'application/json'
    ])->name('manifest.' . $site->handle());
});
