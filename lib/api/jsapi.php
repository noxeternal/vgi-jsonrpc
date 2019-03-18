<?php
define('JWT_DURATION',1 * 25 * 60 * 60); // 1 hour

abstract class JSAPI {
  protected $noAuth = ['selectCounty', 'logout', 'getCounties', 'getAll', 'getString', 'getStrings', 'methods'];

  function __construct($method,$params){
    $this->token = new stdClass();
    if(isset($_ENV['HTTP_AUTHORIZATION'])){
      preg_match('#^Bearer (.+?)$#',$_ENV['HTTP_AUTHORIZATION'],$m);

      if($m){
        $jwt = $m[1];
        $this->checkToken($jwt);
      }
    }
    
    if(isset($_COOKIE['token']) && !$jwt)
      $this->checkToken($_COOKIE['token']);
    
    if(!in_array($method, $this->noAuth)){
      return $this->unauthorized();
    }
  }

  function methods(){
    $ret = [];
    $class = new ReflectionClass(get_class($this));
    $methods = $class->getMethods(ReflectionMethod::IS_PUBLIC);
    foreach($methods as $method) {
      if($method->name == '__construct') continue;
      $name = $method->name;
      $params = array_map(function($param){
        return $param->name;
      },$method->getParameters());
      $ret[] = $name;
    }   
    return $ret;
  }

  protected function checkToken($jwt){
    try{
      $token = JWT::decode($jwt,JWT_SECRET,['HS256']);
      $this->token = $token;
      $this->jwt = $jwt;

      if($token->exp < time() + (1 * 60 * 60)){
        $this->updateToken();
      }
      return true;
    }catch(Exception $e){}
    return false;
  }

  function unauthorized(){
    http_response_code(401);
    throw new Exception('UNAUTHORIZED',-1);
  }

  function invalidParams(){
    throw new Exception('Invalid params',-32602);
  }

  function __headers(){
    if(!isset($this->jwt) || empty($this->jwt))
      $this->updateToken();
    $jwt = $this->jwt;
    header("X-Token: {$jwt}");
  }

  function echo($data){
    return $data;
  }

  protected function updateToken(){
    $this->jwt = $this->generateToken();
  }

  private function generateToken(){
    $data = $this->token;
    $data->iss = "https://renewyourtag.com";
    $data->aud = "https://renewyourtag.com";
    $data->iat = time();
    $data->exp = time() + JWT_DURATION;
    return JWT::encode($data,JWT_SECRET);
  }
}
?>