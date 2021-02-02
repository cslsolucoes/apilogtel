<?php

$this->get('testar_mumo', function ($data) {
  $this->core->loadModule('template')->render('testar_mumo', $data);
});

$this->post('api/v1/mumo', function ($data) {
  $this->core->loadModule('template')->render('mumo', $data);
});