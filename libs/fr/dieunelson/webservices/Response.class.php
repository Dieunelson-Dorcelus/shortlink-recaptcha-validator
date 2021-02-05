<?php

namespace fr\dieunelson\webservices;


class Response{

  private $content;
  private $code;

  public function __construct() {}

  public function getContent()
  {
    return $this->content;
  }

  public function getCode()
  {
    return $this->code;
  }

  public function setCode(Int $code)
  {
    $this->code = $code;
    return $this;
  }

  public function send($data){

    if (!empty($this->code)) {
      http_response_code($this->code);
    }

    $this->content = $data;
    print $data;
  }

  public function sendJson($data){
    header("Content-Type: application/json");
    $this->send(json_encode($data));
  }
  
}