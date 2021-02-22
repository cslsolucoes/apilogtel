<?php

$this->get('equipamentos', function ($data) {
  $this->core->loadModule('template')->render('equipamentos', $data);
});

$this->get('servicos', function ($data) {
  $this->core->loadModule('template')->render('servicos', $data);
});

$this->get('testes', function ($data) {
  $this->core->loadModule('template')->render('testes', $data);
});

$this->get('tipoequipamento', function ($data) {
  $this->core->loadModule('template')->render('tipoequipamento', $data);
});

$this->get('pontuacao', function ($data) {
  $this->core->loadModule('template')->render('pontuacao', $data);
});

$this->get('pontuacao/{id}', function ($data) {
  $this->core->loadModule('template')->render('pontuacao', $data);
});

$this->get('pontuacao/{id}/insert/success', function ($data) {
  $this->core->loadModule('template')->render('pontuacao', $data, 'insert', 'success');
});

$this->get('pontuacao/{id}/insert/error', function ($data) {
  $this->core->loadModule('template')->render('pontuacao', $data, 'insert', 'error');
});

$this->post('pontuacao/insert', function ($data) {
  // Initializing variables to avoid errors
  (int)$tipo = null;
  (int)$tipo_ocorrencia = 0;
  (int)$tipo_os = 0;
  (string)$tratativa = '';
  (string)$tratativa_nivel = '';
  (float)$pontos = 0.00;
  (int)$setor = 0;
  $post = array();

  // Extract POST data
  extract($_POST);

  // Verify if everything is ok
  if(($tipo_ocorrencia || $tipo_os) && $tratativa && $tratativa_nivel && $setor) {
    if($tratativa == 'R' || $tratativa == 'C') {
      if($tratativa_nivel == 'O' || $tratativa_nivel == 'S') {
        switch($tratativa_nivel) {
          case 'O': $tipo = $tipo_ocorrencia; break;
          case 'S': $tipo = $tipo_os; break;
        }
        if($tipo > 0 && $setor > 0 && $pontos >= 0) {
          $post = array(
            'tipo' => $tipo,
            'tratativa' => $tratativa,
            'tratativa_nivel' => $tratativa_nivel,
            'pontos' => $pontos,
            'setor' => $setor
          );
        }
      }
    }
  }
  $this->core->loadModule('template')->render('pontuacao', $data, $post, 'insert');
});

$this->get('pontuacao/{id}/edit/success', function ($data) {
  $this->core->loadModule('template')->render('pontuacao', $data, 'edit', 'success');
});

$this->get('pontuacao/{id}/edit/error', function ($data) {
  $this->core->loadModule('template')->render('pontuacao', $data, 'edit', 'error');
});

$this->post('pontuacao/edit', function ($data) {
  // Initializing variables to avoid errors
  (int)$tipo = 0;
  (int)$tipo_ocorrencia = 0;
  (int)$tipo_os = 0;
  (string)$tratativa = '';
  (string)$tratativa_nivel = '';
  (float)$pontos = 0.00;
  (int)$setor = 0;
  (int)$id = null;
  (boolean)$ativo = true;
  $post = array();

  // Extract POST data
  extract($_POST);

  // Verify if everything is ok
  if(($tipo_ocorrencia || $tipo_os) && $tratativa && $tratativa_nivel && $setor && $id) {
    if($tratativa == 'R' || $tratativa == 'C') {
      if($tratativa_nivel == 'O' || $tratativa_nivel == 'S') {
        switch($tratativa_nivel) {
          case 'O': $tipo = $tipo_ocorrencia; break;
          case 'S': $tipo = $tipo_os; break;
        }
        if($tipo > 0 && $setor > 0 && $pontos >= 0) {
          $post = array(
            'tipo' => $tipo,
            'tratativa' => $tratativa,
            'tratativa_nivel' => $tratativa_nivel,
            'pontos' => $pontos,
            'setor' => $setor,
            'ativo' => $ativo,
            'id' => $id
          );
        }
      }
    }
  }
  $this->core->loadModule('template')->render('pontuacao', $data, $post, 'edit');
});

$this->get('pontuacao/{id}/delete/success', function ($data) {
  $this->core->loadModule('template')->render('pontuacao', $data, 'delete', 'success');
});

$this->get('pontuacao/{id}/delete/error', function ($data) {
  $this->core->loadModule('template')->render('pontuacao', $data, 'delete', 'error');
});

$this->post('pontuacao/delete', function ($data) {
  (int)$id = null;
  (int)$setor = 0;
  $post = array();
  extract($_POST);
  if($id > 0) {
    $post = array(
      'id' => $id,
      'setor' => $setor
    );
  }
  $this->core->loadModule('template')->render('pontuacao', $data, $post, 'delete');
});

