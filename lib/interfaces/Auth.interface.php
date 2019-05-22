<?php


interface Auth {
  public function login ($username, $password): array;
  public function logout(): bool;
  public function getUser (): stdclass;
}

?>