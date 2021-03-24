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
    <div class="medium-12 cell">
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