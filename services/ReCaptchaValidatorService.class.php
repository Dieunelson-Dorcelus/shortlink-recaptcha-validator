<?php

namespace fr\dieunelson\webservices;

use Exception;
use fr\dieunelson\webservices\Request;
use fr\dieunelson\webservices\RequestValidator;
use recaptchalib;

class ReCaptchaValidatorService extends RequestValidator{

  private $key;

  public function __construct($key){
    $this->key = $key;
  }

  public function validate(Request $request)
  {
    if(array_key_exists("recaptcha", $_POST)){
      
      switch ($request->getUrl()) {
        case '/generate':
            if(!array_key_exists('link', $request->getData())) return false;
          break;

        case '/verify':
            if(!array_key_exists('short', $request->getData())) return false;
            break;

      }

      $recaptcha = $request->getData()['recaptcha'];
      $reCaptchaLib = new recaptchalib($this->key, $recaptcha);
      
      if($reCaptchaLib->isValid()){
        return true;
      }else{
        $this->setException(new Exception("Recaptcha validation failed", 401));
      }
    }else{
      $this->setException(new Exception("Recaptcha token is empty", 500));
    }
    return false;
  }
}