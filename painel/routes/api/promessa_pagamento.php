<?php

$this->post('api/v1/promessa_pagamento', function () {
  if($_POST) {
    $this->core->loadModule('template')->render('promessa_pagamento', $_POST);
  } else {
    $this->core->loadModule('template')->render('404');
  }
});

$this->get('api/v1/promessa_pagamento', function () {
  $this->core->loadModule('template')->render('403');
});