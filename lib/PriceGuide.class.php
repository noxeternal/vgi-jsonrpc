<?php
require_once('init.php');

class priceGuide {
  public  $game,
          $console,
          $condition;

  function __construct($game, $console, $condition){
    $this->game = $game;
    $this->console = $console;
    $this->condition = $condition;
  }
  
  function getPrice($format = 'json'){
    return $this->getAllPrices()[$this->condition];
  }

  function getAllPrices(){
    $url = baseURL.$this->console.'/'.$this->game;

    preg_match_all(regex, file_get_contents($url),$m);

    // p($m);

    if(count($m['price']) >= 2){
      for($i=0;$i<3;$i++){
        $o[$m['condition'][$i]] = (float)$m['price'][$i];
      }
      return $o;
    }else{
      echo 'Price error for ',$url,"\n";
    }

  }
}

function getPrice ($itemID) {
  $db = $GLOBALS['db'];
  $stmt = $db->prepare("SELECT `itemLink`, `conLink`, `itemCond` FROM item LEFT JOIN `console` ON(`itemCon` = `conText`) WHERE `itemID` = ?");
  $stmt->bind_param('i', $itemID);
  $stmt->bind_result($itemLink, $conLink, $itemCond);
  $stmt->execute();

  $pg = new priceGuide($itemLink, $conLink, $itemCond);
  $pg->getPrice();

  if ($price) 
    return $price;
  else
    return false;
}

getPrice(660);

// $gamesInventory = $db->query("SELECT `itemID` FROM `item` WHERE itemLink != '' AND itemDeleted = 0");
// if($db->error)
//   die($db->error);

// $i = 0;
// foreach($gamesInventory as $row){
//   echo $i,"\n";

//   $price = getPrice($row['itemID']);

//   if($price){
//     $stmt - $db->prepare("INSERT INTO value (itemID,valAmount) VALUES (?, ?)");
//     $stmt->bind_param('id', $row['itemID'], $price);
//     if($db->error)
//       die($db->error);
//   }else{
//     echo 'Price not found for item ',$id,"\n";
//   }

//   $i++;
//   echo "\n";
// }

// echo "\nFin.";


?>