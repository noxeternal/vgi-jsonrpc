<?php

class PriceGuide {
  public  $game,
          $console,
          $condition;

  function __construct ($game, $console, $condition) {
    $this->game = $game;
    $this->console = $console;
    $this->condition = $condition;
  }

  function getPrice () {
    return $this->getAllPrices()[$this->condition];
  }

  function getAllPrices () {
    $url = baseURL.'game/'.$this->console.'/'.$this->game;

    preg_match_all(regex, file_get_contents($url),$m);
    if(count($m['price']) >= 2) {
      for($i=0;$i<3;$i++) {
        $o[$m['condition'][$i]] = (float)$m['price'][$i];
      }
      return $o;
    }else{
      return false;
    }

  }
}

// $gamesInventory = $db->query("SELECT `itemID` FROM `item` WHERE itemLink != '' AND itemDeleted = 0");
// if($db->error)
//   die($db->error);

// $i = 0;
// foreach($gamesInventory as $row) {
//   echo $i,"\n";

//   $price = getPrice($row['itemID']);

//   if($price) {
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
