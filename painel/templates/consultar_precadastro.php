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
  $core = Core::getInstance();
  $api = $core->loadModule('api');
  if(isset($_POST['vendedor']) && $_POST['vendedor'] && isset($_POST['dt-inicial']) && $_POST['dt-inicial'] && isset($_POST['dt-final']) && $_POST['dt-final']) {
    $precadastros = $api->consultarPrecadastro(array('vendedor' => $_POST['vendedor'], 'dt-inicial' => $_POST['dt-inicial'], 'dt-final' => $_POST['dt-final']));
  }
  
  
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
          <form action="" method="post" id="search-form" data-toggle="resultado-busca">
            <label>Vendedor responsável:
              <select class="select-vendedor" name="vendedor" id="vendedor">
                <?php
                  $vendedores = $api->obterListavendedores();
                  for ($i = 0; $i < count($vendedores); $i++) {
                    if($vendedores[$i]['id'] == $_SESSION['userid'])
                    echo '
                      <option value="' . $vendedores[$i]['id'] . '">' . $vendedores[$i]['username'] . '</option>
                    ';
                  }
                ?>
              </select>
              <label>Data inicial:
                <input type="datetime-local" name="dt-inicial">
              </label>
              <label>Data final:
                <input type="datetime-local" name="dt-final">
              </label>
            </label>
            <button class="button primary" id="search_precadastros">Buscar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  
  <?php if(isset($precadastros) && count($precadastros) > 0): ?>
  <table>
    <thead>
      <tr>
        <th>Status</th>
        <th>Data Cadastro</th>
        <th>Login</th>
        <th>Motivo</th>
      </tr>
    </thead>
    <tbody>
  <?php foreach ($precadastros as $row): ?>
      <tr>
      <td><?= $row['nome'] ?></td>
        <?php
          switch ($row['status']) {
                case 1: echo '<td>Em análise</td>'; break;
                case 2: echo '<td>Aprovado</td>'; break;
                case 3: echo '<td>Reprovado</td>'; break;
                case 4: echo '<td>Aguardando Contato</td>'; break;
                case 5: echo '<td>Tentando Contato</td>'; break;
                case 6: echo '<td>Contrato realizado no SGP</td>'; break;
                case 7: echo '<td>Inviabilidade Técnica</td>'; break;
              }
        ?>
        <td><?= date('d/m/Y', strtotime($row['data_cadastro'])) ?></td>
        <td><?= $row['motivo'] ?></td>
      </tr>
  <?php endforeach; ?>
    </tbody>
  </table>
  <?php endif; ?>
  <script>
    var baseURL = '<?= $uri ?>';
    var tecnico;
  </script>
  <script src="<?= $assets ?>/js/app.js"></script>
</body>

</html>