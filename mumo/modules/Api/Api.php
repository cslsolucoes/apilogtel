<?php
class Api {
  private function __construct() {
    $this->db = Core::getInstance()->loadModule('database');
    $this->validator = Core::getInstance()->loadModule('validacpfcnpj');
  }

  public static function getInstance() {
      static $inst = null;
      if($inst === null) {
          $inst = new Api();
      }
      return $inst;
  }

  public function checkToken($token) {
    $query = "SELECT cliente_id FROM adm_token WHERE token = '$token'";
    $sql = $this->db->queryLocal($query);
    $result = $sql->fetchAll();
    if(count($result) > 0) {
      return $result[0]['cliente_id'];
    } else {
      return false;
    }
  }

  public function checkUser($user, $token, $body) {
    $user = preg_replace('/[^0-9]/', '', $user);
    $cliente_id = $this->checkToken($token);
    $id = 'NULL';
    if($cliente_id) {
      $qry = "
        SELECT * FROM \"dbsgp\".\"public\".\"funcaoValidaMumo\"('$user')
      ";
      $sql = $this->db->queryErp($qry);
      $result = $sql->fetchAll();
      $id = $result[0]['cliente_id'] ?? 'NULL';
      $cpf = $result[0]['cpf'] ?? 'NULL';
      $uri = $_SERVER['REQUEST_URI'];
      $uri = substr($uri, 1);
      $address_local = "http://{$_SERVER['HTTP_HOST']}/" . $uri;
      $body = json_encode($body);
      if($id != 'NULL') {
        $response = array(
          'msg' => 'success',
          'error' => 'false',
          'user' => $user,
          'cpf' => $cpf,
          'statusCode' => 200
        );
        $response = json_encode($response);
        echo $response . '';
        $query = "
          INSERT INTO adm_api_log (cliente_id, uri_origem, uri_destino, body_origem, body_destino, response_origem, response_destino, ip_origem, ip_destino)
          VALUES ($id, '$address_local', '', '$body', '', '$response', '', '{$_SERVER['SERVER_ADDR']}', '{$_SERVER['REMOTE_ADDR']}')
        ";
        $this->db->queryLocal($query);
        exit;
      } else {
        $id = $user;
        $response = array(
          'msg' => 'user not provided and/or is incorrect',
          'error' => '10002',
          'user' => $id,
          'cpf' => '',
          'statusCode' => 403
        );
        echo json_encode($response);
        exit;
      }
      $return = $result[0]['mensagem'] == 'False' ? false : true;
    } else {
      $response = array(
        'msg' => 'user not provided and/or is incorrect',
        'error' => '10001',
        'user' => $user,
        'cpf' => '',
        'statusCode' => 403
      );
    }
    $response = json_encode($response);
    var_dump($body);
    var_dump($id);
    var_dump($_SERVER['SERVER_ADDR']);
    $query = "
      INSERT INTO adm_api_log (cliente_id, uri_origem, uri_destino, body_origem, body_destino, response_origem, response_destino, ip_origem, ip_destino)
      VALUES ($id, '', '', '$body', '', '$response', '', '{$_SERVER['SERVER_ADDR']}', '{$_SERVER['REMOTE_ADDR']}')
    ";
    $this->db->queryLocal($query);
    return $return ?? false;
  }

  public function consultarCliente($busca, $tipo = "todos") {
    if(is_numeric($busca) && (strlen($busca) == 11 || strlen($busca) == 14)) {
      $busca = $this->validator->formata($busca);
    }
    if($tipo == "internet") {
      $qry = "
        SELECT * FROM \"dbsgp\".\"public\".\"ConsultaCliente\"('%{$busca}%')
        WHERE servico_internet_id IS NOT NULL
        ORDER BY nome ASC LIMIT 10
      ";
    } else {
      $qry = "
        SELECT * FROM \"dbsgp\".\"public\".\"ConsultaCliente\"('%{$busca}%')
        ORDER BY nome ASC LIMIT 10
      ";
    }
    $sql = $this->db->query($qry);
    return $sql->fetchAll();
  }

