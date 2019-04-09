<?php

class GetData extends JSAPI {
  function __construct ($method, $params) {
    $this->noAuth = ['getAll'];
    parent::__construct($method, $params);
  }

  function getAll () {
    $Data = new Data();
    return [
      'categories'  => $Data->getCategories(),
      'consoles'    => $Data->getConsoles(),
      'conditions'  => $Data->getConditions(),
      'styles'      => $Data->getStyles(),
      'games'       => $Data->getItems(),
      'values'      => $Data->getValues(),
      'extras'      => $Data->getExtras()
    ];
  }

}

?>