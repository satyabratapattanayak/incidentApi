<?php
/**
 * File Helpers
 *
 * PHP version > 5.6
 *
 * @category    Helper
 * @package     Helper
 * @author      Satyabrata Pattanayak <satyabrata4you@gmail.com>
 */

/**
 * Send Json formatted data with Headers and Origins
 * 
 * @author satyabrata4you@gmail.com
 * @date 13 Sept
 * @return json
 */
function response($response, $apiResponse)
{
    if (!empty($apiResponse)) {
        return $response->withJson(
            $apiResponse['data'],
            $apiResponse['status'],
            JSON_NUMERIC_CHECK
        );
    }

    return $response->withJson([], 200);
}

/**
 * Get random numbers based on timestamp
 *
 * @author satyabrata4you@gmail.com
 * @date   13 Sept
 * @return A random timestamp based number
 */
function getRandom()
{
    $randomNumber = date('Ymdhis') . rand(99, 9999);
    return $randomNumber;
}

/**
 * Sometimes while printing an array we need to write print_r and pre tags to
 * display it in a readable format. So by using this method, this method will
 * help you to print the array in a better readable format
 *
 * @author satyabrata4you@gmail.com
 * @date   13 Sept
 * @return A readable array
 */
function debug($array, $abort = true)
{
    echo '<pre>';
    print_r($array);
    echo '</pre>';
    if ($abort === true) {
        die("<br>-- End of Debug --");
    }
}

/**
 * Convert any value to integer value
 *
 * @author satyabrata4you@gmail.com
 * @date   13 Sept
 * @return integer or boolean
 */
function to_int($data)
{
    if (!empty($data)) {
        return intval($data);
    }
    return 0;
}

/**
 * Fetch each key from app's config/settings.php file
 *
 * @author satyabrata4you@gmail.com
 * @date   13 Sept
 * @return Array value corresponding to the Array key of settings file
 */
function get_app_settings($settingKey)
{
    if (!empty($settingKey)) {
        $setting = include RELATIVE_PATH . '/config/settings.php';
        return $setting['settings'][$settingKey];
    }
    return false;
}

/**
 * Server Request header for all Server types
 *
 * @author satyabrata4you@gmail.com
 * @date   13 Sept
 * @return json response wheather data is deleted or not
 */
function server_request_headers()
{
    $arrayOfHeader = array();
    $rxHttp = '/\AHTTP_/';
    foreach ($_SERVER as $key => $server) {
        if (preg_match($rxHttp, $key)) {
            $arrayOfHeaderKey = preg_replace($rxHttp, '', $key);
            $rxMatches = array();
            $rxMatches = explode('_', $arrayOfHeaderKey);
            if (count($rxMatches) > 0 and strlen($arrayOfHeaderKey) > 2) {
                foreach ($rxMatches as $akKey => $akVal) {
                    $rxMatches[$akKey] = ucfirst($akVal);
                }

                $arrayOfHeaderKey = implode('-', $rxMatches);
            }
            $arrayOfHeader[$arrayOfHeaderKey] = $server;
        }
    }
    return ($arrayOfHeader);
}

/**
 * - Carbon: The Carbon class is inherited from the PHP DateTime class.
 * - Carbon is used by Eloquent exclusively
 *
 * - For Date and time operations, we use Carbon and this method uses Carbon to
 *   make all such operations Add, Subtract, get Current, yesterday, tomorrow
 *   etc using Carbon
 *
 * @author satyabrata4you@gmail.com
 * @date   13 Sept
 * @return Date String
 */
function date_time($option = 'current', $condition = [], $format = 'string')
{
    $dateReturn = '';
    switch ($option) {
        case 'today':
            $dateReturn = \Carbon\Carbon::now();
            break;
        case 'tomorrow':
            $dateReturn = \Carbon\Carbon::tomorrow();
            break;
        case 'add':
            $dateObj = \Carbon\Carbon::now();
            $dateReturn = $dateObj->addDays($condition['days']);
            break;
        case 'sub':
            $dateObj = \Carbon\Carbon::now();
            $dateReturn = $dateObj->subDays($condition['days']);
            break;
        default:
            //
            break;
    }
    if ($format == 'string') {
        return $dateReturn->toDateTimeString();
    } else if ($format == 'timestamp') {
        return $dateReturn->timestamp;
    }
}
