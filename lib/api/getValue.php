<?php

namespace api;

class getValue extends JSAPI implements \interfaces\getValue {

  function __construct ($method, $params) {
    parent::__construct($method, $params);
  }

  function getPrice ($itemID) : float {
    $db = $GLOBALS['db'];
    $stmt = $db->prepare("SELECT `itemLink`, `conLink`, `itemCond` FROM item LEFT JOIN `console` ON(`itemConsole` = `conText`) WHERE `itemID` = ?");
    $stmt->bind_param('i', $itemID);
    $stmt->bind_result($itemLink, $conLink, $itemCond);
    $stmt->execute();
    $stmt->fetch();

    $pg = new \PriceGuide($itemLink, $conLink, $itemCond);
    $price = $pg->getPrice();

    if ($price) 
      return $price;
    else
      throw new Exception("Price Guide Error for itemID $itemID");
  }

}


?>