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
  $pontuacao = $core->loadModule('pontuacao');
  $setores = $pontuacao->obterListaSetores();
  $tipos_ocorrencia = $pontuacao->obterListaTiposOcorrencia();
  $tipos_os = $pontuacao->obterListaTiposOS();
  if (isset($data[0]['id']) && $data[0]['id'] > 0) {
    $pontos = $pontuacao->obterListaPontuacao($data[0]['id']);
  }
  (string)$callout = '';
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($data[1]) && $data[1] && isset($data[2]) && $data[2] && $isAdmin) {
    switch ($data[2]) {
      case 'insert':
        $result = $pontuacao->inserirPontuacao($data[1]);
        if ($result['error']) {
          header("Location: $uri/pontuacao/{$data[1]['setor']}/insert/error");
        } else {
          header("Location: $uri/pontuacao/{$data[1]['setor']}/insert/success");
        }
        break;
  
      case 'edit':
        $result = $pontuacao->editarPontuacao($data[1]);
        if ($result['error']) {
          header("Location: $uri/pontuacao/{$data[1]['setor']}/edit/error");
        } else {
          header("Location: $uri/pontuacao/{$data[1]['setor']}/edit/success");
        }
        break;
  
      case 'delete':
        $result = $pontuacao->deletarPontuacao($data[1]);
        if ($result['error']) {
          header("Location: $uri/pontuacao/{$data[1]['setor']}/delete/error");
        } else {
          header("Location: $uri/pontuacao/{$data[1]['setor']}/delete/success");
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
          $msg = "O registro já existe";
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
  
  <?php include('menu.php'); ?>
  
  <div class="grid-container">
    <div class="grid-x grid-padding-x">
      <div class="medium-4 cell">
        <label>Selecione o setor
          <select name="setor" id="setor">
            <option value=""></option>
            <?php for ($i = 0; $i < count($setores); $i++) : ?>
              <?php if (isset($setores[$i]['id']) && isset($data[0]['id']) && $setores[$i]['id'] == $data[0]['id']) : ?>
                <option value="<?= $setores[$i]['id'] ?>" selected><?= $setores[$i]['nome'] ?></option>
                <?php
                $setorSelecionado = $setores[$i]['nome'];
                $setorSelecionadoId = $setores[$i]['id'];
                ?>
              <?php else : ?>
                <option value="<?= $setores[$i]['id'] ?>"><?= $setores[$i]['nome'] ?></option>
              <?php endif ?>
            <?php endfor ?>
          </select>
        </label>
      </div>
      <?php if (isset($setorSelecionado) && $setorSelecionado && $isAdmin) : ?>
        <div class="medium-2 cell add-button-container">
          <label>
            <button class="button success add-button" data-open="adicionar-pontuacao"><i class="fi fi-plus"></i> Adicionar</button>
          </label>
        </div>
      <?php endif ?>
  
      <?= $callout ?>
  
      <?php if (isset($pontos) && $pontos) : ?>
        <div class="medium-12 cell">
          <!-- pagination control -->
          <nav data-jplist-control="pagination" data-group="group1" data-items-per-page="10" data-current-page="0" data-name="pagination1" data-selected-class="current">
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
                <th class='text-right no-select'>Código</th>
                <th class='no-select'>Tipo</th>
                <th class='text-right no-select'>Ponto</th>
                <th class='no-select'>Ativo</th>
                <th class='no-select'>Tratativa</th>
                <th class='no-select'>Tratativa Nível</th>
                <?php if ($isAdmin): ?>
                <th class="text-center no-select">Editar</th>
                <th class="text-center no-select">Excluir</th>
                <?php endif ?>
              </tr>
            </thead>
            <tbody data-jplist-group="group1">
              <?php for ($i = 0; $i < count($pontos); $i++) : ?>
                <tr data-jplist-item>
                  <td class='text-right'><?= $pontos[$i]['tipo_id'] ?></td>
                  <td><?= $pontos[$i]['descricao'] ?></td>
                  <td class='text-right'><?= number_format($pontos[$i]['ponto'], 3, ",", ".") ?></td>
                  <td><?= ($pontos[$i]['ativo'] ? "Sim" : "Não") ?></td>
                  <td><?= $pontos[$i]['tratativa_nome'] ?></td>
                  <td><?= $pontos[$i]['tratativa_nivel_nome'] ?></td>
                  <?php if ($isAdmin): ?>
                  <td class='text-center'><a data-open="edit-<?= $pontos[$i]['id'] ?>"><i class='fi fi-page-edit h5 primary-color'></a></td>
                  <td class='text-center'><a data-open="delete-<?= $pontos[$i]['id'] ?>"><i class='fi fi-trash h5 alert-color'></a></td>
                  <?php endif ?>
                </tr>
              <?php endfor ?>
            </tbody>
          </table>
        </div>
      <?php endif ?>
    </div>
  
    <?php if (isset($setorSelecionado) && $setorSelecionado && $isAdmin) : ?>
      <?php for ($i = 0; $i < count($pontos); $i++) : ?>
        <div class="reveal" id="edit-<?= $pontos[$i]['id'] ?>" data-reveal>
          <h2>Editar regra de pontuação</h2>
          <form method="POST" class="edit-form" id="edit-form-<?= $pontos[$i]['id'] ?>" action="<?= $uri ?>/pontuacao/edit">
            <div class="grid-container">
              <div class="grid-x grid-padding-x">
                <div class="medium-4 cell">
                  <label>Tratativa Nível
                    <select name="tratativa_nivel" data-id="<?= $pontos[$i]['id'] ?>" class="tratativa_nivel">
                      <option value="O" <?= ($pontos[$i]['tratativa_nivel'] == "O" ? " selected" : "") ?>>Ocorrência</option>
                      <option value="S" <?= ($pontos[$i]['tratativa_nivel'] == "S" ? " selected" : "") ?>>Ordem de Serviço</option>
                    </select>
                  </label>
                </div>
                <div class="medium-7 cell">
                  <label class="tipo_ocorrencia_edit" <?= ($pontos[$i]['tratativa_nivel'] == "O" ? " style='display:block;'" : " style='display:none;'") ?>>Tipo de Ocorrência
                    <select name="tipo_ocorrencia">
                      <?php for ($k = 0; $k < count($tipos_ocorrencia); $k++) : ?>
                        <option value="<?= $tipos_ocorrencia[$k]['id'] ?>" <?= ($tipos_ocorrencia[$k]['id'] == $pontos[$i]['tipo_id'] ? " selected" : "") ?>><?= $tipos_ocorrencia[$k]['descricao'] ?></option>
                      <?php endfor ?>
                    </select>
                  </label>
                  <label class="tipo_os_edit" <?= ($pontos[$i]['tratativa_nivel'] == "S" ? " style='display:block;'" : " style='display:none;'") ?>>Tipo de Ordem de Serviço
                    <select name="tipo_os">
                      <?php for ($k = 0; $k < count($tipos_os); $k++) : ?>
                        <option value="<?= $tipos_os[$k]['id'] ?>" <?= ($tipos_os[$k]['id'] == $pontos[$i]['tipo_id'] ? " selected" : "") ?>><?= $tipos_os[$k]['descricao'] ?></option>
                      <?php endfor ?>
                    </select>
                  </label>
                </div>
                <div class="medium-3 cell">
                  <label>Ativo
                    <select name="ativo" class="ativo">
                      <option value="1" <?= ($pontos[$i]['ativo'] ? " selected" : "") ?>>Sim</option>
                      <option value="0" <?= (!$pontos[$i]['ativo'] ? " selected" : "") ?>>Não</option>
                    </select>
                  </label>
                </div>
                <div class="medium-3 cell">
                  <label>Tratativa
                    <select name="tratativa" class="tratativa">
                      <option value="R" <?= ($pontos[$i]['tratativa'] == "R" ? " selected" : "") ?>>Responsável</option>
                      <option value="C" <?= ($pontos[$i]['tratativa'] == "C" ? " selected" : "") ?>>Criador</option>
                    </select>
                  </label>
                </div>
                <div class="medium-3 cell">
                  <label>Pontos
                    <input type="number" step="0.1" name="pontos" value="<?= $pontos[$i]['ponto'] ?>">
                  </label>
                </div>
                <div class="medium-3 cell add-button-submit-container">
                  <input type="hidden" name="setor" value="<?= $setorSelecionadoId ?>">
                  <input type="hidden" name="id" value="<?= $pontos[$i]['id'] ?>">
                  <button class="button primary add-button-submit">Salvar</button>
                </div>
              </div>
            </div>
          </form>
          <button class="close-button" data-close aria-label="Fechar" type="button">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
  
        <div class="reveal" id="delete-<?= $pontos[$i]['id'] ?>" data-reveal>
          <h3>Tem certeza que deseja deletar este registro?</h3>
          <form method="POST" action="<?= $uri ?>/pontuacao/delete">
            <input type="hidden" name="id" value="<?= $pontos[$i]['id'] ?>">
            <input type="hidden" name="setor" value="<?= $setorSelecionadoId ?>">
            <input type="submit" class="button alert" value="Sim">
            <button class="button secondary" onclick="return false;" data-close>Cancelar</button>
          </form>
  
          <p><i>Não é possível reverter essa alteração.</i></p>
          <button class="close-button" data-close aria-label="Close modal" type="button">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php endfor ?>
  
      <div class="reveal" id="adicionar-pontuacao" data-reveal>
        <h2>Adicionar regra de pontuação</h2>
        <p class="lead">Selecione um tipo de atendimento, seu valor em pontos e as tratativas de como os pontos são
          ganhos para vincular ao setor: <b><?= $setorSelecionado ?></b></p>
        <form method="POST" id="insert-form" action="<?= $uri ?>/pontuacao/insert">
          <div class="grid-container">
            <div class="grid-x grid-padding-x">
              <div class="medium-4 cell">
                <label>Tratativa Nível
                  <select name="tratativa_nivel" class="tratativa_nivel">
                    <option value="O">Ocorrência</option>
                    <option value="S">Ordem de Serviço</option>
                  </select>
                </label>
              </div>
              <div class="medium-7 cell">
                <label class="tipo_ocorrencia">Tipo de Ocorrência
                  <select name="tipo_ocorrencia">
                    <?php for ($i = 0; $i < count($tipos_ocorrencia); $i++) : ?>
                      <option value="<?= $tipos_ocorrencia[$i]['id'] ?>"><?= $tipos_ocorrencia[$i]['descricao'] ?>
                      </option>
                    <?php endfor ?>
                  </select>
                </label>
                <label class="tipo_os">Tipo de Ordem de Serviço
                  <select name="tipo_os">
                    <?php for ($i = 0; $i < count($tipos_os); $i++) : ?>
                      <option value="<?= $tipos_os[$i]['id'] ?>"><?= $tipos_os[$i]['descricao'] ?></option>
                    <?php endfor ?>
                  </select>
                </label>
              </div>
              <div class="medium-4 cell">
                <label>Tratativa
                  <select name="tratativa" class="tratativa">
                    <option value="R">Responsável</option>
                    <option value="C">Criador</option>
                  </select>
                </label>
              </div>
              <div class="medium-3 cell">
                <label>Pontos
                  <input type="number" name="pontos" value="0">
                </label>
              </div>
              <div class="medium-3 cell add-button-submit-container">
                <input type="hidden" name="setor" value="<?= $setorSelecionadoId ?>">
                <button class="button primary add-button-submit">Cadastrar</button>
              </div>
            </div>
          </div>
        </form>
        <button class="close-button" data-close aria-label="Fechar" type="button">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php endif ?>
  <script>
    var baseURL = '<?= $uri ?>';
  </script>
  <script src="<?= $assets ?>/js/app.js"></script>
</body>

</html>