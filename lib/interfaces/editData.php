<?php

namespace interfaces;

interface editData {
  public function saveItem ($item) : bool;
  public function saveValue ($itemID, $value) : bool;
  public function deleteItem ($id) : bool;
}