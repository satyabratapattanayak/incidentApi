<?php
/**
 * Author : Satyabrata Pattanayak/India
 *
 * PHP version 5.6
 * 
 * @date 10 sept
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 * 
 * @category  Framework
 * @package   Microservice_Framework
 * @author    Satyabrata Pattanayak <spattanayak4you@riaxe.com>
 * @copyright 2019-2020 
 */
require __DIR__ . '/config/constants.php';

// Application blocks if the server has PHP version lower than 7.1
if (!version_compare(PHP_VERSION, '5.6', '>=')) {
    header('HTTP/1.1 503 Service Unavailable.', true, 503);
    echo 'Warning: Minimum PHP version 5.6 is required. 
        PHP version 7.2.x will suit best';
    exit(1); // EXIT_ERROR
}

/*
 *---------------------------------------------------------------
 * ERROR REPORTING
 *---------------------------------------------------------------
 *
 * Different environments will require different levels of error reporting.
 * By default development will show errors but testing and live will hide them.
 */
switch (ENVIRONMENT) {
case 'development':
    error_reporting(-1);
    ini_set('display_errors', 1);
    break;

case 'testing':
case 'production':
    // Surpress all error and warnings
    ini_set('display_errors', 0);
    error_reporting(
        E_ALL 
        & ~E_NOTICE 
        & ~E_DEPRECATED 
        & ~E_STRICT 
        & ~E_USER_NOTICE 
        & ~E_USER_DEPRECATED
    );
    break;
default:
    header('HTTP/1.1 503 Service Unavailable.', true, 503);
    echo 'The application environment is not set correctly.';
    exit(1); // EXIT_ERROR
}
 
// Initialize the config file
require __DIR__ . '/config/bootstrap.php';

// Run app
$app->run();
