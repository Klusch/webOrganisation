<?php

// ------------------------------------
$this->start('leftTiles');
    $helps = $menues['left'];
    foreach($helps as $help) {
       echo $this->Tile->image($help['image'], $help['size']);	    
    }
$this->end();
// ------------------------------------

// ------------------------------------
$this->start('rightTiles');
    $helps = $menues['right'];
    foreach($helps as $help) {
       echo $this->Tile->getCategoryItem($help['category']);	    
    }
    echo $this->Tile->image('Banken/Comerzbank.jpg', 'double');
$this->end();
// ------------------------------------

//echo $this->Tile->getCategoryItem('cars');
echo $this->Tile->image('Banken/Comerzbank.jpg', 'double');
echo $this->Tile->getCategoryItem('costs');
echo $this->Tile->getCategoryItem('movies');
echo $this->Tile->getCategoryItem('joomlas');
echo $this->Tile->getCategoryItem('banks');
echo $this->Tile->getCategoryItem('powers');
echo $this->Tile->getCategoryItem('projects');
echo $this->Tile->getCategoryItem('colors');
echo $this->Tile->getCategoryItem('elektronicparts');

?>
