<?php

class Auth {

  function __construct() {
    $this->db = $GLOBALS['db'];
  }

  function login ($username, $password) {
    $login = $this->db->prepare("SELECT loginID, loginPasswd, loginRole FROM login WHERE loginName = ?");
    $login->bind_param('s', $username);
    $login->bind_result($id, $hash, $role);
    $options = [];
    $valid = false;
    $rehash = false;
    
    $login->execute();
    $login->store_result();
    
    if (!$login->fetch()) throw new Exception('Invalid username or password');
    
    $login->close();
    if (substr($hash, 0, 1) !== '$') {
      $valid = md5($password) === $hash;
      $rehash = $valid;
    } else {
      $valid = password_verify($password, $hash);
      $rehash = $valid && password_needs_rehash($hash, PASSWORD_DEFAULT, $options);
    }
    if ($valid && $rehash) {
      $newHash = password_hash($password, PASSWORD_DEFAULT, $options);
      $loginUp = $this->db->prepare("UPDATE login SET loginPasswd = ? WHERE loginID = ? AND _DELETED IS NULL");
      $loginUp->bind_param('ss', $newHash, $id);
      $loginUp->execute();
    } 
    if ($valid) {
      $auth = new User();
      $auth->valid = $valid;
      $auth->id = $id;
      $auth->user = $username;
      $auth->role = $role;
      $auth->rehash = $rehash;
      return $auth;
    } else {
      throw new Exception("Invalid username or password (Auth.class) ".var_dump($auth->rehash));
    }

    throw new Exception('BAD_LOGIN',-1);
  }

  function logout () {
    return true;
  }

  function getUser ($token) {
    $return = new User();
    $return->valid = true;
    $return->id = $token->id;
    $return->user = $token->user;
    $return->role = $token->role;

    return $return;
  }
}

?>