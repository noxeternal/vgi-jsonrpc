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
      'conditions'  => $data->getStates(),
      'styles'      => $data->getStyles(),
      'games'       => $data->getItems(),
      'values'      => $data->getPriceList()
    ];
  }

  function getDeleted () : array {
    $data = new \Data();
    return $data->getDeleted();
  }

  function getOne ($id) {
    return $data->getPriceList($id);
  }

}
