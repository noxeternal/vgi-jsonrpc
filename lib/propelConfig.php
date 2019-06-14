<?php
// $GLOBALS['db'] = new mysqli($dbAccess->host, $dbAccess->user, $dbAccess->pass, $dbAccess->name);

$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->checkVersion('2.0.0-dev');
$serviceContainer->setAdapterClass('default', 'mysql');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
$manager->setConfiguration([
  'dsn' => "mysql:host={$dbAccess->host};port=3306;dbname={$dbAccess->name}",
  'user' => $dbAccess->user,
  'password' => $dbAccess->pass,
  'settings' => [  
    'charset' => 'utf8',
    'queries' => []
  ],
  'classname' => '\\Propel\\Runtime\\Connection\\ConnectionWrapper',
  'model_paths' => [
    0 => 'src',
    1 => 'vendor',
  ],
]);
$manager->setName('default');
$serviceContainer->setConnectionManager('default', $manager);
$serviceContainer->setDefaultDatasource('default');
