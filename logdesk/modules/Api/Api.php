<?php
class Api {
  private function __construct() {
    session_write_close();
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

  public function getUserID($user) {
    $qry = 'SELECT id
            FROM "auth_user"
            WHERE username = \'' . $user . '\' LIMIT 1';
    $sql = $this->db->query($qry);
    return $sql->fetchAll();
  }

  public function getUserIDBySession($user) {
      $user = explode("@", $user);
      $userid = $this->getUserID($user[0]);
      $_SESSION['userid'] = $userid[0]['id'];
      return $userid[0]['id'] ?? NULL;
  }

  public function getUsernameByID($user_id) {
      $qry = 'SELECT name
              FROM "auth_user"
              WHERE id = ' . $user_id . ' LIMIT 1';
    $sql = $this->db->query($qry);
    return $sql->fetchAll();
  }

  public function getUserByID($user_id) {
      $qry = 'SELECT username
              FROM "auth_user"
              WHERE id = ' . $user_id . ' LIMIT 1';
    $sql = $this->db->query($qry);
    return $sql->fetchAll();
  }

  public function consultarCliente($busca, $tipo = "todos") {
    if(is_numeric($busca) && (strlen($busca) == 11 || strlen($busca) == 14)) {
      $busca = $this->validator->formata($busca);
    }
    //$busca = str_replace(' ', '%', $busca);
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

  public function consultarUltimaOcorrencia() {
    $qry = "SELECT numero::float+1 AS numero FROM atendimento_ocorrencia ORDER BY id DESC LIMIT 1";
    $sql = $this->db->query($qry);
    return $sql->fetchAll();
  }

  public function criarOcorrencia($dados) {
    $realIP = file_get_contents("http://ipecho.net/plain");
    $dados['conteudo'] = $dados['conteudo'] . ($dados['protocolocheck'] === true ? ' Protocolo anotado pelo cliente.' : ' Protocolo não anotado pelo cliente.');
    $qry = "SELECT * FROM \"funcaoOcorrenciaAbrir\"({$dados['status']}, {$dados['contratoid']}, {$dados['userid']}, {$dados['origem']}, {$dados['setor']}, {$dados['tipo']}, {$dados['userid']}, '{$dados['conteudo']}', '{$dados['obs']}', '', '', '$realIP')";
    $sql = $this->db->query($qry);
    $resultado = $sql->fetchAll();

    if($resultado[0]['OcorrenciaID'] && $dados['dataagendamento']) {
      $dados['dataagendamento'] = date("Y-m-d H:i:s", strtotime($dados['dataagendamento']));
      $dados['conteudo'] = $dados['conteudo'] . ' ';
      unset($qry);
      $qry = "SELECT * FROM \"funcaoOcorrenciaAlterar\"({$resultado[0]['OcorrenciaID']}, {$dados['status']}, {$dados['userid']}, {$dados['userid']}, {$dados['setor']}, {$dados['tipo']}, {$dados['origem']}, '{$dados['dataagendamento']}', '{$dados['conteudo']}', '{$dados['obs']}', '$realIP')";
      $sql = $this->db->query($qry);
    }

    if($dados['oscheck'] && $resultado[0]['OcorrenciaID']) {
      $dados['dataos'] = date("Y-m-d H:i:s", strtotime($dados['dataos']));
      unset($qry);
      $qry = "SELECT * FROM \"funcaoOSAbrir\"({$resultado[0]['OcorrenciaID']}, {$dados['motivoos']}, {$dados['setoros']}, {$dados['userid']}, '{$dados['problemaos']}', '{$dados['dataos']}', '$realIP')";
      $sql = $this->db->query($qry);
    }
    return $resultado;
  }

  public function cadastrarVenda($dados) {
    // "public"."OcorrenciaAbrir"(situacao, contratoid, responsavelid, metodoid, setorid, tipoid, usuarioid, conteudo_texto, observacao_texto)
    //$qry = "SELECT * FROM \"public\".\"OcorrenciaAbrir\"(0, 90212, NULL, 55, 14, 272, NULL, 'conteudo', NULL)";
    
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
    $qry = "SELECT * FROM \"funcaoOcorrenciaAbrir\"(0, 115574, 90212, NULL, 55, 14, 272, 1, '$mensagem', '', '$nome', '$telefone', '$realIP')";
    $sql = $this->db->query($qry);
    $resultado = $sql->fetchAll();

    //$qry = "SELECT * FROM \"VendasPreCadastroCria\"('prenome', 'pretelefone', 'preemail', 'prelogradouro', 'prenumero', 'prebairro', 'precidade', 'preuf', 'precep', 'plano')";
    $qry = "SELECT * FROM \"funcaoVendasPreCadastroCria\"('$nome', '$telefone', '$email', '$logradouro', '$numero', '$bairro', '$cidade', '$uf', '$cep', '$planoCombo', '$realIP')";
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

  
  public function loginERP($values) {
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
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
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
    return curl_exec($ch);
  }

  public function getTxRxBandwidth($id, $values) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_NOBODY, false);
    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_VERBOSE, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_URL, "http://201.87.240.202:8000/admin/servicos/internet/$id/queue/info/");
    $html = curl_exec($ch);
    if(strpos($html, 'id="login-form"')) {
      $this->loginERP($values);
      $this->getTxRxBandwidth($id, $values);
      return 'not logged in';
    }
    $html = explode(":", $html);
    if(!isset($html[2])) {
      return false;
    }
    $download = explode("]", $html[2]);
    $download = substr($download[0], 1);
    $upload = explode("]", $html[4]);
    $upload = substr($upload[0], 1);
    curl_close($ch);
    return json_encode(array('download' => formatBytes($download), 'upload' => formatBytes($upload)));
  }

  public function getInternetStatus($id, $values, $tries = 0) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_NOBODY, false);
    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_VERBOSE, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_URL, "http://201.87.240.202:8000/admin/servicos/internet/$id/infodetail/?statusonly=1");
    $statusHtml = curl_exec($ch);
    curl_setopt($ch, CURLOPT_URL, "http://201.87.240.202:8000/admin/servicos/internet/$id/queue/info/");
    $consumoHtml = curl_exec($ch);
    if(strpos($statusHtml, 'id="login-form"') || strpos($consumoHtml, 'id="login-form"')) {
      $this->loginERP($values);
      if($tries >= 3) {
        return array(
          'statusHtml' => 'Não foi possível obter a informação no momento.',
          'consumoDownload' =>  0,
          'consumoUpload' => 0
        );
      }
      return $this->getInternetStatus($id, $values, $tries + 1);
    }
    if(strpos($statusHtml, 'Online')) {
      $statusConexao = 'Online';
    } else {
      $statusConexao = 'Offline';
    }
    $statusHtml = str_replace("Detalhes: <br/><br/>", "", $statusHtml);
    $statusHtml = str_replace("<br/>\n    <br/>\n    \n\n", "", $statusHtml);
    $consumoHtml = explode(":", $consumoHtml);
    if(isset($consumoHtml[2])) {
      $download = explode("]", $consumoHtml[2]);
      $download = substr($download[0], 1);
      $upload = explode("]", $consumoHtml[4]);
      $upload = substr($upload[0], 1);
    } else {
      $download = 0;
      $upload = 0;
    }
    curl_close($ch);
    return array(
      'statusHtml' => $statusHtml,
      'consumoDownload' =>  formatBytes($download),
      'consumoUpload' => formatBytes($upload),
      'statusConexao' => $statusConexao
    );
  }
}