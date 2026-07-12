<?php
require __DIR__ . '/../vendor/autoload.php';
// Fix Vercel's read-only filesystem by moving storage to /tmp BEFORE booting Laravel
$storage = '/tmp/storage';
if (!is_dir($storage)) {
    mkdir($storage.'/framework/cache/data', 0777, true);
    mkdir($storage.'/framework/views', 0777, true);
    mkdir($storage.'/framework/sessions', 0777, true);
    mkdir($storage.'/logs', 0777, true);
    mkdir($storage.'/bootstrap/cache', 0777, true);
}
$_ENV['LARAVEL_STORAGE_PATH'] = $storage;
$_SERVER['LARAVEL_STORAGE_PATH'] = $storage;

$cache = $storage.'/bootstrap/cache';
$_ENV['APP_SERVICES_CACHE'] = $_SERVER['APP_SERVICES_CACHE'] = $cache.'/services.php';
$_ENV['APP_PACKAGES_CACHE'] = $_SERVER['APP_PACKAGES_CACHE'] = $cache.'/packages.php';
$_ENV['APP_CONFIG_CACHE'] = $_SERVER['APP_CONFIG_CACHE'] = $cache.'/config.php';
$_ENV['APP_ROUTES_CACHE'] = $_SERVER['APP_ROUTES_CACHE'] = $cache.'/routes.php';
$_ENV['APP_EVENTS_CACHE'] = $_SERVER['APP_EVENTS_CACHE'] = $cache.'/events.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

// Handle request
$app->handleRequest(Illuminate\Http\Request::capture());
