<?php
  $core = Core::getInstance();
  $uri = $core->getConfig('httpHost') . '/' . $core->getConfig('sitePath');
  $assets = $uri . $core->getConfig('assetsFolder');
  $isAdmin = isAdmin($_SESSION['user'] ?? NULL);
  $isSeller = isSeller($_SESSION['username'] ?? NULL);
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
      <div class="medium-12 cell">
        <h1 class="primary-color">Consultar pré-cadastros</h1>
      </div>
    </div>
  </div>
  
  <div class="grid-container">
    <div class="grid-x grid-padding-x grid-margin-x">
      <div class="medium-3 cell">
        <div class="pesquisa-cliente">
          <form action="" method="post" onsubmit="return false;" id="search-form" data-toggle="resultado-busca">
            <label>Vendedor responsável:
              <select class="select-vendedor" id="vendedor">
                <option value=""></option>
                <?php
                  $core = Core::getInstance();
                  $api = $core->loadModule('api');
                  $vendedores = $api->obterListavendedores();
                  for ($i = 0; $i < count($vendedores); $i++) {
                    echo '
                      <option value="' . $vendedores[$i]['id'] . '">' . $vendedores[$i]['username'] . '</option>
                    ';
                  }
                ?>
              </select>
              <label>Data inicial:
                <input type="datetime-local" name="data-inicial">
              </label>
              <label>Data final:
                <input type="datetime-local" name="data-final">
              </label>
            </label>
            <button class="button primary" id="search_precadastros">Buscar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script>
    var baseURL = '<?= $uri ?>';
    var tecnico;
  </script>
  <script src="<?= $assets ?>/js/app.js"></script>
</body>

</html>