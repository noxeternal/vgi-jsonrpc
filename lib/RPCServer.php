<?php
class RPCServer {
  private $encrypt = false;
  static function handle ($baseClass='',$encrypt=false) {
    $srv = new RPCServer($baseClass,$encrypt);
    $srv->_handle(file_get_contents('php://input'));
  }
  function __construct ($baseClass='',$encrypt=false) {
    $this->baseClass = $baseClass;
    if ($encrypt) {
      $this->encrypt = new Encryption(self::$encrypt);
    }
  }

  function _handle ($data) {
    ob_start();       
    if(empty($data) || $data[0] != '{') {
      $this->fail(-32600,'INVALID_REQUEST');
    }
    $data = $this->decode($data);
    if($data->jsonrpc != '2.0') {
      $this->fail(-32600,'INVALID_REQUEST');
    }
    try {
      $result = $this->call($data->method, $data->params);
      if(is_callable([$this->class,'__headers'])) {
        $this->class->__headers();
      }
      $this->success($result);
    } catch(Throwable $e) {
      $this->fail($e->getCode(),$e->getMessage(),null,$e->getTrace());
    }
  }

  private function call ($method, $params) {
    $parts = explode('.', $method);
    $c = $this->baseClass;
    if(count($parts) == 2) {
      $c = $parts[0];
      $method = $parts[1];
    }
    if(substr($method,0,2) == '__') {
      throw new Exception('METHOD_NOT_FOUND',-32601);
    }
    $className = '\\api\\'.$c;
    $this->class = new $className($method,$params);
    $func = [$this->class,$method];

    if(is_callable($func)) {
      $ret = call_user_func_array($func,$params);
      return $ret;
    }
    throw new Exception('METHOD_NOT_FOUND',-32601);
  }

  private function decode ($data) {
    if ($this->encrypt) {
      return $this->encrypt->decrypt($data);
    }
    return json_decode($data);
  }

  private function encode ($data) {
    if ($this->encrypt) {
      return $this->encrypt->encrypt($data);
    }
    return json_encode($data);
  }

  private function success ($result) {
    header('content-type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Haeaders: content-type');
    $raw = ob_get_contents();
    ob_end_clean();
    die($this->encode([
      'jsonrpc'   => '2.0',
      'success' =>  true,
      'result'  =>  $result,
    ]));
  }

  private function fail ($code,$msg,$data=null,$trace=null) {
    header('content-type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: content-type');
    $raw = ob_get_contents();
    ob_end_clean();
    die($this->encode([
      'jsonrpc'   => '2.0',
      'success' =>  false,
      'error'   =>  [
        'code'  =>  $code,
        'message'=> $msg,
        'data'  =>  $data
        ,'trace' => $trace
      ],
    ]));
  }
}