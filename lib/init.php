<?php

// define('DEBUG', false);
if(!defined('DEBUG'))
  define('DEBUG', true);

$dbAccess = getenv('DBINFO');
$dbAccess = json_decode($dbAccess);

if(!defined('PHP_API_PATH'))
  define('PHP_API_PATH',__DIR__.'/api/');

if(!defined('PHP_INTERFACE_PATH'))
  define('PHP_INTERFACE_PATH',__DIR__.'/interfaces/');

set_include_path(get_include_path() . PATH_SEPARATOR . PHP_API_PATH);

require_once 'vendor/autoload.php';
require_once 'propelConfig.php';
require_once __DIR__.'/../inc/colorStreamHandler.php';
require_once __DIR__.'/../inc/colors.php';

if(!isset($skipAutoload))
  autoloadAddFolder(__DIR__.'/');

autoloadAddFolder(PHP_API_PATH);
autoloadAddFolder(PHP_INTERFACE_PATH);

function autoloadAddFolder ($dir) {
  spl_autoload_register(function ($class) use ($dir) {
    $debug = defined('AUTOLOAD_DEBUG');
    if($debug) echo $class."<br>\n";
    $base_dir = $dir;
    $file = $base_dir . str_replace('\\', '/', $class) . '.class.php';
    if($debug) echo $file."<br>\n";
    if (file_exists($file))             { require_once $file;   return; }
    if (file_exists(strtolower($file))) { require_once strtolower($file);   return; }
    $file = str_replace('.class.php','.php',$file);
    if($debug) echo $file."<br>\n";
    if (file_exists($file))             { require_once $file;   return; }
    if (file_exists(strtolower($file))) { require_once strtolower($file);   return; }
  },false,true);
}

if(DEBUG == true){
  $logger = new \Monolog\Logger('defaultLogger');
  $logger->pushHandler(new \Monolog\Handler\colorStreamHandler('php://stderr'));
  \Propel\Runtime\Propel::getServiceContainer()->setLogger('defaultLogger', $logger);
  
  $dataSource = \Propel\Runtime\Propel::getDefaultDatasource();
  $con = Propel\Runtime\Propel::getWriteConnection($dataSource);
  $con->useDebug(true);
}

if (!defined('REDIS_HOST')) {
  define('REDIS_HOST', getenv('REDIS_HOST'));
}

if (!defined('REDIS_PORT')) {
  define('REDIS_PORT', getenv('REDIS_PORT'));
}

if (!defined('JWT_SECRET')) {
  define('JWT_SECRET','f9e8519d5ba2b2ba5e4b778e283c5ec72fe70384e4e23a52a250d00015ea0406'); // Random SHA256
}


define('baseURL', 'https://www.pricecharting.com/game/');
define('regex', '/.*<td id="(?P<condition>[a-z]+)_price">\s.*>\s*\$*(?P<price>([0-9.]+|N\/A))\s+<\/span>/');
