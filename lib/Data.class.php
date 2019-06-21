<?php

class Data {
  public function __construct () {
    // require_once 'init.php';
  }

  public function getCategories () {
    return array_values(vgi\CategoryQuery::create()
            ->find()
            ->toArray());
  }

  public function getStates () {
    return vgi\StateQuery::create()
            ->find()
            ->toArray();
  }

  public function getConsoles () {
    return vgi\ConsoleQuery::create()
            ->leftJoinItem()
            ->withColumn('count(Item.ItemId)', 'Count')
            ->groupBy('Console.Text')
            ->orderByRank()
            ->find()
            ->toArray();
  }

  public function getStyles () {
    return vgi\StyleQuery::create()
            ->find()
            ->toArray();
  }

  public function getItems () {
    return  vgi\ItemQuery::create()
            ->leftJoinWithExtra()
            ->find()
            ->toArray();
  }

  public function getPriceList ($id = false) {
    $q = new vgi\PriceListQuery();
    $q->create();
    if ($id) {
      $q->findByItemId($id);
    }
    return $q
            ->orderBy('PriceList.ItemId')
            ->orderBy('PriceList.LastCheck')
            ->withColumn('UNIX_TIMESTAMP(last_check)', 'UnixTime')
            ->find()
            ->toArray();
  }

  public function getDeleted () {
    return vgi\ItemArchiveQuery::create()
            ->find()
            ->toArray();
  }

  public function editCategory ($id, $text) {
    vgi\CategoryQuery::create()
      ->findPk($id)
      ->setText($text)
      ->save();
  }

  public function editState ($id, $text) {
    vgi\StateQuery::create()
      ->findPk($id)
      ->setText($text)
      ->save();
  }

  public function editConsole ($id, $text, $link, $orderBy) {
    vgi\ConsoleQuery::create()
      ->findPk($id)
      ->setText($text)
      ->setLink($link)
      ->moveToRank($orderBy)
      ->save();
  }

  public function editExtra ($id, $text) {
    vgi\ExtraQuery::create()
      ->findPk($id)
      ->setText($text)
      ->save();
  }

  public function editItem ($id, $name, $link, $console, $category, $state, $box, $manual, $style) {
    $item = vgi\ItemQuery::create()->findPk($id);

    if($item === NULL) {
      $item = new vgi\Item();
    }

    $item
      ->setName($name)
      ->setLink($link)
      ->setConsole($console)
      ->setState($state)
      ->setCategory($category)
      ->setBox($box)
      ->setManual($manual)
      ->setStyle($style)
      ->save();

    return $item->getItemId();
  }

  public function editStyle ($id, $name, $text) {
    vgi\StyleQuery::create()
      ->findPk($id)
      ->setName($name)
      ->setText($text)
      ->save();
  }

  public function newCategory ($text) {
    $Category = new vgi\Category();
    $Category->setText($text);
    $Category->save();
    return $Category->getId();
  }

  public function newState ($text) {
    $State = new vgi\State();
    $State->setText($text);
    $State->save();
    return $State->getId();
  }

  public function newConsole ($text, $link, $orderBy) {
    $Console = new vgi\Console();
    $Console->setText($text);
    $Console->setLink($link);
    $Console->setRank($orderBy);
    $Console->save();
    return $Console->getId();
  }

  public function newExtra ($text) {
    $Extra = new vgi\Extra();
    $Extra->setText($text);
    $Extra->save();
    return $Extra->getId();
  }

  public function newItem ($name, $link, $imageUrl, $console, $category, $state, $box, $manual, $style) {
    $Item = new vgi\Item();
    $Item->setName($name);
    $Item->setLink($link);
    $Item->setImageUrl($imageUrl);
    $Item->setConsole($console);
    $Item->setCategory($category);
    $Item->setState($state);
    $Item->setBox($box);
    $Item->setManual($manual);
    $Item->setStyle($style);
    $Item->save();
    return $Item->getId();
  }

  public function newStyle ($name, $text) {
    $Style = new vgi\Style();
    $Style->setName($name);
    $Style->setText($text);
    $Style->save();
    return $Style->getId();
  }

  public function newValue ($id, $newValue) {
    // var_dump();exit;
    $value = new vgi\PriceList();
    $value->setItemId($id);
    $value->setAmount($newValue);
    $value->save();
  }

  public function deleteCategory ($id) {
    $this->delete('Category', $id);
  }

  public function deleteState ($id) {
    $this->delete('State', $id);
  }

  public function deleteConsole ($id) {
    $this->delete('Console', $id);
  }

  public function deleteExtra ($id) {
    $this->delete('Extra', $id);
  }

  public function deleteItem ($id) {
    $this->delete('Item', $id);
  }

  public function deleteStyle ($id) {
    $this->delete('Style', $id);
  }

  private function delete($table, $id){
    $tq = 'vgi\\'.$table.'Query';
    $tq::create()->findPk($id)->delete();
  }
}