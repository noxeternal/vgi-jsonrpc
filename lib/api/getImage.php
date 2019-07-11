<?php

namespace api;

class getImage extends JSAPI implements \interfaces\getImage {
  // public function getImage ($game, $console) : string {
  //   $i = new \Image($game, $console);
  //   if ($image = $i->loadImage())
  //     return $image;
  //   else
  //     throw new \Exception('Unable to find cover art');
  // }

  public function getUrl ($game, $console) : string {
    $i = new \Image($game, $console);
    if ($imageUrl = $i->getImageUrl())
      return $imageUrl;
    else
      throw new \Exception('Unable to find cover art');
  }
}
