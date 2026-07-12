<?php
require __DIR__ . '/../vendor/autoload.php';
// Fix Vercel's read-only filesystem by moving storage to /tmp BEFORE booting Laravel
$storage = '/tmp/storage';
if (!is_dir($storage)) {
    mkdir($storage.'/framework/cache/data', 0777, true);
    mkdir($storage.'/framework/views', 0777, true);
    mkdir($storage.'/framework/sessions', 0777, true);
    mkdir($storage.'/logs', 0777, true);
}
$_ENV['LARAVEL_STORAGE_PATH'] = $storage;
$_SERVER['LARAVEL_STORAGE_PATH'] = $storage;

$app = require_once __DIR__.'/../bootstrap/app.php';

// Handle request
$app->handleRequest(Illuminate\Http\Request::capture());
