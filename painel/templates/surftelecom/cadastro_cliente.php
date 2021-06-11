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
    if(!$isAdmin) {
      header("Location: $uri");
    }
  ?>
  
  <div class="grid-container">
    <div class="grid-x grid-padding-x grid-margin-x">
      <div class="medium-12 cell">
        <h3 class="primary-color">Cadastrar novo cliente</h3>
      </div>
    </div>
  </div>
  
  <form id="surf-form-cadastrar-cliente">
    <div class="grid-container">
      <div class="grid-x grid-padding-x grid-margin-x">
        <div class="medium-2 cell">
          <label>CPF/CNPJ*
            <input type="text" name="document">
          </label>
          <p class="help-text primary-color">Somente números</p>
        </div>
        <div class="medium-4 cell">
          <label>Nome completo*
            <input type="text" name="name">
          </label>
        </div>
      </div>
    </div>
  
    <div class="grid-container">
      <div class="grid-x grid-padding-x grid-margin-x">
        <div class="medium-3 cell">
          <label>Código único*
            <input type="text" name="code">
          </label>
          <p class="help-text primary-color">Deixe em branco para gerar automaticamente</p>
        </div>
        <div class="medium-1 cell">
          <label>DDD*
            <input type="number" min="11" max="99" value="61" name="ddd">
          </label>
        </div>
      </div>
    </div>
  
    <div class="grid-container">
      <div class="grid-x grid-padding-x grid-margin-x">
        <div class="medium-3 cell">
          <label>E-mail*
            <input type="text" name="email">
          </label>
        </div>
        <div class="medium-3 cell">
          <label>Telefone*
            <input type="number" value="" name="phone">
          </label>
          <p class="help-text primary-color">Começando com 55 (sem o +), depois DDD, depois o número</p>
        </div>
      </div>
    </div>
  
    <div class="grid-container">
      <div class="grid-x grid-padding-x grid-margin-x">
        <div class="medium-3 cell">
          <button type="button" id="surf-cadastrar-cliente" class="button primary">Enviar</button>
        </div>
      </div>
    </div>
  </form>
  <script>
    var baseURL = '<?= $uri ?>';
  </script>
  <script src="<?= $assets ?>/js/app.js"></script>
</body>

</html>