<?php
/**
 * Autoload File
 *
 * PHP version > 5.6
 *
 * @category  Bootstrap
 * @package   Configuration
 * @author    Satyabrata Pattanayak <spattanayak4you@gmail.com>
 */

// Autoload Composer
$composerVendorPath = RELATIVE_PATH . '/vendor/autoload.php';
if (!file_exists($composerVendorPath)) {
    header('HTTP/1.1 503 Service Unavailable.', true, 503);
    echo 'Warning! (You have not installed vendor inside your project directory)';
    exit(1); // EXIT_ERROR
}
$vendor = require $composerVendorPath;

// Instantiate the app
$settings = include RELATIVE_PATH . '/config/settings.php';
$app = new \Slim\App($settings);
$container = $app->getContainer();
// Autoload components of applciation
require RELATIVE_PATH . '/config/autoload.php';

// Configure Eloquent Capsule and run the applciation
$dbSettings = $container->get('settings')['db'];
$capsule = new Illuminate\Database\Capsule\Manager;
$capsule->addConnection($dbSettings);
$capsule->bootEloquent();
$capsule->setAsGlobal();
