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
    $usuarios = json_decode($chip->consultarUsuarios($_GET['role'] ?? NULL, $_GET['regionalId'] ?? NULL));
    $regras = $chip->consultarRegras();
  ?>
  
  
  
  <div class="grid-container">
    <div class="grid-x grid-padding-x grid-margin-x grid-padding-y color-white">
      <div class="medium-12 cell">
        <h3>Consultar usuários</h3>
        <div class="grid-x grid-padding-x color-white">
          <div class="medium-4 cell">
            <form action="" method="get" id="search-form">
              <select name="role">
                <option value="" selected>Selecione uma regra...</option>
                <?php for($i = 0; $i < count($regras->payload); $i++): ?>
                  <option value="<?= $regras->payload[$i]->id ?>"><?= $regras->payload[$i]->name ?></option>
                <?php endfor ?>
              </select>
              <input type="text" name="regionalId" placeholder="ID da Regional" autocomplete="on">
              <button class="button primary">Buscar</button>
            </form>
          </div>
        </div>
        <table class="hover" id="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nome</th>
              <th>E-mail</th>
              <th>Criado em</th>
              <th>Tipo</th>
              <th>Regional</th>
            </tr>
          </thead>
          <tbody>
            <?php if(isset($usuarios->payload)): ?>
              <?php for($i = 0; $i < count($usuarios->payload); $i++): ?>
                <tr>
                  <td><?= $usuarios->payload[$i]->id; ?></td>
                  <td><?= $usuarios->payload[$i]->name; ?></td>
                  <td><?= $usuarios->payload[$i]->email; ?></td>
                  <td><?= date('d/m/Y H:i:s', strtotime($usuarios->payload[$i]->createdAt)); ?></td>
                  <td><?= $usuarios->payload[$i]->role->name; ?></td>
                  <td><?= $usuarios->payload[$i]->regional->name ?? NULL; ?></td>
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