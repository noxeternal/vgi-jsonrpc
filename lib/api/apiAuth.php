<?php

class apiAuth extends JSAPI {
  function __construct ($method, $params) {
    // parent::__construct($method, $params);
    $this->Auth = new Auth();

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
    $auth = Auth::login($username, $password);

    if ($auth->valid) {
      if(!isset($this->token))
        $this->token = new stdClass();
      $this->token = $auth;
      $this->updateToken();
      return [
        "token" => $this->jwt
      ];
    } else {
      throw new Exception("Invalid username or password {$rehash}");
    }

    throw new Exception('BAD_LOGIN',-1);  
    return $auth;
  }

  function logout(){
    return Auth::logout();

    $this->token = new stdClass();
    $this->updateToken();
  }

  function getUser () {
    return Auth::getUser($this->token);
  }
}

?>