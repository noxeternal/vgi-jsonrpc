<?php

namespace api;

class getValue extends JSAPI implements \interfaces\getValue {

  function __construct ($method, $params) {
    parent::__construct($method, $params);
  }

  function getPrice ($itemID) : float {
    $item = \vgi\ItemQuery::create()
              ->leftJoin('Item._Console')
              ->withColumn('console.link', 'consoleLink')
              ->findPk($itemID);
    // var_dump([$item->getLink(), $item->ConsoleLink(), $item->getState()]); exit;
    $pg = new \PriceGuide($item->getLink(), $item->getConsoleLink(), $item->getState());
    $price = $pg->getPrice();

    // $stmt = $db->prepare("SELECT `itemLink`, `conLink`, `itemCond` FROM item LEFT JOIN `console` ON(`itemConsole` = `conText`) WHERE `itemID` = ?");
    // $stmt->bind_param('i', $itemID);
    // $stmt->bind_result($itemLink, $conLink, $itemCond);
    // $stmt->execute();
    // $stmt->fetch();

    if ($price) 
      return $price;
    else
      throw new \Exception("Price Guide Error for itemID $itemID");
  }

  public static function getPrice($itemId) {
    try {
      $this->getPrice($itemId);
    }catch(\Exception $e){
      return false;
    }
  }

}