<?php

class Image {

  function getImage($game, $console){
    if($console == '' || $game == '')
      return false;
    
    $url = baseURL.'/game/'.$console.'/'.$game;
    
    try{
      $dom = @\DOMDocument::loadHTML(file_get_contents($url));
      $xpath = new \DOMXPath($dom);
      $path = "//*[@id='product_details']/*/img";
      $img = $xpath->query($path)->item(0)->attributes->getNamedItem('src')->value;
      return explode('?', $img)[0];
    }catch(\Error $err){
      return false;
    }
  }

}

// CURRENT AS OF 5/30/2019:
  // $image = new Image();
  // foreach ($items as $item) {
  //   // echo $item->getLink(),'/', $item->get_ConsoleLink();
  //   if ($item->get_ConsoleLink() == '') {
  //     $img = 'No Console Link';
  //   } else {
  //     $img = $image->getImage($item->getLink(), $item->get_ConsoleLink());
  //     var_dump($img);
  //     if ($img) {
  //       $item->setImageUrl(baseURL.$img);
  //       $item->save();
  //     }
  //   }
  // }


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