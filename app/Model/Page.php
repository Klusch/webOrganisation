<?php

App::uses('AppModel', 'Model');

class Page extends AppModel {

    public $useTable = false;

    public function getMenues() {
        $sampleLeft = array(
            array('size' => 'double', 'image' => 'Banken/Comerzbank.jpg')
        );

        $sampleRight = array(
            array('category' => 'cars')
        );

        return array(
            'left' => $sampleLeft,
            'middle' => array(),
            'right' => $sampleRight
        );
    }

}
