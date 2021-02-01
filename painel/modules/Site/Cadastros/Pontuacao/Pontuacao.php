<?php

class Pontuacao {
  private $db;

  private function __construct() {
    $this->db = Core::getInstance()->loadModule('database');
  }

  public static function getInstance() {
      static $inst = null;
      if($inst === null) {
          $inst = new Pontuacao();
      }
      return $inst;
  }

  public function obterListaSetores() {
    $sql = $this->db->query("
      SELECT st.*, gr.nome AS db FROM admcore_setor AS st
      INNER JOIN a_grupo as gr ON (st.id=gr.setor_id)
      WHERE st.ativo=true AND st.id > 0 AND gr.setor_id > 0 ORDER BY st.seq
    ");
    return $sql->fetchAll();
  }

  public function obterListaPontuacao($setor) {
    $sql = $this->db->query('
      SELECT * FROM "dbsgp"."public"."SuportePontuacao"
      WHERE grupo_id = ' . $setor . ' ORDER BY descricao ASC');
    return $sql->fetchAll();
  }

  public function obterListaTiposOcorrencia() {
    $sql = $this->db->query('
      SELECT id, descricao FROM atendimento_tipo
      WHERE ativo = TRUE
      ORDER BY descricao ASC
    ');
    return $sql->fetchAll();
  }

  public function obterListaTiposOS() {
    $sql = $this->db->query('
      SELECT id, descricao FROM atendimento_motivoos
      ORDER BY descricao ASC
    ');
    return $sql->fetchAll();
  }

  public function obterListaTecnicos() {
    $sql = $this->db->query('
      SELECT id, username
      FROM dbsgp.public.auth_user_tecnica ORDER BY username;
    ');
    return $sql->fetchAll();
  }

  public function inserirPontuacao($params) {
    $sql = $this->db->prepare('
      SELECT ponto FROM a_grupo_ponto
      WHERE tipo_id = :tipo
      AND tratativa = :tratativa
      AND tratativa_nivel = :tratativa_nivel
      AND grupo_id = :grupo_id
    ');
    $checkParams = array(
      'tipo' => $params['tipo'],
      'tratativa' => $params['tratativa'],
      'tratativa_nivel' => $params['tratativa_nivel'],
      'grupo_id' => $params['setor']
    );
    $sql->execute($checkParams);
    $result = $sql->fetchAll();
    if(count($result) > 0) {
      return array(
        'msg' => 'O registro já existe.',
        'error' => true
      );
    }
    $sql = $this->db->prepare('
      INSERT INTO a_grupo_ponto (
          tipo_id,
          tratativa,
          tratativa_nivel,
          ponto,
          grupo_id
      ) VALUES (
        :tipo, :tratativa, :tratativa_nivel, :pontos, :setor
      )
    ');
    $sql->execute($params);
    return array(
      'msg' => 'Registro inserido com sucesso.',
      'error' => false
    );
  }

  public function editarPontuacao($params) {
    $sql = $this->db->prepare('
      UPDATE a_grupo_ponto
      SET tipo_id = :tipo,
          tratativa = :tratativa,
          tratativa_nivel = :tratativa_nivel,
          ponto = :pontos,
          ativo = :ativo,
          grupo_id = :setor
      WHERE id = :id
    ');
    $sql->execute($params);
    return array(
      'msg' => 'Registro editado com sucesso.',
      'error' => false
    );
  }

  public function deletarPontuacao($params) {
    $deleteParams = array('id' => $params['id']);
    $sql = $this->db->prepare('
      DELETE FROM a_grupo_ponto WHERE id = :id
    ');
    $sql->execute($deleteParams);
    return array(
      'msg' => 'Registro deletado com sucesso.',
      'error' => false
    );
  }
}