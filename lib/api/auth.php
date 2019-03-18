<?php

class Auth extends JSAPI {
  function __construct ($method, $params) {
    // parent::__construct($method, $params);

    $this->noAuth = ['login', 'logout'];

    if (!isset($this->jwt) && isset($_ENV['HTTP_AUTHORIZATION'])){
      preg_match('#^Bearer (.+?)$#',$_ENV['HTTP_AUTHORIZATION'],$m);
      if($m){
        $jwt = $m[1];
        $this->checkToken($jwt);
      }
    }
    if (!isset($this->jwt) && isset($_SERVER['HTTP_AUTHORIZATION'])){
      preg_match('#^Bearer (.+?)$#',$_SERVER['HTTP_AUTHORIZATION'],$m);
      if($m){
        $jwt = $m[1];
        $this->checkToken($jwt);
      }
    }

    // die(print_r($_COOKIE, true));
    if (!isset($this->jwt) && isset($_COOKIE['auth__token_local'])) {
      // preg_match('#^Bearer (.+?)$#',$_COOKIE['auth._token.local'],$m);
      preg_match('#^Bearer(%20| )(.+?)$#',$_COOKIE['auth__token_local'],$m);
      if($m){
        $jwt = $m[2];
        $this->checkToken($jwt);
      }
    }
    
    if(!isset($this->token->user) && !in_array($method, $this->noAuth)){
      $this->unauthorized();
    }
  }

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
    // }

    $valid = true;
    $id = 0;
    $user = 'nox';

    if ($valid) {
      if(!$this->token)
        $this->token = new stdClass();
      $this->token->id = $id;
      $this->token->user = $user;
      $this->updateToken();
      return [
        "token" => $this->jwt
      ];
    } else {
      throw new Exception("Invalid username or password {$rehash}");
    }

    throw new Exception('BAD_LOGIN',-1);  
  }

  function logout(){
    $this->token = new stdClass();
    $this->updateToken();
  }

  function getUser () {
    return [
      'valid' => true,
      'user' => $this->token->id
    ];
  }
}

?>