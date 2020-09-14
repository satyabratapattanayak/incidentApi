<?php
/**
 * Global Configuration for the Application
 *
 * PHP version > 5.6
 *
 * @category  GLobal_Configurations
 * @package   Configuration
 * @author    Satyabrata Pattanayak <spattanayak4you@gmail.com>
 */

$databaseSettings = include RELATIVE_PATH . '/config/database.php';
return [
    'settings' => [
        // set to false in production
        'displayErrorDetails' => true,
        // Allow the web server to send the content-length header
        'addContentLengthHeader' => false, 
        'db' => $databaseSettings,
        // Enable or Disable JWT Authentication
	    'do_load_jwt' => false,
	    'jwt_secret' => "SgUkXp2s5v8y/B?E(H+MbQeThWmYq3t6w9z^C&F)J@NcRfUjXn2r4u7x!A%D*G-K",
	    'show_exception' => true,
    ],
];
