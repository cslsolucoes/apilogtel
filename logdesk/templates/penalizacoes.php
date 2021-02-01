<?php
  $core = Core::getInstance();
  $uri = $core->getConfig('httpHost') . '/' . $core->getConfig('sitePath');
  $assets = $uri . $core->getConfig('assetsFolder');
  $isAdmin = isAdmin($_SESSION['user'] ?? NULL);
?>
<!doctype html>
<html class="no-js" lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LogDesk</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= $assets ?>/css/app.css">
</head>

<body>
  <?php
  include('menu.php');
  $penalizacoes = $core->loadModule('penalizacoes');
  $listaPenalizacoes = $penalizacoes->obterListaPenalizacoes();
  $listaSetores = $penalizacoes->obterListaSetores();
  (string)$callout = '';
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($data[1]) && $data[1] && isset($data[2]) && $data[2] && $isAdmin) {
    switch ($data[2]) {
      case 'insert':
        $result = $penalizacoes->inserirPenalizacao($data[1]);
        if ($result['error']) {
          header("Location: $uri/penalizacoes/insert/error");
        } else {
          header("Location: $uri/penalizacoes/insert/success");
        }
        break;
  
      case 'edit':
        $result = $penalizacoes->editarPenalizacao($data[1]);
        if ($result['error']) {
          header("Location: $uri/penalizacoes/edit/error");
        } else {
          header("Location: $uri/penalizacoes/edit/success");
        }
        break;
  
      case 'delete':
        $result = $penalizacoes->deletarPenalizacao($data[1]);
        if ($result['error']) {
          header("Location: $uri/penalizacoes/delete/error");
        } else {
          header("Location: $uri/penalizacoes/delete/success");
        }
        break;
    }
    exit();
  }
  
  if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($data[1]) && isset($data[2]) && $isAdmin) {
    if ($data[2] == 'success') {
      $color = "success";
    } else if ($data[2] == 'error') {
      $color = "alert";
    }
    switch ($data[1]) {
      case 'insert':
        if ($data[2] == 'success') {
          $msg = "Registro inserido com sucesso";
        } else if ($data[2] == 'error') {
          $msg = "Falha ao inserir registro";
        }
        break;
      case 'edit':
        if ($data[2] == 'success') {
          $msg = "Registro editado com sucesso";
        } else if ($data[2] == 'error') {
          $msg = "Falha ao editar registro";
        }
        break;
      case 'delete':
        if ($data[2] == 'success') {
          $msg = "Registro deletado com sucesso";
        } else if ($data[2] == 'error') {
          $msg = "Falha ao deletar registro";
        }
        break;
    }
    $callout = '
      <div class="medium-4 cell">
        <div class="callout return-msg small ' . $color . '" data-closable>
          <h5><i class="fi fi-check color-' . $color . '"></i> ' . $msg . '.</h5>
          <button class="close-button small" aria-label="Fechar mensagem" type="button" data-close>
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
    ';
  }
  ?>
  
  <div class="grid-container">
    <div class="grid-x grid-padding-x">
      <div class="medium-4 cell">
        <?php if ($isAdmin) : ?>
          <div class="add-button-container-without-label">
            <label>
              <button class="button success add-button" data-open="adicionar-penalizacao"><i class="fi fi-plus"></i> Adicionar</button>
            </label>
          </div>
        <?php endif ?>
      </div>
      <?= $callout ?>
      <div class="medium-12 cell">
        <!-- pagination control -->
        <nav data-jplist-control="pagination" data-group="group1" data-items-per-page="25" data-current-page="0" data-name="pagination1" data-selected-class="current">
          <ul class="pagination">
            <li class="pagination-previous" data-type="prev"><a href="">Anterior</a></li>
            <li data-type="pages">
              <a data-type="page" style="display: inline">{pageNumber}</a>
            </li>
            <li class="pagination-next" data-type="next"><a href="">Próxima</a></li>
          </ul>
        </nav>
        <table class="hover" id="tabela">
          <thead>
            <tr>
              <th class="text-right no-select">Código</th>
              <th class="no-select">Tipo</th>
              <th class="no-select">Descrição</th>
              <th class="text-right no-select">Pontos</th>
              <th class="no-select">Setor</th>
              <?php if ($isAdmin) : ?>
                <th class="text-center no-select">Editar</th>
                <th class="text-center no-select">Excluir</th>
              <?php endif ?>
            </tr>
          </thead>
          <tbody class="elevation-4dp" data-jplist-group="group1">
            <?php for ($i = 0; $i < count($listaPenalizacoes); $i++) : ?>
              <tr data-jplist-item>
                <td class='text-right'><?= $listaPenalizacoes[$i]['id'] ?></td>
                <td><?= ($listaPenalizacoes[$i]['tipo'] == "O" ? "Operacional" : "Administrativo") ?></td>
                <td><?= $listaPenalizacoes[$i]['descricao'] ?></td>
                <td class='text-right'><?= number_format($listaPenalizacoes[$i]['ponto'], 3, ",", ".") ?></td>
                <td><?= $listaPenalizacoes[$i]['nome'] ?></td>
                <?php if ($isAdmin) : ?>
                  <td class='text-center'><a data-open="edit-<?= $listaPenalizacoes[$i]['id'] ?>"><i class='fi fi-page-edit h5 primary-color'></a></td>
                  <td class='text-center'><a data-open="delete-<?= $listaPenalizacoes[$i]['id'] ?>"><i class='fi fi-trash h5 alert-color'></a></td>
                <?php endif ?>
              </tr>
            <?php endfor ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  
  <?php if ($isAdmin) : ?>
    <div class="reveal" id="adicionar-penalizacao" data-reveal>
      <h2>Adicionar penalizaçao</h2>
      <form method="POST" class="insert-form" id="form-adicionar-penalizacao" action="<?= $uri ?>/penalizacoes/insert">
        <div class="grid-container">
          <div class="grid-x grid-padding-x">
            <div class="medium-9 cell">
              <label>Descrição
                <input type="text" name="descricao" value="">
              </label>
            </div>
            <div class="medium-3 cell">
              <label>Pontos
                <input type="number" step="0.1" name="pontos" value="0">
              </label>
            </div>
            <div class="medium-6 cell">
              <label>Setor
                <select name="setor">
                  <?php for ($k = 0; $k < count($listaSetores); $k++) : ?>
                    <option value="<?= $listaSetores[$k]['id'] ?>"><?= $listaSetores[$k]['nome'] ?></option>
                  <?php endfor ?>
                </select>
              </label>
            </div>
            <div class="medium-6 cell">
              <label>Tipo
                <select name="tipo">
                  <option value="O">Operacional</option>
                  <option value="A">Administrativo</option>
                </select>
              </label>
            </div>
            <div class="medium-3 cell">
              <input type="submit" class="button success" value="Adicionar">
            </div>
          </div>
        </div>
      </form>
      <button class="close-button" data-close aria-label="Fechar" type="button">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  
    <?php for ($i = 0; $i < count($listaPenalizacoes); $i++) : ?>
      <div class="reveal" id="edit-<?= $listaPenalizacoes[$i]['id'] ?>" data-reveal>
        <h2>Editar penalizaçao</h2>
        <form method="POST" class="edit-form" id="edit-form-<?= $listaPenalizacoes[$i]['id'] ?>" action="<?= $uri ?>/penalizacoes/edit">
          <div class="grid-container">
            <div class="grid-x grid-padding-x">
              <div class="medium-9 cell">
                <label>Descrição
                  <input type="text" name="descricao" value="<?= $listaPenalizacoes[$i]['descricao'] ?>">
                </label>
              </div>
              <div class="medium-3 cell">
                <label>Pontos
                  <input type="number" step="0.1" name="pontos" value="<?= $listaPenalizacoes[$i]['ponto'] ?>">
                </label>
              </div>
              <div class="medium-6 cell">
                <label>Setor
                  <select name="setor">
                    <option value="0">Todos</option>
                    <?php for ($k = 0; $k < count($listaSetores); $k++) : ?>
                      <option value="<?= $listaSetores[$k]['id'] ?>" <?= ($listaPenalizacoes[$i]['grupo_id'] == $listaSetores[$k]['id'] ? " selected" : "") ?>><?= $listaSetores[$k]['nome'] ?></option>
                    <?php endfor ?>
                  </select>
                </label>
              </div>
              <div class="medium-6 cell">
                <label>Tipo
                  <select name="tipo">
                    <option value="O" <?= ($listaPenalizacoes[$i]['tipo'] == 'O' ? " selected" : "") ?>>Operacional</option>
                    <option value="A" <?= ($listaPenalizacoes[$i]['tipo'] == 'A' ? " selected" : "") ?>>Administrativo</option>
                  </select>
                </label>
              </div>
              <div class="medium-3 cell">
                <input type="hidden" name="id" value="<?= $listaPenalizacoes[$i]['id'] ?>">
                <input type="submit" class="button success" value="Salvar">
              </div>
            </div>
          </div>
        </form>
      </div>
  
      <div class="reveal" id="delete-<?= $listaPenalizacoes[$i]['id'] ?>" data-reveal>
        <h3>Tem certeza que deseja deletar este registro?</h3>
        <form method="POST" action="<?= $uri ?>/penalizacoes/delete">
          <input type="hidden" name="id" value="<?= $listaPenalizacoes[$i]['id'] ?>">
          <input type="submit" class="button alert" value="Sim">
          <button class="button secondary" onclick="return false;" data-close>Cancelar</button>
        </form>
  
        <p><i>Não é possível reverter essa alteração.</i></p>
        <button class="close-button" data-close aria-label="Close modal" type="button">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php endfor ?>
  <?php endif ?>
  <script>
    var baseURL = '<?= $uri ?>';
  </script>
  <script src="<?= $assets ?>/js/app.js"></script>
</body>

</html>