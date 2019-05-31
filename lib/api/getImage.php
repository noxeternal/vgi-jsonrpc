<?php

namespace api;

class getImage extends JSAPI implements \interfaces\getImage {
  public function get ($game, $console) : string {
    $i = new \Image($game, $console);
    if ($image = $i->getImage())
      return $image;
    else
      throw new \Exception('Unable to find cover art');
  }
}