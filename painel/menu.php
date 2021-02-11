<div class="title-bar" data-responsive-toggle="menu" data-hide-for="medium">
  <button class="menu-icon" type="button" data-toggle="menu"></button>
  <div class="title-bar-title"></div>
</div>

<div class="top-bar elevation-4dp" id="menu">
  <div class="top-bar-left">
    <ul class="dropdown menu" data-dropdown-menu>
      <li class="menu-text"><a href="" id="menu-principal">LogDesk</a></li>
      <li>
        <a href="">Cadastro</a>
        <ul class="menu vertical">
          <li><a href="<?= $uri ?>pontuacao">Pontuação</a></li>
          <!--
          <li>
            <a href="">Configurações de OS</a>
            <ul class="menu third-menu-ul">
              <li class="third-menu"><a href="<?= $uri ?>tipoequipamento">Tipo de equipamento</a></li>
              <li class="third-menu"><a href="<?= $uri ?>equipamentos">Equipamentos</a></li>
              <li class="third-menu"><a href="<?= $uri ?>testes">Testes</a></li>
              <li class="third-menu"><a href="<?= $uri ?>servicos">Serviços</a></li>
            </ul>
          </li>
          -->
          <li><a href="<?= $uri ?>penalizacoes">Penalizações</a></li>
        </ul>
      </li>
      <li><a href="http://cslsolucoes.com.br/logtel/paineis">Auditoria</a></li>
      <li><a href="http://cslsolucoes.com.br/logtel/paineis">Comissão</a></li>
      <?= ($isAdmin ? "<li><a href='{$uri}logtelchip'>Logtel Chip</a></li>" : "") ?>
      <li><a href='<?= $uri ?>testar_mumo'>Testar MUMO</a></li>
    </ul>
  </div>
  <div class="top-bar-right">
    <ul class="menu">
      <li><a data-tooltip tabindex="1" title="<?= ($isAdmin ? 'Grupo: administradores' : 'Grupo: usuários') ?>" data-position="bottom" data-alignment="center"><?= $_SESSION['userid'] . ' - ' . $_SESSION['user'] ?></a></li>
      <li><a href="<?= $uri ?>logout" class="no-margin no-padding"><button type="button" class="button alert">Sair</button></a>
      </li>
    </ul>
  </div>
</div>

<div class="callout secondary centered loading" id="loading">
  <h3><i style="display: inline-block;" class="fi fi-loop animated"></i> Carregando...</h3>
</div>