<?php

$this->get('surftelecom/planos', function ($data) {
  $this->core->loadModule('template')->render('surftelecom/planos', $data);
});