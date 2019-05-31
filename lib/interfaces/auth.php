<?php

namespace interfaces;

interface auth {
  public function login ($username, $password) : array;
  public function logout (): bool;
  public function getUser (): \User;
}
