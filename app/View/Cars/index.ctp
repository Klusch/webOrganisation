<?php
// app/View/Users/index.ctp
// --------------------------------
// == Breadcrumbs ==
$this->start('breadCrumbs');
  $crumbs = array(
    array('text' => __('Car management'), 'link' => array('action' => '#')),
  );
  echo $this->App->breadcrumbs($crumbs);
$this->end();
// --------------------------------

// --------------------------------
// == Frames ==
$this->start('frameRequest');
  echo 'false';
$this->end();
// --------------------------------

// --------------------------------
// == Top-Tiles ==
$this->start('topTiles');
  echo $this->Category->tile();
  echo $this->Category->getCategoryHeadline();
$this->end();
// --------------------------------

// --------------------------------
// == JavaScript ==
$this->start('pageScripts');
 

$this->end();
// --------------------------------

// ================================
// == Content ==

echo $this->Input->createFilterField('filterTileSuggestionInputId');

// AK: To enable only one accordion is shown at one time,
// simply move the first and last statement out of foreach-Statement

//foreach ($cars as $i => $car) {
    $frames[] = array(
        'head' => __('All cars'),
        'content' => $this->Car->carsAsContent($cars),
        'size' => null,
        'id' => null
    );
    echo $this->Accordion->accordion($frames);
//}

?>