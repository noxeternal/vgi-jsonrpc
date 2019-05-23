<?php

namespace api;

class editData extends \JSAPI implements \interfaces\editData {
  function __construct ($method, $params) {
    parent::__construct($method, $params);
    $this->data = new \Data();
  }

  function saveItem ($item) : bool {
    $result = $this->data->editItem($item->id, $item->name, $item->link, $item->console, $item->category, $item->condition, $item->box, $item->manual, $item->style);
    return $result;
  }

  function saveValue ($itemID, $value) : bool {
    $result = $this->data->saveValue($itemID, $value);
    return $result;
  }

  function deleteItem ($id) : bool {
    return $this->data->deleteItem($id);
  }

  function editCategory ($id, $text) {
    return $this->data->editCategory($id, $text);
  }
}

?>