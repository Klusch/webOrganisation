<?php
// ------------------------------------
$this->start('leftTiles');
    $helps = $menues['left'];
    foreach($helps as $help) {
       echo $help;	    
    }
$this->end();
// ------------------------------------

// ------------------------------------
$this->start('rightTiles');
    $helps = $menues['right'];
    foreach($helps as $help) {
       echo $this->Tile->getCategoryItem($help);	    
    }
$this->end();
// ------------------------------------

echo $this->Tile->getCategoryItem('cars');

/*
echo $this->Tile->getCategoryItem('costs');
echo $this->Tile->getCategoryItem('movies');
echo $this->Tile->getCategoryItem('joomlas');
echo $this->Tile->getCategoryItem('banks');
echo $this->Tile->getCategoryItem('powers');
echo $this->Tile->getCategoryItem('projects');
echo $this->Tile->getCategoryItem('colors');
echo $this->Tile->getCategoryItem('elektronicparts');
*/


?>
