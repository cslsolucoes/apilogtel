<?php

class Curl {
  

  private $api;
  private $db;

  private function __construct() {
    $core = Core::getInstance();
    $this->api = $core->getConfig('api');
    $this->apiSGP = $core->getConfig('apiSGP');
    $this->db = $core->loadModule('database');
  }

  public static function getInstance() {
      static $inst = null;
      if($inst === null) {
          $inst = new Curl();
      }
      return $inst;
  }

  public function checkToken($token) {
    $query = "SELECT cliente_id FROM adm_token WHERE token = '$token' AND app_id = 2";
    $sql = $this->db->query($query);
    $result = $sql->fetchAll();
    if(count($result) > 0) {
      return true;
    }
    return $result[0]['cliente_id'] ?? NULL;
  }

  public function sendRequest() {
    $_DELETE = array();
    $_PUT = array();
    if (!strcasecmp($_SERVER['REQUEST_METHOD'], 'DELETE')) {
      parse_str(file_get_contents('php://input'), $_DELETE);
    }

    if (!strcasecmp($_SERVER['REQUEST_METHOD'], 'PUT')) {
      parse_str(file_get_contents('php://input'), $_PUT);
    }

    $uri = $_SERVER['REQUEST_URI'];
    $uri = substr($uri, 4);

    if($uri == '') {
      $uri = 'testConnection';
    }

    $masterToken = $this->api['token'];
    $address = "http://{$this->api['ip']}:{$this->api['port']}/" . $uri;
    $address_dest = "http://{$this->api['ip']}:{$this->api['port']}/" . $uri;
    $address_local = "http://{$_SERVER['HTTP_HOST']}/" . $uri;
    $address_dest_array = explode('?', $address_dest);
    $ch = curl_init($address);

    switch($_SERVER['REQUEST_METHOD']) {
      case 'GET':
        $token = $_GET['token'] ?? 1;
        $body = json_encode($_GET);
      break;
      case 'POST':
        $token = $_POST['token'] ?? 1;
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($_POST));
        $body = json_encode($_POST);
      break;
      case 'PUT':
        $token = $_PUT['token'] ?? 1;
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($_PUT));
        $body = json_encode($_PUT);
      break;
      case 'DELETE':
        $token = $_DELETE['token'] ?? 1;
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($_DELETE));
        $body = json_encode($_DELETE);
      break;
    }

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    if($client_id = $this->checkToken($token)) {
      $masterHeader = array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $masterToken
      );
      curl_setopt($ch, CURLOPT_HTTPHEADER, $masterHeader);
      $data = curl_exec($ch);
      curl_close($ch);
      $final_address = $address_dest_array[0] ?? $address_dest;
      $query = "INSERT INTO adm_api_log (cliente_id, uri_origem, uri_destino, body_origem, body_destino, response_origem, response_destino, ip_origem, ip_destino)
      VALUES ('$client_id', '$address_local', '{$final_address}', '$body', '$masterToken', '$data', '$data', '{$_SERVER['SERVER_ADDR']}', '{$_SERVER['REMOTE_ADDR']}')";
      $this->db->query($query);
      if(strpos($data, "<title>Error</title>")) {
        return $data;
        return json_encode(array('msg' => 'Invalid request', 'code' => 200));
      }
      return $data;
    }
    curl_close($ch);
    return json_encode(array('msg' => 'Unauthorized: invalid token', 'code' => 403));
  }

}

?>