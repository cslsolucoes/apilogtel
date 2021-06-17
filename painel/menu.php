<div class="title-bar" data-responsive-toggle="menu" data-hide-for="medium">
  <button class="menu-icon" type="button" data-toggle="menu"></button>
  <div class="title-bar-title"></div>
</div>

<div class="top-bar elevation-4dp" id="menu">
  <div class="top-bar-left">
    <ul class="dropdown menu" data-dropdown-menu>
      <li class="menu-text"><a id="menu-principal">LogDesk</a></li>
      <?php if($isSeller): ?>
        <li><a href="<?= $uri ?>">Abrir ocorrência</a></li>
        <li><a href="<?= $uri ?>precadastro">Pré-cadastro</a></li>
      <?php endif ?>
      <?php if(!$isSeller): ?>
      <li>
        <a href="">Cadastro</a>
        <ul class="menu vertical">
          <li><a href="<?= $uri ?>pontuacao">Pontuação</a></li>
          <li><a href="<?= $uri ?>penalizacoes">Penalizações</a></li>
        </ul>
      </li>
      <li><a href="http://cslsolucoes.com.br/logtel/paineis">Auditoria</a></li>
      <li><a href="http://cslsolucoes.com.br/logtel/paineis">Comissão</a></li>
      <?php endif ?>
      <?php
        if($isAdmin) {
          echo "
            <li>
              <a>Logtel Chip</a>
              <ul class='menu vertical'>
                <li>
                  <a>Consultas</a>
                  <ul class='menu third-menu-ul'>
                    <li class='third-menu'><a href='" . $uri . "surftelecom/planos'>Consultar planos</a></li>
                    <li class='third-menu'><a href='" . $uri . "surftelecom/clientes'>Consultar clientes</a></li>
                    <li class='third-menu'><a href='" . $uri . "surftelecom/subscricoes'>Consultar subscrições</a></li>
                    <li class='third-menu'><a href='" . $uri . "surftelecom/usuarios'>Consultar usuários</a></li>
                    <li class='third-menu'><a href='" . $uri . "surftelecom/regras_usuario'>Regras de usuário</a></li>
                    <li class='third-menu'><a href='" . $uri . "surftelecom/operadoras_portabilidade'>Operadoras de portabilidade</a></li>
                  </ul>
                </li>
                <li>
                  <a>Cadastros</a>
                  <ul class='menu third-menu-ul'>
                    <li class='third-menu'><a href='" . $uri . "surftelecom/cadastro_cliente'>Cadastrar cliente</a></li>
                    <li class='third-menu'><a href='" . $uri . "surftelecom/cadastro_subscricao'>Cadastrar subscrição</a></li>
                    <li class='third-menu'><a href='" . $uri . "surftelecom/cadastro_usuario'>Cadastrar usuário</a></li>
                    <li class='third-menu'><a href='" . $uri . "surftelecom/portabilidade'>Portabilidade</a></li>
                    <li class='third-menu'><a href='" . $uri . "surftelecom/recarga'>Recarga</a></li>
                  </ul>
                </li>
                <li>
                  <a>Históricos</a>
                  <ul class='menu third-menu-ul'>
                    <li class='third-menu'><a href='" . $uri . "surftelecom/historico_ativacoes'>Ativações</a></li>
                    <li class='third-menu'><a href='" . $uri . "surftelecom/historico_portabilidade'>Portabilidades</a></li>
                    <li class='third-menu'><a href='" . $uri . "surftelecom/historico_recargas'>Recargas</a></li>
                    <li class='third-menu'><a href='" . $uri . "surftelecom/historico_subscricoes'>Subscrições</a></li>
                    <li class='third-menu'><a href='" . $uri . "surftelecom/msisdn'>Relatório MSISDN</a></li>
                  </ul>
                </li>
              </ul>
            </li>
          ";
        }
      ?>
    </ul>
  </div>
  <div class="top-bar-right">
    <ul class="menu">
      <li><a data-tooltip tabindex="1" title="<?= ($isAdmin ? 'Grupo: administradores' : ($isSeller ? 'Grupo: vendedores' : 'Grupo: usuários')) ?>" data-position="bottom" data-alignment="center"><?= $_SESSION['userid'] . ' - ' . $_SESSION['user'] ?></a></li>
      <li><a href="<?= $uri ?>logout" class="no-margin no-padding"><button type="button" class="button alert">Sair</button></a></li>
    </ul>
  </div>
</div>

<div class="callout secondary centered loading" id="loading">
  <h3><i style="display: inline-block;" class="fi fi-loop animated"></i> Carregando...</h3>
</div>