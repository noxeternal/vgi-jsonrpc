<?php

class editData extends JSAPI {
  function __construct ($method, $params) {
    parent::__construct($method, $params);
    $this->data = new Data();
  }

  function editCategory ($id, $text) {
    return $this->data->editCategory($id, $text);
  }
}

?>