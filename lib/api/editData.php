<?php

namespace api;

class editData extends JSAPI implements \interfaces\editData {
  function __construct ($method, $params) {
    parent::__construct($method, $params);
    $this->data = new \Data();
  }

  function saveItem ($item) : void {
    $result = $this->data->editItem($item->ItemId, $item->Name, $item->Link, $item->Console, $item->Category, $item->State, $item->Box, $item->Manual, $item->Style);
    return;
  }

  function saveValue ($itemID, $value) : void {
    $result = $this->data->newValue($itemID, $value);
    return;
  }

  function deleteItem ($id) : void {
    return;
  }

  function editCategory ($id, $text) : void{
    return;
  }
}
