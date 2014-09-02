<?php
// app/View/Users/add.ctp
// ----------------------------------
$this->start('frameRequest');
   echo 'false';
$this->end();    
// ----------------------------------

// ----------------------------------
$this->start('breadCrumbs');
    $crumbs = array(
                 array('text' => __('Car management'), 'link' => array('controller' => 'Cars', 'action' => 'index')),
                 array('text' => __('New car'), 'link' => array('action' => '#'))
              );
    echo $this->App->breadcrumbs($crumbs);
$this->end();
// ----------------------------------

// ----------------------------------
$this->start('topTiles');
   echo $this->Category->tile();
   echo $this->Category->getCategoryHeadline('caradd');
$this->end();
// ----------------------------------

// ================================
    $model = 'Car';
    $fields = $this->Car->createInputFields();
    $buttons = $this->Input->createSaveButton();
    echo $this->Input->createForm($model, $fields, $buttons);
    
    $frames[] = array(
        'head' => __('Problems'),
        'content' => $this->Problem->carProblems($problems),
        'id' => 'carproblems'
    );
    echo $this->Accordion->accordion($frames);
?>