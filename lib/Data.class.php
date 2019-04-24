<?php

class Data {
  
  function __construct() {
    $this->db = $GLOBALS['db'];
  }

  function getCategories () {
    $sql = "SELECT * FROM `category` ORDER BY catText";
    $result = $this->db->query($sql);
    $return = [];
    foreach($result as $row){
      $return[] = [
        'id'  => floatval($row['catID']),
        'text'  => $row['catText']
      ];
    }
    return $return;
  }

  function getConditions () {
    $sql = "SELECT * FROM `condition` ORDER BY condText";
    $result = $this->db->query($sql);
    $return = [];
    foreach($result as $row){
      $return[] = [
        'id'  => floatval($row['condID']),
        'text'  => $row['condText']
      ];
    }
    return $return;
  }

  function getConsoles () {
    $sql = "SELECT `console`.*,COUNT(`itemID`) AS `conCount` FROM `console` LEFT JOIN `item` ON (`conText` = `itemConsole`) WHERE `item`.`_DELETED` IS NULL GROUP BY `item`.`itemConsole` HAVING conCount > 0 ORDER BY `console`.`conOrderBy`";
    $result = $this->db->query($sql);
    $return = [];
    foreach($result as $row){
      $return[] = [
        'id'  => floatval($row['conID']),
        'text'  => $row['conText'], 
        'link'  => $row['conLink'],
        'count' => $row['conCount'],
        'order' => floatval($row['conOrderBy'])
      ];
    }
    return $return;
  }

  function getStyles () {
    $sql = "SELECT * FROM `style` ORDER BY styleName";
    $result = $this->db->query($sql);
    $return = [];
    foreach($result as $row){
      $return[] = [
        'id'  => floatval($row['styleID']),
        'name'  => $row['styleName'],
        'text'  => $row['styleText']
      ];
    }
    return $return;
  }

  function getItems () {
    $sql = "SELECT * FROM `item` WHERE `_DELETED` IS NULL ORDER BY `itemName`";
    $result = $this->db->query($sql);
    $return = [];
    foreach($result as $row){
      $return[] = [
        'id'        => floatval($row['itemID']),
        'name'      => $row['itemName'],
        'link'      => $row['itemLink'],
        'console'   => ($row['itemConsole']),
        'category'  => ($row['itemCat']),
        'condition' => ($row['itemCond']),
        'box'       => floatval($row['itemBox']),
        'manual'    => floatval($row['itemManual']),
        'style'     => ($row['itemStyle'])
      ];
    }
    return $return;
  }

  function getValues () {
    $sql = "SELECT valID,itemID,valAmount,MAX(valLastCheck) as valLastCheck FROM value LEFT JOIN item USING(itemID) WHERE item._DELETED IS NULL GROUP BY itemID";
    $result = $this->db->query($sql);
    $return = [];
    foreach($result as $row){
      $return[] = [
        'id'        => floatval($row['valID']),
        'item'      => floatval($row['itemID']),
        'value'     => floatval($row['valAmount']),
        'lastCheck' => $row['valLastCheck']
      ];
    }
    return $return;
  }

  function getExtras () {
    $sql = "SELECT * FROM extra";
    $result = $this->db->query($sql);
    $return = [];
    foreach($result as $row){
      $return[] = [
        'id'   => floatval($row['extraID']),
        'item' => floatval($row['itemID']),
        'text' => $row['extraText']
      ];
    }
    return $return;
  }

  function getDeleted () {
    $sql = "SELECT * FROM `item` WHERE `_DELETED` IS NOT NULL";
    $result = $this->db->query($sql);
    $return = [];
    foreach($result as $row){
      $return[] = [
        'id'        => floatval($row['itemID']),
        'name'      => $row['itemName'],
        'link'      => $row['itemLink'],
        'console'   => ($row['itemConsole']),
        'category'  => ($row['itemCat']),
        'condition' => ($row['itemCond']),
        'box'       => floatval($row['itemBox']),
        'manual'    => floatval($row['itemManual']),
        'deleted'     => ($row['_DELETED'])
      ];
    }
    return $return;
  }

  function editCategory ($id, $text) {
    $sql = "INSERT INTO `category` (`catID`, `catText`) VALUES (?, ?) ON DUPLICATE KEY UPDATE `catText` = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param('iss', $id, $text, $text);
    $result = $stmt->execute();
    return $result?$result:$stmt->error;

  }

  function editCondition ($id, $text) {
    $sql = "INSERT INTO `condition` (`condID`, `condText`) VALUES (?, ?) ON DUPLICATE KEY UPDATE `condText` = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param('iss', $id, $text, $text);
    $result = $stmt->execute();
    return $result;
  }

  function editConsole ($id, $text, $link, $orderBy) {
    $sql = "INSERT INTO `console` (`catID`, `catText`, `conLink`, `conOrderBy`) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE `conText` = ?, `conLink` = ?, `conOrderBy` = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param('ississi', $id, $text, $link, $orderBy, $text, $link, $orderBy);
    $result = $stmt->execute();
    return $result;
  }

  function editExtras ($id, $itemId, $text) {
    $sql = "INSERT INTO `extra` (`extraID`, `itemID`, `extraText`) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE `itemID` = ?, `extraText` = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param('iisis', $id, $itemId, $text, $itemId, $text);
    $result = $stmt->execute();
    return $result;
  }

  function editItem ($id, $name, $link, $console, $category, $condition, $box, $manual, $style) {
    $sql = "INSERT INTO `item` (`itemID`, `itemName`, `itemLink`, `itemConsole`, `itemCat`, `itemCond`, `itemBox`, `itemManual`, `itemStyle`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `itemName` = ?, `itemLink` = ?, `itemConsole` = ?, `itemCat` = ?, `itemCond` = ?, `itemBox` = ?, `itemManual` = ?, `itemStyle` = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param('isssssiissssssssiisss', $id, $name, $link, $console, $category, $condition, $box, $manual, $style, $name, $link, $console, $category, $condition, $box, $manual, $style);
    $result = $stmt->execute();
    return $result;
  }

  function editStyle ($id, $name, $text) {
    $sql = "INSERT INTO `style` (`styleID`, `styleName`, `styleText`) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE `styleName` = ?, `styleText` = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param('issss', $id, $name, $text, $name, $text);
    $result = $stmt->execute();
    return $result;
  }

  function deleteItem ($id) {
    $sql = "UPDATE `item` SET `_DELETED` = CURRENT_TIMESTAMP() WHERE `itemID` = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param('i', $id);
    $result = $stmt->execute();
    return $result?$result:$this->db->error;
  }
}

?>