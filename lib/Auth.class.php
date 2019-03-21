<?php

class Auth {

  function __construct(){}

  function login ($username, $password) {
    // $login = $this->mysqli->prepare("SELECT loginID, loginPasswd FROM login WHERE loginName = ?");
    // $login->bind_param('s', $user);
    // $login->bind_result($id, $hash);
    // $options = [];
    // $valid = false;
    // $rehash = false;
    
    // $login->execute();
    // $login->store_result();
    
    // if (!$login->fetch()) throw new Exception('Invalid username or password');
    
    // $login->close();
    // if (substr($hash, 0, 1) !== '$') {
    //   $valid = md5($pass) === $hash;
    //   $rehash = $valid;
    // } else {
    //   $valid = password_verify($pass, $hash);     
    //   $rehash = $valid && password_needs_rehash($hash, PASSWORD_DEFAULT, $options);
    // }
    // if ($valid && $rehash) {
    //   $newHash = password_hash($pass, PASSWORD_DEFAULT, $options);
    //   $loginUp = $this->mysqli->prepare("UPDATE login SET loginPasswd = ? WHERE loginID = ? AND _DELETED IS NULL");
    //   $loginUp->bind_param('ss', $newHash, $id);
    //   $loginUp->execute();
    // } /*

    $return = new stdClass();


    $return->valid = true;
    $return->id = 0;
    $return->user = 'nox';
    $return->role = 'owner';
    
    return $return;    
  }

  function logout () {
    return;
  }

  function getUser ($token) {
    $return = new stdClass();
    $return->valid = true;
    $return->id = $token->id;
    $return->user = $token->user;
    $return->role = $token->role;

    return $return;
  }
}

?>