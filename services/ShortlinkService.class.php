<?php

namespace fr\dieunelson\webservices\shortlink;

use Exception;
use fr\dieunelson\webservices\Request;

class ShortlinkService{

  private $origin;
  private $protocole;

  public function __construct($origin, $use_https = true){
    $this->origin = $origin;
    if($use_https){
      $this->protocole = "https";
    }else{
      $this->protocole = "http";
    }
  }

  public function getToken(Request $request)
  {
    $headers = $request->getHeaders();
    if (array_key_exists('Authorization', $headers)){
      if (strpos($headers['Authorization'],"Bearer ")!==false) {
        return explode("Bearer ", $headers['Authorization'])[1];
      }
    }
    throw new Exception("Token is empty", 500);
  }

  public function request($api, $version, $url, $data = null, $token = null)
  {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"$this->protocole://$api/$version/$url");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    if(!empty($data)){
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS,$data);  //Post Fields
    }

    $headers = [
      'Accept: application/json',
      'Cache-Control: no-cache',
      "Origin: $this->origin"
    ];

    if(!empty($token)){
      $headers[] = "Authorization: Bearer $token";
    }

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $server_output = curl_exec ($ch);

    curl_close ($ch);

    return json_decode($server_output, true);
  }
    
}