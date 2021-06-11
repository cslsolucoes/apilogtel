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
    $chip = $core->loadModule('surftelecom');
    $operadoras = $chip->consultarOperadorasPortabilidade();
  ?>
  
  
  
  <div class="grid-container">
    <div class="grid-x grid-padding-x grid-margin-x grid-padding-y color-white">
      <div class="medium-12 cell">
        <h3>Consultar operadoras de portabilidade</h3>
        <table class="hover" id="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Operadora</th>
            </tr>
          </thead>
          <tbody>
            <?php if(isset($operadoras->payload)): ?>
              <?php for($i = 0; $i < count($operadoras->payload); $i++): ?>
                <tr>
                  <td><?= $operadoras->payload[$i]->id; ?></td>
                  <td><?= $operadoras->payload[$i]->name; ?></td>
                </tr>
              <?php endfor ?>
            <?php endif ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <script>
    var baseURL = '<?= $uri ?>';
  </script>
  <script src="<?= $assets ?>/js/app.js"></script>
</body>

</html>