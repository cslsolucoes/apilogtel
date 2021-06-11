<?php
  $core = Core::getInstance();
  $uri = $core->getConfig('httpHost') . '/' . $core->getConfig('sitePath');
  $assets = $uri . $core->getConfig('assetsFolder');
  $isAdmin = isAdmin($_SESSION['user'] ?? NULL);
  $isTecnico = isTecnico($_SESSION['username'] ?? NULL);
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
  ?>
  <div class="grid-container">
    <div class="grid-x grid-padding-x grid-margin-x">
      <div class="medium-3 cell">
        <div class="pesquisa-cliente">
          <form action="" method="post" onsubmit="return false;" id="search-form" data-toggle="resultado-busca">
            <input type="text" name="cliente" id="cliente" placeholder="Nome ou CPF/CNPJ do cliente..." autocomplete="off">
            <button id="search" data-toggle="resultado-busca" style="display:none;"></button>
          </form>
          <div class="dropdown-pane" id="resultado-busca" data-dropdown data-hover="false" data-auto-focus="false" data-close-on-click="true">
            <ul class="lista-clientes">
  
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <form action="index.php" method="post" class="criar-chamado-form">
    <div class="grid-container">
      <div class="grid-x grid-padding-x grid-margin-x">
        <div class="medium-12 cell">
          <input type="hidden" name="data_ag" class="data-ag" id="data-ag" value="">
          <label>Contrato:
            <select id="criar-chamado-input-contrato-hidden">
  
            </select>
          </label>
          <label>Setor:
            <select class="criar-chamado-select-setor" id="setor-ocorrencia">
              <option value="2">Suporte TI - Pessoa Física</option>
              <option value="6">Atendimento</option>
            </select>
          </label>
          <label>Tipo de Ocorrência:
            <select class="criar-chamado-select-tipo" id="tipo-ocorrencia">
              <?php
              $core = Core::getInstance();
              $api = $core->loadModule('pontuacao');
              $tipos = $api->obterListaTiposOcorrencia();
              for ($i = 0; $i < count($tipos); $i++) {
                echo '
                    <option value="' . $tipos[$i]['id'] . '"' . ($tipos[$i]['id'] == 234 ? ' selected' : '') . '>' . $tipos[$i]['descricao'] . '</option>
                  ';
              }
              ?>
            </select>
          </label>
          <label>Origem:
            <select class="criar-chamado-select-origem" id="origem-ocorrencia">
              <option value="1">Telefone</option>
              <option value="3">Suporte Online</option>
              <option value="4" selected>Pessoa no Local</option>
              <option value="49">Call Center</option>
            </select>
          </label>
          <label>Status:
            <select class="criar-chamado-select-status" id="criar-chamado-status">
              <option value="0">Aberta</option>
              <option value="1">Encerrada</option>
              <option value="2">Em execução</option>
              <option value="3">Pendente</option>
            </select>
          </label>
          <label>Conteúdo: <textarea class="criar-chamado-input-conteudo" id="criar-chamado-conteudo" rows="3"></textarea></label>
          <label>Observações Internas: <textarea class="criar-chamado-input-obs" id="obs-ocorrencia" rows="3"></textarea></label>
          <div class="grid-x">
            <div class="medium-4 cell">
              <button class="button primary" id="criar-chamado-contrato-suporte" data-close data-clienteid data-contratoid data-userid="<?= $_SESSION['userid'] ?>">Abrir chamado</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <input type="hidden" name="criar-chamado-select-responsavel" value="<?= $_SESSION['user'] ?>">
    <input type="checkbox" id="protocolo-checkbox" value="false" style="display: none">
    <input type="checkbox" id="criar-os-checkbox" value="false" style="display: none">
  </form>
  <script>
    var tecnico = true;
    document.getElementById("resultado-busca").style = "left: 20; width: " + document.getElementById("cliente").offsetWidth + "px;";
  </script>
  <script>
    var baseURL = '<?= $uri ?>';
  </script>
  <script src="<?= $assets ?>/js/app.js"></script>
</body>

</html>