<?php

class GetData extends JSAPI {
  function __construct ($method, $params) {
    $this->noAuth = ['getAll'];
    parent::__construct($method, $params);
  }

  function getAll () {
    return [
      'categories'  => Data::_getCategories(),
      'consoles'    => Data::_getConsoles(),
      'conditions'  => Data::_getConditions(),
      'styles'      => Data::_getStyles(),
      'games'       => Data::_getItems(),
      'values'      => Data::_getValues(),
      'extras'      => Data::_getExtras()
    ];
  }

}

?>