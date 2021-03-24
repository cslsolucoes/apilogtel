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
    <form action="" method="post" onsubmit="return false;" id="search-form">
      <div class="grid-x grid-padding-x grid-margin-x">
        <div class="medium-3 cell">
          <div class="pesquisa-cliente-mumo">
            <input type="text" name="cliente-mumo" id="cliente-mumo" placeholder="Celular do cliente MUMO" autocomplete="on">
          </div>
        </div>
        <div class="medium-2 cell">
          <div class="pesquisa-cliente-mumo">
            <button id="buscar-cliente-mumo" class="button success">Buscar</button>
          </div>
        </div>
      </div>
    </form>
  </div>
  
  <div class="grid-container">
    <div class="grid-x grid-padding-x grid-margin-x">
      <div class="medium-6 cell">
        <div id="resultado-pesquisa-cliente-mumo">
  
        </div>
      </div>
    </div>
  </div>
  <script>
    var baseURL = '<?= $uri ?>';
  </script>
  <script src="<?= $assets ?>/js/app.js"></script>
</body>

</html>