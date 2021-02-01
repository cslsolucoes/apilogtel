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
    if(!$isAdmin) {
      header("Location: $uri");
    }
    $chip = $core->loadModule('logtelchip');
    $planosChip = $chip->obterPlanosChip();
  ?>
  
  <div class="grid-container">
    <div class="grid-x grid-padding-x color-white">
      <div class="medium-7 cell">
        <h3>Planos Logtel Chip</h3>
        <table class="hover" id="logtelchip-tableplans">
          <thead>
            <tr>
              <th>ID</th>
              <th>Tipo</th>
              <th>Título</th>
              <th>Subtítulo</th>
              <th>Descrição</th>
              <th>Duração</th>
              <th>Preço</th>
              <th>Custo</th>
              <th>Vantagens</th>
            </tr>
          </thead>
          <tbody>
            <?php for($i = 0; $i < count($planosChip->payload); $i++): ?>
              <tr>
                <td><?= $planosChip->payload[$i]->id; ?></td>
                <td><?= $planosChip->payload[$i]->type; ?></td>
                <td><?= $planosChip->payload[$i]->title; ?></td>
                <td><?= $planosChip->payload[$i]->subtitle; ?></td>
                <td><?= $planosChip->payload[$i]->description; ?></td>
                <td><?= $planosChip->payload[$i]->durationTime; ?></td>
                <td>R$ <?= brazilianNumberFormat($planosChip->payload[$i]->price/100); ?></td>
                <td>R$ <?= brazilianNumberFormat($planosChip->payload[$i]->surfCost/100); ?></td>
                <td>
                  <ul>
                    <?php for($j = 0; $j < count($planosChip->payload[$i]->advantages); $j++): ?>
                      <li> <?= $planosChip->payload[$i]->advantages[$j]->description ?></li>
                    <?php endfor ?>
                  </ul>
                </td>
              </tr>
            <?php endfor ?>
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