<?php

interface iEditData {
  function saveItem ($item) : bool;
  function saveValue ($itemID, $value) : bool;
  function deleteItem ($id) : bool;
}