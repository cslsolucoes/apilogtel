<?php

$this->get('logtelchip', function ($data) {
  $this->core->loadModule('template')->render('logtelchip', $data);
});