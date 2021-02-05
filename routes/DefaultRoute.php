<?php

use fr\dieunelson\webservices\ReCaptchaValidatorService;
use fr\dieunelson\webservices\Request;
use fr\dieunelson\webservices\Response;
use fr\dieunelson\webservices\Route;
use fr\dieunelson\webservices\shortlink\ShortlinkService;

Route::post("/generate", function (Request $req, Response $res)
{
  
  $service = new ShortlinkService(APP_ORIGIN, PRODUCTION);

  $token = $service->getToken($req);

  $res->sendJson($service->request(API,API_VERSION,'generate', [
    'link' => $req->getData()['link']
  ], $token));

}, new ReCaptchaValidatorService(RECAPTCHA_SECRET));

Route::post("/verify", function (Request $req, Response $res)
{
  
  $service = new ShortlinkService(APP_ORIGIN, PRODUCTION);
  $token = $service->getToken($req);
  $short = explode("/", $req->getData()['short']);
  $code = end($short);

  $res->sendJson($service->request(API,API_VERSION,"verify/$code", null, $token));

}, new ReCaptchaValidatorService(RECAPTCHA_SECRET));