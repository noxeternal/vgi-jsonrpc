<?php

header('content-type:text/plain');
require '../lib/init.php';

echo 'host: ',REDIS_HOST,' port: ',REDIS_PORT,"\n";

try{
  Cache::set('temp','abcd','1234');
  echo Cache::get('temp','abcd');
}catch(Exception $e){
  die($e->getMessage());
}