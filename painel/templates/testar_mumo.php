<?php
include('menu.php');
?>
<div class="grid-container">
  <form action="" method="post" onsubmit="return false;" id="search-form">
    <div class="grid-x grid-padding-x grid-margin-x">
      <div class="medium-3 cell">
        <div class="pesquisa-cliente-mumo">
          <input type="text" name="cliente-mumo" id="cliente-mumo" placeholder="Celular do cliente MUMO" autocomplete="on">
        </div>
      </div>
      <div class="medium-2 cell">
        <div class="pesquisa-cliente-mumo">
          <button id="buscar-cliente-mumo" class="button success">Buscar</button>
        </div>
      </div>
    </div>
  </form>
</div>

<div class="grid-container">
  <div class="grid-x grid-padding-x grid-margin-x">
    <div class="medium-6 cell">
      <div id="resultado-pesquisa-cliente-mumo">

      </div>
    </div>
  </div>
</div>