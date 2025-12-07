<?php
/**
 * Laravel Front Controller (root version for hPanel)
 * Domain automatically points to this file without /public
 * 
 * Badilisha 'emas' na jina halisi la folder la project yako
 */

// Define Laravel start time
define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader
| for your application. We just need to require it! We'll simply require
| it into the script here so we don't have to worry about it manually.
|
*/
require __DIR__ . '/vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to illuminate PHP development, boot up Laravel, and get it
| ready to handle this request from the web. We'll do that here.
|
*/
$app = require_once __DIR__ . '/bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the response back to the browser.
|
*/
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::capture();
$response = $kernel->handle($request);

// Send the response to the browser
$response->send();

// Terminate the kernel (for any final tasks)
$kernel->terminate($request, $response);

/*
|--------------------------------------------------------------------------
| Optional: Force HTTPS (production)
|--------------------------------------------------------------------------
| Uncomment if your site uses HTTPS and you want all requests redirected
| to https automatically.
*/
// if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'on') {
//     header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
//     exit();
// }
