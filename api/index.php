<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

// Fix Vercel's read-only filesystem by moving storage to /tmp
$storage = '/tmp/storage';
if (!is_dir($storage)) {
    mkdir($storage.'/framework/cache/data', 0777, true);
    mkdir($storage.'/framework/views', 0777, true);
    mkdir($storage.'/framework/sessions', 0777, true);
    mkdir($storage.'/logs', 0777, true);
}
$app->useStoragePath($storage);

// Handle request
$app->handleRequest(Illuminate\Http\Request::capture());
