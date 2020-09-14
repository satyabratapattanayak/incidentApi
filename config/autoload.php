<?php
/**
 * Autoload File
 *
 * PHP version > 5.6
 *
 * @category  Autoload
 * @package   Configuration
 * @author    Satyabrata Pattanayak <spattanayak4you@gmail.com>
 */
require RELATIVE_PATH . '/app/Helpers/helper.php';

/**
 * Registering all routes
 */
$modules = include RELATIVE_PATH . '/config/modules.php';
foreach ($modules as $module) {
    $routeFilePath = "";
    $routeFilePath = RELATIVE_PATH . '/app/Modules/' . $module . '/index.php';
    if (!empty($routeFilePath) && file_exists($routeFilePath)) {
        include $routeFilePath;
    }
}
//End of registration of routes
