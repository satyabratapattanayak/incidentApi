<?php
/**
 * While request the api the api must have a Token which will be validated each
 * and every time in this method. if the token will be validated then the server
 * responses with a valid response or else, an error message will be thrown
 *
 * __invoke(): The __invoke() method gets called when the object is called as a
 * function. When you declare it, you say which arguments it should expect
 *
 * PHP version > 5.6
 *
 * @category  Middleware
 * @package   Middleware
 * @author    Satyabrata Pattanayak <spattanayak4you@gmail.com>
 * @copyright 2019-2020
 * @license   http://www.php.net/license/3_0.txt  PHP License 3.0
 */
namespace App\Middlewares;

use \Firebase\JWT\JWT;

/**
 * Validate JWT Token Class
 *
 * @category Middleware
 * @package  Middleware
 * @author   Satyabrata Pattanayak <spattanayak4you@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */
class ValidateJWTToken
{
    /**
     * Check JWT Token
     *
     * @author spattanayak4you@gmail.com
     * @date   12 Sept
     * @return Json
     */
    public function __invoke($request, $response, $next)
    {
        $serverStatusCode = OPERATION_OKAY;
        $jsonResponse = [
            'status' => 0,
            'message' => 'Authentication Token Mismatch',
        ];
        $doAllowJWT = get_app_settings('do_load_jwt');
        $getJWTSecret = get_app_settings('jwt_secret');
        $headers = server_request_headers();
        // Easily turn on/off JWT from config
        if ($doAllowJWT === false) {
            return $next($request, $response);
        }
        if (!empty($headers['TOKEN']) && $doAllowJWT === true) {
            try
            {
                $tokenWithBearer = explode(" ", $headers['TOKEN']);
                $token = (isset($tokenWithBearer[1]) && $tokenWithBearer[1] != "") ? $tokenWithBearer[1] : null;
                $jwtObj = new JWT();
                $jwtObj::$leeway = 5000;
                $jwtObj->decode($token, $getJWTSecret, array('HS256'));
                return $next($request, $response);
            } catch (\Exception $e) {
                if (show_exception() === true) {
                    $jsonResponse += [
                        'exception' => $e->getMessage(),
                    ];
                }
                create_log(
                    'activity', 'warning', 
                    [
                        'message' => 'JWT Token does not match', 
                        'extra' => $jsonResponse
                    ]
                );
            }
        }
        return response(
            $response, ['data' => $jsonResponse, 'status' => $serverStatusCode]
        );
    }
}
