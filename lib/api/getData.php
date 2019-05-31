<?php

namespace api;

class getData extends JSAPI implements \interfaces\getData {
  function __construct ($method, $params) {
    $this->noAuth = ['getAll'];
    parent::__construct($method, $params);
  }

  function getAll () :array {
    $data = new \Data();
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

  function getDeleted () : array {
    $data = new \Data();
    return $data->getDeleted();
  }

}