  public function consultarOcorrencias($contrato) {
    $qry = "
      SELECT * FROM \"dbsgp\".\"public\".\"SuporteOcorrencias\"
      WHERE clientecontrato_id = $contrato
      ORDER BY data_cadastro DESC LIMIT 20
    ";
    $sql = $this->db->query($qry);
    return $sql->fetchAll();
  }

  public function cadastrarVenda($dados) {
    $nome = $dados['nome'] ?? "Não informado";
    if(!isset($dados['telefone'])) {
      echo "
      <script type='text/javascript'>
        alert('Sua solicitação foi enviada com sucesso!');
        window.location='http://www.logteltelecom.com.br/site';
      </script>
      ";
      return true;
    }
    $telefone = $dados['telefone'] ?? "Não informado";
    $email = $dados['email'] ?? "Não informado";
    $planoCombo = $dados['plano-combo'] ?? "Não informado";
    if($dados['cep'] == "") {
      $cep = "Não informado";
    } else {
      $cep = $dados['cep'] ?? "Não informado";
    }

    if($dados['logradouro'] == "") {
      $logradouro = "Não informado";
    } else {
      $logradouro = $dados['logradouro'] ?? "Não informado";
    }

    if($dados['bairro'] == "") {
      $bairro = "Não informado";
    } else {
      $bairro = $dados['bairro'] ?? "Não informado";
    }
    
    if($dados['cidade'] == "") {
      $cidade = "Não informado";
    } else {
      $cidade = $dados['cidade'] ?? "Não informado";
    }
    
    if($dados['uf'] == "") {
      $uf = "Não informado";
    } else {
      $uf = $dados['uf'] ?? "Não informado";
    }

    if($dados['numero'] == "") {
      $numero = 0;
    } else {
      $numero = $dados['numero'] ?? 0;
    }
    
    $mensagem = "FORMULÁRIO VIA SITE";
    $mensagem .= "\nNome: ".$nome;
    $mensagem .= "\nE-mail: ".$email;
    $mensagem .= "\nTelefone: ". $telefone;
    $mensagem .= "\nPlano: ". $planoCombo;
    $mensagem .= "\nCEP: ". $cep;
    $mensagem .= "\nLogradouro: ". $logradouro;
    $mensagem .= "\nBairro: ". $bairro;
    $mensagem .= "\nCidade: ". $cidade;
    $mensagem .= "\nUF: ". $uf;
    $mensagem .= "\nNúmero: ". $numero;
    $realIP = file_get_contents("http://ipecho.net/plain");
    $qry = "SELECT * FROM \"OcorrenciaAbrir\"(0, 115574, 90212, NULL, 55, 14, 272, 1, '$mensagem', '', '$nome', '$telefone', '$realIP')";
    $sql = $this->db->query($qry);
    $resultado = $sql->fetchAll();

    $qry = "SELECT * FROM \"VendasPreCadastroCria\"('$nome', '$telefone', '$email', '$logradouro', '$numero', '$bairro', '$cidade', '$uf', '$cep', '$planoCombo', '$realIP')";
    $sql = $this->db->query($qry);
    $sql->fetchAll();
    echo "
      <script type='text/javascript'>
        alert('Sua solicitação foi enviada com sucesso! Aqui está seu protocolo: " . $resultado[0]['OcorrenciaNumero'] . "');
        window.location='http://www.logteltelecom.com.br/site';
      </script>
    ";
    return true;
  }

  public function getOnuUniqueId($ip, $physAddress, $version = SNMP::VERSION_2c, $collection = "adsl", $walk = "1.3.6.1.4.1.5875.800.3.10.1.1.10") {
    $session = new SNMP($version, $ip, $collection);
    $session->valueretrieval = SNMP_VALUE_PLAIN;
    $session->valueretrieval = SNMP_VALUE_LIBRARY;
    $ifDescr = $session->walk($walk, TRUE, 20000);
    foreach($ifDescr as $i => $n) {
      if(str_replace('"', '', substr($ifDescr[$i], 9)) == $physAddress) {
        return $i;
      }
    }
    return 0;
  }

