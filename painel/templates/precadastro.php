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
    if(isset($_POST) && isset($_POST['nome']) && isset($_POST['cpfcnpj']) && isset($_POST['telefone'])) {
      if(!$_POST['nome'] || !$_POST['cpfcnpj'] || !$_POST['telefone']) {
        echo "
        <script type='text/javascript'>
          alert('Preencha todos os campos marcados como obrigatório.');
        </script>
        ";
      } else {
        $precadastro = $core->loadModule('api');
        $precadastro = $precadastro->cadastrarVenda($_POST);
      }
    }
      
  ?>
  
  <div class="grid-container">
    <div class="grid-x grid-padding-x grid-margin-x">
      <div class="medium-12 cell">
        <h1 class="primary-color">Pré-cadastro</h1>
      </div>
    </div>
  </div>
  
  <form action="" method="post" class="criar-chamado-form">
    <div class="grid-container">
      <div class="grid-x grid-padding-x grid-margin-x">
        <div class="medium-12 cell">
          <label>CPF/CNPJ*:
            <input type="text" name="cpfcnpj">
          </label>
          <label>Nome*:
            <input type="text" name="nome">
          </label>
          <label>E-mail:
            <input type="text" name="email">
          </label>
          <label>Telefone*:
            <input type="text" name="telefone">
          </label>
          <input type="hidden" name="cep">
          <input type="hidden" name="uf">
          <input type="hidden" name="bairro">
          <input type="hidden" name="logradouro">
          <input type="hidden" name="cidade">
          <input type="hidden" name="numero">
          <div class="grid-x">
            <div class="medium-4 cell">
              <button class="button primary" id="criar-precadastro" data-close data-clienteid data-contratoid data-userid="<?= $_SESSION['userid'] ?>">Enviar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <input type="hidden" name="criar-chamado-select-responsavel" value="<?= $_SESSION['user'] ?>">
    <input type="checkbox" id="protocolo-checkbox" value="false" style="display: none">
    <input type="checkbox" id="criar-os-checkbox" value="false" style="display: none">
  </form>
  <script>
    var tecnico = true;
    document.getElementById("resultado-busca").style = "left: 20; width: " + document.getElementById("cliente").offsetWidth + "px;";
  </script>
  <script>
    var baseURL = '<?= $uri ?>';
    var tecnico;
  </script>
  <script src="<?= $assets ?>/js/app.js"></script>
</body>

</html>