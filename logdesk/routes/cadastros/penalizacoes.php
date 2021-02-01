<?php

$this->get('penalizacoes', function ($data) {
  $this->core->loadModule('template')->render('penalizacoes', $data);
});

$this->get('penalizacoes/insert/success', function ($data) {
  $this->core->loadModule('template')->render('penalizacoes', $data, 'insert', 'success');
});

$this->get('penalizacoes/insert/error', function ($data) {
  $this->core->loadModule('template')->render('penalizacoes', $data, 'insert', 'error');
});

$this->get('penalizacoes/edit/success', function ($data) {
  $this->core->loadModule('template')->render('penalizacoes', $data, 'edit', 'success');
});

$this->get('penalizacoes/edit/error', function ($data) {
  $this->core->loadModule('template')->render('penalizacoes', $data, 'edit', 'error');
});

$this->get('penalizacoes/delete/success', function ($data) {
  $this->core->loadModule('template')->render('penalizacoes', $data, 'delete', 'success');
});

$this->get('penalizacoes/delete/error', function ($data) {
  $this->core->loadModule('template')->render('penalizacoes', $data, 'delete', 'error');
});

$this->post('penalizacoes/insert', function ($data) {
  (string)$descricao = '';
  (float)$pontos = 0.00;
  (int)$setor = 0;
  $post = array();
  extract($_POST);

  if($descricao && $tipo) {
    $post = array(
      'descricao' => $descricao,
      'pontos' => $pontos,
      'tipo' => $tipo,
      'setor' => $setor
    );
    $this->core->loadModule('template')->render('penalizacoes', $data, $post, 'insert');
  } else {
    header("Location: insert/error");
  }
});

$this->post('penalizacoes/edit', function ($data) {
  (int)$id = 0;
  (string)$descricao = '';
  (float)$pontos = 0.00;
  (int)$setor = 0;
  $post = array();
  extract($_POST);

  if($id && $descricao && $tipo) {
    $post = array(
      'id' => $id,
      'descricao' => $descricao,
      'pontos' => $pontos,
      'tipo' => $tipo,
      'setor' => $setor
    );
    $this->core->loadModule('template')->render('penalizacoes', $data, $post, 'edit');
  } else {
    header("Location: edit/error");
  }
});

$this->post('penalizacoes/delete', function ($data) {
  (int)$id = 0;
  $post = array();
  extract($_POST);

  if($id) {
    $post = array(
      'id' => $id
    );
    $this->core->loadModule('template')->render('penalizacoes', $data, $post, 'delete');
  } else {
    header("Location: delete/error");
  }
});