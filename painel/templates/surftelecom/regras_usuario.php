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
    $chip = $core->loadModule('surftelecom');
    $regras = $chip->consultarRegras();
  ?>
  
  
  
  <div class="grid-container">
    <div class="grid-x grid-padding-x grid-margin-x grid-padding-y color-white">
      <div class="medium-12 cell">
        <h3>Consultar regras de usuário</h3>
        <table class="hover" id="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nome</th>
              <th>Permissões</th>
            </tr>
          </thead>
          <tbody>
            <?php if(isset($regras->payload)): ?>
              <?php for($i = 0; $i < count($regras->payload); $i++): ?>
                <tr>
                  <td><?= $regras->payload[$i]->id; ?></td>
                  <td><?= $regras->payload[$i]->name; ?></td>
                  <td><?= implode(", ", $regras->payload[$i]->permissions); ?></td>
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
    var tecnico;
  </script>
  <script src="<?= $assets ?>/js/app.js"></script>
</body>

</html>