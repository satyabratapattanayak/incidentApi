<?php
/**
 * This Routes holds all the individual route for the Incident Module
 *
 * PHP version > 5.6
 *
 * @category  Incidents
 * @package   Incidents
 * @author    Satyabrata Pattanayak <satyabrata4you@gmail.com>
 */

use App\Modules\Incidents\Controllers\IncidentsController;
use App\Modules\Incidents\Controllers\AuthController;
use App\Middlewares\ValidateJWTToken as ValidateJWT;


// Login Route for Jwt token
$app->group(
    '/login', function () use ($app) {
        $app->post('', AuthController::class . ':login');
    }
);


// Incident Routes List
$app->group(
    '/incident', function () use ($app) {
        $app->get('', IncidentsController::class . ':getIncidents');
        $app->post('', IncidentsController::class . ':saveIncident');
        $app->get('/categories', IncidentsController::class . ':getCategories');
    }
)->add(new ValidateJWT($container));
