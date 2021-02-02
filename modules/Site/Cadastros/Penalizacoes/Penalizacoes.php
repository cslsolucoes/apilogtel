<?php

class Penalizacoes {
  private $db;

  private function __construct() {
    $this->db = Core::getInstance()->loadModule('database');
  }

  public static function getInstance() {
      static $inst = null;
      if($inst === null) {
          $inst = new Penalizacoes();
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

  public function obterListaPenalizacoes() {
    $sql = $this->db->query('
      SELECT ds.*, st.nome FROM a_ponto_desconto AS ds
      INNER JOIN "dbsgp"."public"."AssistSetor" AS st ON st.id = ds.grupo_id
      ORDER BY ds.id ASC
    ');
    return $sql->fetchAll();
  }

  public function inserirPenalizacao($params) {
    $sql = $this->db->prepare('
      INSERT INTO a_ponto_desconto
        (descricao, ponto, grupo_id, tipo)
        VALUES
        (:descricao, :pontos, :setor, :tipo)
    ');
    $sql->execute($params);
    return array(
      'msg' => 'Registro inserido com sucesso.',
      'error' => false
    );
  }

  public function editarPenalizacao($params) {
    $sql = $this->db->prepare('
      UPDATE a_ponto_desconto
      SET
        descricao = :descricao,
        ponto = :pontos,
        grupo_id = :setor,
        tipo = :tipo
      WHERE
        id = :id
    ');
    $sql->execute($params);
    return array(
      'msg' => 'Registro editado com sucesso.',
      'error' => false
    );
  }

  public function deletarPenalizacao($params) {
    $sql = $this->db->prepare('
      DELETE FROM a_ponto_desconto
      WHERE id = :id
    ');
    $sql->execute($params);
    return array(
      'msg' => 'Registro deletado com sucesso.',
      'error' => false
    );
  }
}