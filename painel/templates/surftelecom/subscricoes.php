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
    if(!$isAdmin) {
      header("Location: $uri");
    }
  ?>
  
  <div class="grid-container">
    <div class="grid-x grid-padding-x grid-margin-x">
      <div class="medium-3 cell">
        <div class="surf-pesquisa-cliente">
          <form action="" method="post" onsubmit="return false;" id="search-form" data-toggle="resultado-busca">
            <input type="text" name="cliente" id="surf-cliente" placeholder="CPF/CNPJ do cliente..." autocomplete="on">
            <button id="search" data-toggle="resultado-busca" style="display:none;"></button>
          </form>
        </div>
      </div>
    </div>
  </div>
  
  <div class="grid-container">
    <div class="grid-x grid-padding-x grid-margin-x">
      <div class="medium-12 cell">
        <div class="surf-dados-cliente">
  
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