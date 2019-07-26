<?php
ini_set('display_errors',1);
namespace vgi;
header("Content-type: text/css; charset: UTF-8");
// header("Content-type: application/json");
require '../../lib/init.php';

$styles = StyleQuery::create()->find();

function formatClassName ($s) {
  return str_replace(' ', '_', $s);
}

function formatStyle ($s) {
  $split = explode(';', $s);
  $style = [];
  for($i=0; $i<count($split)-1;$i++) {
    $style[] = '  '.$split[$i];
  }
  $style = implode(";\n", $style);
  return $style;
}

foreach($styles as $style)
  echo '.',formatClassName($style->getName())," {\n",
    formatStyle($style->getText()),";\n",
  "}\n";