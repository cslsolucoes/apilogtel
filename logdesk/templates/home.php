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
  ?>
  <div class="grid-container">
    <div class="grid-x grid-padding-x grid-margin-x">
      <div class="medium-3 cell">
        <div class="pesquisa-cliente">
          <form action="" method="post" onsubmit="return false;" id="search-form" data-toggle="resultado-busca">
            <input type="text" name="cliente" id="cliente" placeholder="Nome, CPF/CNPJ ou ID do cliente..." autocomplete="on">
            <button id="search" data-toggle="resultado-busca" style="display:none;"></button>
          </form>
          <div class="dropdown-pane elevation-4dp" id="resultado-busca" data-dropdown data-hover="false" data-auto-focus="false" data-close-on-click="true">
            <ul class="lista-clientes">
  
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="grid-container">
    <div class="grid-x grid-padding-x grid-margin-x">
      <div class="medium-8 cell">
        <div id="dados-cliente" style="color:white;">
  
        </div>
        <div class="medium-6 cell" id="criar-chamado">
  
        </div>
      </div>
      <div class="medium-4 cell">
        <div id="dados-contrato" style="color:white;">
  
        </div>
        <div id="consumo-internet">
          <div class="card">
            <div class="card-divider"></div>
          </div>
        </div>
      </div>
  
      <div class="medium-12 cell">
        <div id="chamados" style="color:white;">
  
        </div>
      </div>
    </div>
  </div>
  
  <div class="chat-box">
    <div class="chat-head">
      <h6>Detalhes FTTx</h6>
    </div>
    <div class="chat-body">
      <div class="msg-insert"></div>
    </div>
  </div>
  
  <div class="reveal" id="criar-chamado-modal-suporte" data-reveal>
    <form action="index.php" method="post" class="criar-chamado-form">
      <div class="grid-container">
        <div class="grid-x grid-padding-x">
          <div class="medium-12 cell">
            <h1>Novo chamado</h1>
          </div>
          <div class="medium-6 cell">
            <h3>Ocorrência</h3>
            <label>Data de agendamento:
              <input type="datetime-local" name="data_ag" class="data-ag" id="data-ag" value="">
            </label>
            <label>Contrato:
              <input type="text" class="criar-chamado-input-contrato" disabled></input>
              <input type="hidden" value="" id="criar-chamado-input-contrato-hidden" class="criar-chamado-input-contrato-hidden"></input>
            </label>
            <label>Setor:
              <select class="criar-chamado-select-setor" id="setor-ocorrencia">
                <option value="2">Suporte TI - Pessoa Física</option>
                <option value="6">Atendimento</option>
              </select>
            </label>
            <label>Usuário Responsável:
              <select class="criar-chamado-select-responsavel" id="usuario-ocorrencia">
                <option value="<?= $_SESSION['user'] ?>"><?= $_SESSION['username'] ?></option>
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
                <option value="1" selected>Telefone</option>
                <option value="3">Suporte Online</option>
                <option value="4">Pessoa no Local</option>
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
            <label>Conteúdo: <textarea class="criar-chamado-input-conteudo" id="criar-chamado-conteudo" rows="3">Cliente com lentidão na conexão</textarea></label>
            <label>Observações Internas: <textarea class="criar-chamado-input-obs" id="obs-ocorrencia" rows="3">Reiniciado equipamentos</textarea></label>
            <div class="grid-x">
              <div class="medium-4 cell">
                <button class="button primary" id="criar-chamado-contrato-suporte" data-close data-clienteid data-contratoid data-userid="<?= $_SESSION['userid'] ?>">Abir chamado</button>
              </div>
              <div class="medium-3 cell">
                <input type="checkbox" name="criar-os-checkbox" id="criar-os-checkbox">
                <label for="criar-os-checkbox">Criar OS</label>
              </div>
              <div class="medium-5 cell">
                <input type="checkbox" name="protocolo-checkbox" id="protocolo-checkbox">
                <label for="protocolo-checkbox">Anotou protocolo</label>
              </div>
            </div>
            <kbd id="protocolo-ocorrencia"></kbd>
          </div>
          <div class="medium-6 cell">
            <h3>Ordem de Serviço</h3>
            <label>Data de agendamento:
              <input type="datetime-local" name="data_os" class="data-os" id="data-os" value="<?php echo date('Y-m-d\TH:i', strtotime('tomorrow 8am', time())); ?>" disabled>
            </label>
            <label>Setor:
              <select class="criar-os-select-setor" id="criar-os-setor" disabled>
                <option value="4">Área Técnica</option>
                <option value="7">Auditoria</option>
              </select>
            </label>
            <label>Tipo:
              <select class="criar-os-select-tipo" id="criar-os-tipo" disabled>
                <option value="1">Externa</option>
                <option value="0">Interna</option>
              </select>
            </label>
            <label>Prioridade:
              <select class="criar-os-select-prioridade" id="criar-os-prioridade" disabled>
                <option value="2">Normal</option>
                <option value="3">Alta</option>
                <option value="1">Baixa</option>
              </select>
            </label>
            <label>Motivo da OS:
              <select class="criar-os-select-motivoos" id="criar-os-motivoos" disabled>
                <option value="103">CONEXÃO</option>
                <option value="240">LOS LED VERMELHO</option>
                <option value="241">PREVENTIVO FIBERHOME</option>
                <option value="112">RETORNAR</option>
                <option value="110">SEM ATENDIMENTO</option>
                <option value="118">AUDITORIA</option>
                <option value="239">SUPORTE HOME SERVICE</option>
                <option value="117">MUDANÇA DE PONTO</option>
              </select>
            </label>
            <label>Técnico responsável:
              <select class="criar-os-select-tecnico" id="criar-os-tecnico" disabled>
                <option value=""></option>
                <?php
                  $tecnicos = $api->obterListaTecnicos();
                  for ($i = 0; $i < count($tecnicos); $i++) {
                    echo '
                      <option value="' . $tecnicos[$i]['id'] . '">' . $tecnicos[$i]['username'] . '</option>
                    ';
                  }
                ?>
              </select>
            </label>
            <label>Status:
              <select class="criar-os-select-status" id="criar-os-status" disabled>
                <option value="0">Aberta</option>
                <option value="1">Encerrada</option>
                <option value="2">Em execução</option>
                <option value="3">Pendente</option>
              </select>
            </label>
            <label>Problema reportado: <textarea class="criar-os-input-problema" id="criar-os-problema" rows="3" disabled></textarea></label>
          </div>
        </div>
      </div>
    </form>
    <button class="close-button" data-close aria-label="Close modal" type="button">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  
  
  <div class="reveal" id="criar-chamado-modal-protocolo" data-reveal>
    <h1>Criar chamado</h1>
    <form action="index.php" method="post" class="criar-chamado-form">
      <label>Contrato:
        <input type="text" value="" class="criar-chamado-input-contrato" disabled></input>
        <input type="hidden" value="" class="criar-chamado-input-contrato-hidden"></input>
      </label>
      <label>Setor:
        <select class="criar-chamado-select-setor">
          <option value="" selected>Suporte TI - Pessoa Física</option>
          <option value="">Atendimento</option>
        </select>
      </label>
      <label>Usuário Responsável:
        <select class="criar-chamado-select-responsavel">
          <option value="<?= $_SESSION['user'] ?>"><?= $_SESSION['username'] ?></option>
        </select>
      </label>
      <label>Tipo de Ocorrência:
        <select class="criar-chamado-select-tipo">
          <?php
          for ($i = 0; $i < count($tipos); $i++) {
            echo '
                <option value="' . $tipos[$i]['id'] . '"' . ($tipos[$i]['descricao'] == 'PROTOCOLO' ? ' selected' : '') . '>' . $tipos[$i]['descricao'] . '</option>
              ';
          }
          ?>
        </select>
      </label>
      <label>Origem:
        <select class="criar-chamado-select-origem">
          <option value="1" selected>Telefone</option>
          <option value="3">Suporte Online</option>
          <option value="4">Pessoa no Local</option>
          <option value="49">Call Center</option>
        </select>
      </label>
      <label>Status:
        <select class="criar-chamado-select-status">
          <option value="0">Aberta</option>
          <option value="1" selected>Encerrada</option>
          <option value="2">Em execução</option>
          <option value="3">Pendente</option>
        </select>
      </label>
      <label>Conteúdo: <textarea class="criar-chamado-input-conteudo">Cliente entrou em contato para </textarea></label>
      <label>Observações Internas: <textarea class="criar-chamado-input-obs"></textarea></label>
      <button class="button success" id="criar-chamado-contrato-protocolo" data-id>Criar</button>
    </form>
    <button class="close-button" data-close aria-label="Close modal" type="button">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="reveal" id="criar-chamado-modal-boleto" data-reveal>
    <h1>Criar chamado</h1>
    <form action="index.php" method="post" class="criar-chamado-form">
      <label>Contrato:
        <input type="text" value="" class="criar-chamado-input-contrato" name="criar-chamado-input-contrato" disabled></input>
        <input type="hidden" value="" class="criar-chamado-input-contrato-hidden" name="criar-chamado-input-contrato-hidden"></input>
      </label>
      <label>Setor:
        <select class="criar-chamado-select-setor" name="criar-chamado-select-setor">
          <option value="" selected>Suporte TI - Pessoa Física</option>
          <option value="">Atendimento</option>
        </select>
      </label>
      <label>Usuário Responsável:
        <select class="criar-chamado-select-responsavel" name="criar-chamado-select-responsavel">
          <option value="<?= $_SESSION['user'] ?>"><?= $_SESSION['username'] ?></option>
        </select>
      </label>
      <label>Tipo de Ocorrência:
        <select class="criar-chamado-select-tipo" name="criar-chamado-select-tipo">
          <?php
          for ($i = 0; $i < count($tipos); $i++) {
            echo '
                <option value="' . $tipos[$i]['id'] . '"' . ($tipos[$i]['descricao'] == 'ENVIO DE BOLETOS' ? ' selected' : '') . '>' . $tipos[$i]['descricao'] . '</option>
              ';
          }
          ?>
        </select>
      </label>
      <label>Origem:
        <select class="criar-chamado-select-origem" name="criar-chamado-select-origem">
          <option value="1" selected>Telefone</option>
          <option value="3">Suporte Online</option>
          <option value="49">Call Center</option>
          <option value="4">Pessoa no Local</option>
          <option value="2">E-mail</option>
        </select>
      </label>
      <label>Status:
        <select class="criar-chamado-select-status" name="criar-chamado-select-status">
          <option value="0">Aberta</option>
          <option value="1" selected>Encerrada</option>
          <option value="2">Em execução</option>
          <option value="3">Pendente</option>
        </select>
      </label>
      <label>Conteúdo: <textarea class="criar-chamado-input-conteudo">Enviado para o e-mail do cadastro o boleto com vencimento em XX/XX/XXXX.</textarea></label>
      <label>Observações Internas: <textarea class="criar-chamado-input-obs"></textarea></label>
      <button class="button success" id="criar-chamado-contrato-boleto" data-id>Criar</button>
    </form>
    <button class="close-button" data-close aria-label="Close modal" type="button">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <script>
    var baseURL = '<?= $uri ?>';
  </script>
  <script src="<?= $assets ?>/js/app.js"></script>
</body>

</html>