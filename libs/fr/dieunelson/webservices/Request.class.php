<?php

namespace fr\dieunelson\webservices;

class Request{

  private $headers;
  private $url;
  private $params;
  private $data;
  private $type;

  public function __construct($type, $headers, $url, $params, $data)
  {
    $this->headers = $headers;
    $this->url = $url;
    $this->params = $params;
    $this->data = $data;
    $this->type = $type;
  }

  public function getData()
  {
    return $this->data;
  }

  public function getParams()
  {
    return $this->params;
  }

  public function getParam($index)
  {
    return $this->params[$index];
  }

  public function getHeaders()
  {
    return $this->headers;
  }

  public function getUrl()
  {
    return $this->url;
  }

  public function getType()
  {
    return $this->type;
  }
}