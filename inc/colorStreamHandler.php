<?php declare(strict_types=1);

namespace Monolog\Handler;
use Monolog\Logger;

class colorStreamHandler extends StreamHandler {
  // private $keywords = [
  //   'SELECT',
  //   'INSERT'
  // ];

  // private $colorMap = [
  //   'black',
  //   'blue',
  //   'green',
  //   'cyan',
  //   'red',
  //   'purple',
  //   'brown',
  //   'lightGray',
  //   'darkGray',
  //   'lightBlue',
  //   'lightGreen',
  //   'lightCyan',
  //   'lightRed',
  //   'lightPurple',
  //   'yellow',
  //   'white',
  // ];
  /**
   * Write to stream
   * @param resource $stream
   * @param array    $record
   */
  protected function streamWrite($stream, array $record): void{
    // foreach ($colorMap as $color => $keywords) {
    //   $record['formatted'] = $this->replace($record['formatted'], $color, $keywords);
    // }

    $color = false;
    if(strpos($record['formatted'], 'INSERT') > 0)
      $color = 'cyan';
    if(!$color && strpos($record['formatted'], 'INFO') > 0)
      $color = 'blue';
    $color = $color?$color:'red';
      
    fwrite($stream, $color((string) $record['formatted']));
  }

  // private function replace($f, $r) {

  // }
}