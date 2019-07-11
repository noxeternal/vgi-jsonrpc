<?php

class Cache {
  static $client;

  static function init () {
    self::$client = new \Redis();
    self::$client->pconnect(REDIS_HOST, REDIS_PORT);
  }
  static function get ($table,$key) {
    if(!self::$client) self::init();
    $value = self::$client->get("cache.{$table}:{$key}");
    if(is_string($value)) {
      if($value[0] == '{' || $value[1] == '[')
        $value = json_decode($value);
      if(is_object($value))
        $value->cache = true;
      return $value;
    }else{
      return false;
    }
  }
  static function set ($table,$key,$value,$ex=-1) {
    if(!self::$client) self::init();
    if(empty($value)) return;
    $k = "cache.{$table}:{$key}";
    $v = $value;
    if(!is_string($v))
      $v = json_encode($v);
    if($ex == -1)
      $ex = strtotime('now + 14 days'); // Get seconds for 24 hours from now
    if($ex > 0)
      self::$client->set($k,$v,$ex-time()); // Subtract time since redis wants seconds until expired
    else
      self::$client->set($k,$v);
    return true;
  }
}
