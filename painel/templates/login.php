<?php
if (isset($_SESSION['user']) && $_SESSION['user']) {
  header("Location: $uri");
}
?>

<body id="login-page">
  <header>
    <div class="callout no-border bg-custom-primary color-white">
      <div class="grid-container">
        <div class="grid-x grid-padding-x custom-padding">
          <div class="medium-12 cell">
            <h1 class="h1-style"><i class="fi fi-cloud"></i> LogDesk</h1>
            <h4 class="h2-subtitle">Sistema integrador para assistência ao atendimento<h4>
          </div>
        </div>
      </div>
    </div>
  </header>

  <section class="login-form">
    <div class="grid-container">
      <div class="grid-x grid-padding-x align-center">
        <div class="small-12 large-9 medium-8 cell logo">
          <div class="callout no-border no-bg">
            <img src="<?= $assets ?>/img/logo.png" alt="Logtel Internet">
          </div>
        </div>
        <div class="small-12 medium-4 large-3 cell login">
          <div class="callout no-border no-bg">
            <h3>Faça login para entrar no painel</h3>
            <span class="error-msg"></span>
            <form class="form" method="post" action="<?= $uri ?>login">
              <?php if (isset($data[1]['error']) && $data[1]['error']) : ?>
                <p class="error-message h6">
                  <b>
                    <i class="fi fi-alert"></i>
                    <?= $data[1]['msg'] ?>
                  </b>
                </p>
              <?php endif ?>
              <div class="input-group">
                <span class="input-group-label orange-border no-border-right no-bg"><i class="fi fi-torso"></i></span>
                <input type="text" name="login" class="input-group-field no-border-left login no-bg orange-border" placeholder="exemplo@logtel.net.br" maxlength="128">
              </div>
              <div class="input-group">
                <span class="input-group-label orange-border no-border-right no-bg"><i class="fi fi-lock"></i></span>
                <input type="password" name="password" class="input-group-field no-border-left password no-bg password orange-border" placeholder="******" maxlength="256">
              </div>
              <input type="submit" class="button orange-color rounded-border login-submit" value="Entrar">

            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer>
    <div class="callout no-border orange-color no-margin color-white">
      <div class="grid-container">
        <div class="grid-x grid-padding-x custom-padding">
          <div class="medium-12 cell text-center">
            <p><img src="<?= $assets ?>/img/logo-csl.png" alt="CSL Telecom"><br>
              &copy; 2020 - Todos os direitos reservados</p>
          </div>
        </div>
      </div>
    </div>
  </footer>
</body>

</html>