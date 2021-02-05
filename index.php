<?php
$ROOT = realpath(dirname(__FILE__));
//  CONFIG
require_once ".env/config.php";

//  LIBS
require_once "libs/_loader.php";

// SERVICES
require_once "services/ShortlinkService.class.php";
require_once "services/ReCaptchaValidatorService.class.php";

//  ROUTES
require_once "routes/DefaultRoute.php";

use fr\dieunelson\webservices\Response;
use fr\dieunelson\webservices\Router;

$router = new Router();
try {
    $router->route(htmlentities($_GET['path']));
} catch (Exception $th) {
    $response = new Response();
    http_response_code($th->getCode());
    $response->sendJson((object)[
        "code" => $th->getCode(),
        "message" => $th->getMessage()
    ]);
}