<?php

class apiAuth extends JSAPI {
  function __construct ($method, $params) {
    $this->noAuth = ['login', 'logout'];
    $this->Auth = new Auth();

    if (!isset($this->jwt) && isset($_ENV['HTTP_AUTHORIZATION'])){
      preg_match('#^Bearer (.+?)$#',$_ENV['HTTP_AUTHORIZATION'],$m);
      if($m){
        $jwt = $m[1];
        $x = $this->checkToken($jwt);
      }
    }
    if (!isset($this->jwt) && isset($_SERVER['HTTP_AUTHORIZATION'])){
      preg_match('#^Bearer (.+?)$#',$_SERVER['HTTP_AUTHORIZATION'],$m);
      if($m){
        $jwt = $m[1];
        $x = $this->checkToken($jwt);
      }
    }

    if (!isset($this->jwt) && isset($_COOKIE['auth__token_local'])) {
      preg_match('#^Bearer(%20| )(.+?)$#',$_COOKIE['auth__token_local'],$m);
      if($m){
        $jwt = $m[2];
        $x = $this->checkToken($jwt);
      }
    }
    
    if(!isset($this->token->user) && !in_array($method, $this->noAuth)){
      $this->unauthorized();
    }
  }

  function login ($username, $password) {
    $auth = $this->Auth->login($username, $password);

    if ($auth->valid) {
      if(!isset($this->token))
        $this->token = new stdClass();
      $this->token = $auth;
      $this->updateToken();
      return [
        "token" => $this->jwt
      ];
    } else {
      throw new Exception("Invalid username or password (apiAuth) ".var_dump($auth->rehash));
    }

    throw new Exception('BAD_LOGIN',-1);  
    return $auth;
  }

  function logout(){
    return $this->Auth->logout();

    $this->token = new stdClass();
    $this->updateToken();
  }

  function getUser () {
    return $this->Auth->getUser($this->token);
  }
}

?>