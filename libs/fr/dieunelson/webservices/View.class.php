<?php

namespace fr\dieunelson\webservices;

use Exception;

class View {

  private $schema;

  public function __construct($path)
  {
    if (file_exists($path)) {
      $this->schema = file_get_contents($path);
    }else{
      throw new Exception("View $path not exist",500);
    }
  }

  public function bind(array $data)
  {
    //  variables
    preg_match_all('/{%([^\s]+)%}/', $this->schema, $matches);

    foreach ($matches[1] as $match){
      if (isset($data[$match])){
        $this->schema = str_replace("{%$match%}",$data[$match], $this->schema);
      }
    }
  }
  public function render()
  {
    $doc = new \DOMDocument();
    @$doc->loadHTML($this->schema);
    return $doc->saveHTML();
  }
}