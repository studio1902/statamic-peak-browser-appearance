<?php

use Illuminate\Support\Facades\Route;

// The Manifest route to the manifest.json
Route::statamic('/site.webmanifest', 'statamic-peak-browser-appearance::manifest/manifest', [
    'layout' => null,
    'content_type' => 'application/json'
]);
