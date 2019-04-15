<?php 
header("Content-type: text/css; charset: UTF-8");
require_once('../../lib/init.php');

$sql = "SELECT * FROM style";
$result = $db->query($sql);

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

foreach($result as $row) {
  echo '.',formatClassName($row['styleName'])," {\n",formatStyle($row['styleText']),";\n}\n";
}

?>