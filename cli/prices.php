<?php 

require_once '../lib/init.php';

$items = vgi\ItemQuery::create()
          ->where('Item.State != ?', 'digital')
          ->where('Item.Category = ?', 'console')
          ->find();

$i = 0;
foreach ($items as $item) {
  try {
    $i++;
    $amount = api\getValue::getPrice($item->getItemId());
    // echo $value;
    $pl = new vgi\PriceList();
      $pl->setItemId($item->getItemId());
      $pl->setAmount($amount);
    $pl->save();

    // if ($i >= 5)
    //   exit;
  }catch(Exception $e){
    echo $item->getItemId(),': ',$item->getName(),"\n",$e->getMessage();
  }



  continue;

  try{
    if (vgi\ImageDataQuery::create()->filterByImageUrl($item->getImageUrl())->count())
      continue;

    $imgUrl = api\getImage::getUrl($item->getName(), $item->getConsole());
    if ($imgUrl == '') {
      echo $item->getItemId() ,': ',$item->getName();
      continue;
    }

    $item->setImageUrl($imgUrl);
    $item->save();

    $imgData = base64_encode(file_get_contents($imgUrl));
    $img = new vgi\ImageData();
      $img->setImageUrl($imgUrl);
      $img->setImage($imgData);
    $img->save();
  }catch(Exception $e){
    echo $item->getItemId(),': ',$item->getName(),"\n",$e->getMessage();
  }
}