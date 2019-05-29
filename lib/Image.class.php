<?php

class Image {
  public  $game,
          $console;
  private $regex = '/<div class="cover">.*<img src="\/img\/(.*)\?s=[0-9]+/';

  function __construct($game, $console){
    $this->game = $game;
    $this->console = $console;
  }
  
  function getImage(){
    $url = baseURL.$this->console.'/'.$this->game;
    $pageSource = str_replace("\n", ' ', file_get_contents($url));

    preg_match($this->regex, $pageSource, $m);

    return $m[1]?
      "https://www.pricecharting.com/img/{$m[1]}":
      false;
  }
}

// require_once 'init.php';
// $i = new Image('super-mario-all-stars-and-super-mario-world', 'super-nintendo');
// $i->getImage();


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