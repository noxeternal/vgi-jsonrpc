<?php

class editData extends JSAPI {
  function __construct ($method, $params) {
    parent::__construct($method, $params);
    $this->data = new Data();
  }

  function saveItem ($item) {
    // $this->data->editItem($item['id'], $item['name'], $item['link'], $item['console'], $item['category'], $item['condition'], $item['box'], $item['manual'], $item['style'])
    return $item;
  }

  function deleteItem ($id) {
    return $this->data->deleteItem($id);
  }

  function editCategory ($id, $text) {
    return $this->data->editCategory($id, $text);
  }
}

?>