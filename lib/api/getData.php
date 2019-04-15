<?php

class getData extends JSAPI {
  function __construct ($method, $params) {
    $this->noAuth = ['getAll'];
    parent::__construct($method, $params);
  }

  function getAll () {
    $data = new Data();
    return [
      'categories'  => $data->getCategories(),
      'consoles'    => $data->getConsoles(),
      'conditions'  => $data->getConditions(),
      'styles'      => $data->getStyles(),
      'games'       => $data->getItems(),
      'values'      => $data->getValues(),
      'extras'      => $data->getExtras()
    ];
  }

  function getDeleted () {
    $data = new Data();
    return $data->getDeleted();
  }

}

?>