  public function getOnuTxSignal($ip, $uid, $version = SNMP::VERSION_2c, $collection = "adsl", $walk = "1.3.6.1.4.1.5875.800.3.9.3.3.1.6.") {
    $session = new SNMP($version, $ip, $collection);
    $session->valueretrieval = SNMP_VALUE_PLAIN;
    $session->valueretrieval = SNMP_VALUE_LIBRARY;
    $ifDescr = $session->walk($walk . $uid, TRUE, 20000);
    $key = array_keys($ifDescr) ?? NULL;
    if($key) {
      return substr($ifDescr[$key[0]], 9) / 100;
    }
    return 0;
  }

  public function getOnuTemp($ip, $uid, $version = SNMP::VERSION_2c, $collection = "adsl", $walk = "1.3.6.1.4.1.5875.800.3.9.3.3.1.10.") {
    $session = new SNMP($version, $ip, $collection);
    $session->valueretrieval = SNMP_VALUE_PLAIN;
    $session->valueretrieval = SNMP_VALUE_LIBRARY;
    $ifDescr = $session->walk($walk . $uid, TRUE, 20000);
    $key = array_keys($ifDescr) ?? NULL;
    if($key) {
      return substr($ifDescr[$key[0]], 9) / 100;
    }
    return 0;
  }

  public function getTxRxBandwidth($id, $values) {
    $token = file_get_contents("http://201.87.240.202:8000/accounts/login");
    $pos = strpos($token, "csrfmiddlewaretoken");
    $token = substr($token, $pos + 29);
    $token = substr($token, 0, 63);
    $username = explode('@', trim($values["username"]))[0];
    $password = trim($values["password"]);
    $path = "tmp";
    $url = "http://201.87.240.202:8000/accounts/login/";
    $postinfo = "username=".$username."&password=".$password."&csrfmiddlewaretoken".$token;
    $cookie_file_path = $path."/cookie.txt";
    if (! file_exists($cookie_file_path) || ! is_writable($cookie_file_path)) {
      return "cookie not writable";
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_NOBODY, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file_path);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file_path);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_VERBOSE, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postinfo);
    curl_exec($ch);
    curl_setopt($ch, CURLOPT_URL, "http://201.87.240.202:8000/admin/servicos/internet/$id/queue/info/");
    $html = curl_exec($ch);
    $html = explode(":", $html);
    $download = explode("]", $html[2]);
    $download = substr($download[0], 1);
    $upload = explode("]", $html[4]);
    $upload = substr($upload[0], 1);
    curl_close($ch);
    return json_encode(array('download' => $download, 'upload' => $upload));
  }

  public function getInternetInformation($id, $values) {
    $token = file_get_contents("http://201.87.240.202:8000/accounts/login");
    $pos = strpos($token, "csrfmiddlewaretoken");
    $token = substr($token, $pos + 29);
    $token = substr($token, 0, 63);
    $username = trim($values["username"]);
    $password = trim($values["password"]);
    $path = "tmp";
    $url = "http://201.87.240.202:8000/accounts/login/";
    $postinfo = "username=".$username."&password=".$password."&csrfmiddlewaretoken".$token;
    $cookie_file_path = $path."/cookie.txt";
    if (! file_exists($cookie_file_path) || ! is_writable($cookie_file_path)) {
      echo "cookie not writable";
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_NOBODY, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file_path);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file_path);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_VERBOSE, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postinfo);
    curl_exec($ch);
    curl_setopt($ch, CURLOPT_URL, "http://201.87.240.202:8000/admin/servicos/internet/$id/");
    curl_close($ch);
    return json_encode(explode(":", curl_exec($ch)));
  }
}