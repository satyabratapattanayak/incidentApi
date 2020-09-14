<?php
/**
 * Global Constants for the Application
 *
 * PHP version 5.6
 *
 * @category  Constants
 * @package   Configuration
 * @author    Satyabrata Pattanayak <spattanayak4you@gmail.com>
 */
/*
|--------------------------------------------------------------------------
| Switch between : production or development
|--------------------------------------------------------------------------
|
 */
defined('ENVIRONMENT') or define('ENVIRONMENT', 'development');

/*
|--------------------------------------------------------------------------
| Need to change after Installation process
|--------------------------------------------------------------------------
|
 */
defined('BASE_DIR') or define('BASE_DIR', 'api');
defined('WORKING_DIR') or define('WORKING_DIR', '/' . BASE_DIR . '/');

/*
|--------------------------------------------------------------------------
| Base Site URL. No need to change
|--------------------------------------------------------------------------
 */
$domainUrl = (isset($_SERVER['HTTPS'])
    && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
$domainUrl .= "://" . $_SERVER['HTTP_HOST'];
$baseDir = getcwd();

defined('RELATIVE_PATH') or define('RELATIVE_PATH', $baseDir);

/*
|--------------------------------------------------------------------------
| Directory Separation for different OS
|--------------------------------------------------------------------------
 */
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    // For Windows System configs
    defined('SEPARATOR') or define('SEPARATOR', '\\');
} else {
    // For Linux System configs
    defined('SEPARATOR') or define('SEPARATOR', '/');
}

/*
|--------------------------------------------------------------------------
| HTTP ERROR CODE Mapping Constants
|--------------------------------------------------------------------------
|
| IMPORTANT: You should use correct HTTP codes to the constants or else it will
|            show irrelevant output codes at frontend
 */
defined('AUTH_ERROR') or define('AUTH_ERROR', 401);
defined('OPERATION_OKAY') or define('OPERATION_OKAY', 200);
defined('NO_DATA_FOUND') or define('NO_DATA_FOUND', 200);
defined('MISSING_PARAMETER') or define('MISSING_PARAMETER', 400);
defined('EXCEPTION_OCCURED') or define('EXCEPTION_OCCURED', 500);
defined('DATA_NOT_PROCESSED') or define('DATA_NOT_PROCESSED', 500);
defined('INVALID_FORMAT_REQUESTED') or define('INVALID_FORMAT_REQUESTED', 406);
