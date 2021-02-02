<?php

class Logtelchip {
  private $db;
  private $urlAuthentication = 'https://www.pagtel.com.br/ispvendas-homologacao/api/v1/token';
  private $urlPlans = 'https://www.pagtel.com.br/ispvendas-homologacao/api/v1/plans';
  private $login = 'andre@logtel.net.br';
  private $password = '5656b94a-562a-4ab6-953f-1d31809fed3f';
  private $bearerToken;

  private function __construct() {
    $this->db = Core::getInstance()->loadModule('database');
    $login = $this->login;
    $password = $this->password;
    $headers = array(
      'Content-Type:application/json',
      'Authorization: Basic '. base64_encode("$login:$password")
    );
    $ch = curl_init();
    curl_setopt_array($ch, array(
      CURLOPT_URL => $this->urlAuthentication,
      CURLOPT_HTTPHEADER => $headers,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_SSL_VERIFYHOST => false,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => 'json',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{"grant_type":"client_credentials"}'
    ));
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
      $error_msg = curl_error($ch);
      $response = "{\"access_token\":null,\"error_msg\":\"$error_msg\"}";
    }
    curl_close($ch);
    $this->bearerToken = json_decode($response);
  }

  public static function getInstance() {
    static $inst = null;
    if($inst === null) {
        $inst = new Logtelchip();
    }
    return $inst;
  }

  public function obterPlanosChip() {
    $headers = array(
      'Content-Type: application/json',
      'Authorization: Bearer ' . $this->bearerToken->access_token
    );
    $ch = curl_init();
    curl_setopt_array($ch, array(
      CURLOPT_URL => $this->urlPlans,
      CURLOPT_HTTPHEADER => $headers,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_SSL_VERIFYHOST => false,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => 'json',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET'
    ));
    $response = curl_exec($ch);
    return json_decode($response);
  }

}