<?php

namespace interfaces;

interface getData {
  public function getAll () : array;
  public function getDeleted () : array;
}

?>