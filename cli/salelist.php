<?php

require_once '../lib/init.php';

$fh_in = fopen('salelist.csv', 'r');
$fh_out = fopen('pricelist.csv', 'w');
$header = fgetcsv($fh_in);

while ($line = fgetcsv($fh_in)) {
  $game = array_combine($header, $line);
  $q = vgi\ItemQuery::create()
        ->select(['ItemId'])
        ->where('Item.Name = ?', $game['name'])
        ->where('Item.Console = ?', $game['console'])
        ->where('Item.Category = ?', $game['category'])
        ->find()
        ->toArray();
  // die(json_encode($q));

  $p = vgi\PriceListQuery::create()
        ->select(['Amount'])
        ->withColumn('MAX(PriceList.LastCheck)')
        ->where('PriceList.ItemId = ?', $q[0])
        ->find()
        ->toArray();

  // echo json_encode($p),"\n";

  $o = array_merge($game, ['Amount' => $p[0]['Amount']]);
  // echo json_encode($o),"\n";
  // die(json_encode($o));
  fputcsv($fh_out, array_merge($game, ['Amount' => $p[0]['Amount']]));
}

echo "Fin.\n";