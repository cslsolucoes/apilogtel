<?php

$this->get('logtelchip/planos', function ($data) {
  $this->core->loadModule('template')->render('logtelchip', $data);
});