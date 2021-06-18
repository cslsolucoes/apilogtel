<?php

class Surftelecom {
  private $db;
  private $urlAuthentication = 'https://www.pagtel.com.br/wholesalesprod/api/v1/token';
  private $urlBase = 'https://www.pagtel.com.br/ispvendas-homologacao/';
  private $login = 'admalogtel@pagtel.com.br';
  private $password = 'logtel@123';
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
        $inst = new Surftelecom();
    }
    return $inst;
  }

  public function consultarPlanos() {
    $headers = array(
      'Content-Type: application/json',
      'Authorization: Bearer ' . $this->bearerToken->access_token
    );
    $ch = curl_init();
    curl_setopt_array($ch, array(
      CURLOPT_URL => $this->urlBase . '/api/v1/plans',
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

  public function consultarCliente($cpfcnpj) {
    $headers = array(
      'Content-Type: application/json',
      'Authorization: Bearer ' . $this->bearerToken->access_token
    );
    $ch = curl_init();
    curl_setopt_array($ch, array(
      CURLOPT_URL => $this->urlBase . '/api/v1/customers/' . $cpfcnpj,
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
    if (curl_errno($ch)) {
      $error_msg = curl_error($ch);
      $response = "{\"access_token\":null,\"error_msg\":\"$error_msg\"}";
    }
    return $response;
  }

  public function consultarSubscricoes($cpfcnpj) {
    $headers = array(
      'Content-Type: application/json',
      'Authorization: Bearer ' . $this->bearerToken->access_token
    );
    $ch = curl_init();
    curl_setopt_array($ch, array(
      CURLOPT_URL => $this->urlBase . '/api/v1/subscriptions?document=' . $cpfcnpj,
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
    if (curl_errno($ch)) {
      $error_msg = curl_error($ch);
      $response = "{\"access_token\":null,\"error_msg\":\"$error_msg\"}";
    }
    return $response;
  }

  public function consultarUsuarios($role = NULL, $regionalId = NULL) {
    $headers = array(
      'Content-Type: application/json',
      'Authorization: Bearer ' . $this->bearerToken->access_token
    );
    $ch = curl_init();
    if($role && $regionalId) {
      $url = '/api/v1/users?role=' . $role . '&regionalId=' . $regionalId;
    } else if($role) {
      $url = '/api/v1/users?role=' . $role;
    } else if($regionalId) {
      $url = '/api/v1/users?regionalId=' . $regionalId;
    } else {
      $url = '/api/v1/users';
    }
    curl_setopt_array($ch, array(
      CURLOPT_URL => $this->urlBase . $url,
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
    if (curl_errno($ch)) {
      $error_msg = curl_error($ch);
      $response = "{\"access_token\":null,\"error_msg\":\"$error_msg\"}";
    }
    return $response;
  }

  public function consultarRegras() {
    $headers = array(
      'Content-Type: application/json',
      'Authorization: Bearer ' . $this->bearerToken->access_token
    );
    $ch = curl_init();
    curl_setopt_array($ch, array(
      CURLOPT_URL => $this->urlBase . '/api/v1/users/roles',
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
    if (curl_errno($ch)) {
      $error_msg = curl_error($ch);
      $response = "{\"access_token\":null,\"error_msg\":\"$error_msg\"}";
    }
    return json_decode($response);
  }

  public function consultarOperadorasPortabilidade() {
    $headers = array(
      'Content-Type: application/json',
      'Authorization: Bearer ' . $this->bearerToken->access_token
    );
    $ch = curl_init();
    curl_setopt_array($ch, array(
      CURLOPT_URL => $this->urlBase . '/api/v1/operators',
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
    if (curl_errno($ch)) {
      $error_msg = curl_error($ch);
      $response = "{\"access_token\":null,\"error_msg\":\"$error_msg\"}";
    }
    return json_decode($response);
  }

  public function cadastrarCliente($data = NULL) {
    $headers = array(
      'Content-Type: application/json',
      'Authorization: Bearer ' . $this->bearerToken->access_token
    );
    $rawBody = array(
      "document" => $data['document'],
      "name" => $data['name'],
      "code" => $data['code'],
      "ddd" => $data['ddd']
    );
    if($data['email']) {
      $rawBody["email"] = $data['email'];
    }
    if($data['phone']) {
      $rawBody["phone"] = $data['phone'];
    }
    $ch = curl_init();
    curl_setopt_array($ch, array(
      CURLOPT_URL => $this->urlBase . '/api/v1/customers',
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
      CURLOPT_POSTFIELDS => json_encode($rawBody)
    ));
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
      $error_msg = curl_error($ch);
      $response = "{\"access_token\":null,\"error_msg\":\"$error_msg\"}";
    }
    if($response == null) {
      $response = array("message" => "Dados incorretos, tente novamente.");
    }
    return json_decode($response);
  }

  public function cadastrarSubscricao($data = NULL) {
    $headers = array(
      'Content-Type: application/json',
      'Authorization: Bearer ' . $this->bearerToken->access_token
    );
    $rawBody = array(
      "customerCode" => (string)$data['customerCode'],
      "subscriptions" => array(array(
        "planId" => $data['planId'],
        "iccid" => $data['iccid'],
        "document" => $data['document'],
        "name" => $data['name'],
        "ddd" => $data['ddd'])
      )
    );
    if($data['ddd']) {
      $rawBody[0]["ddd"] = $data['ddd'];
    }
    if($data['name']) {
      $rawBody[0]["name"] = $data['name'];
    }
    $ch = curl_init();
    curl_setopt_array($ch, array(
      CURLOPT_URL => $this->urlBase . '/api/v1/subscriptions',
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
      CURLOPT_POSTFIELDS => json_encode($rawBody)
    ));
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
      $error_msg = curl_error($ch);
      $response = "{\"access_token\":null,\"error_msg\":\"$error_msg\"}";
    }
    return json_decode($response);
  }

}