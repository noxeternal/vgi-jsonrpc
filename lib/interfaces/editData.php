<?php

namespace interfaces;

interface editData {
  public function saveItem ($item) : int;
  public function saveValue ($itemID, $value) : void;
  public function deleteItem ($id) : void;
}