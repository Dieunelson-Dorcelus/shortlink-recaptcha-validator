<?php

namespace fr\dieunelson\webservices;

use Exception;

abstract class RequestValidator {

  private $exception;
  public abstract function validate(Request $req);

  public function getException(){
    return $this->exception;
  }

  public function setException(Exception $exception)
  {
    $this->exception = $exception;
  }
}