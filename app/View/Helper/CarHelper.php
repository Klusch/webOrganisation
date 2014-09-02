<?php

class CarHelper extends AppHelper {

    public $helpers = array('Tile', 'Html', 'Form', 'Input', 'Operation');

    public function carsAsContent($cars) {
        $result = "<div id='accordion-list'>";
        foreach ($cars as $i => $car) {
        	$destination = array(
        			'controller' => 'Cars',
        			'action' => 'edit', $car['Car']['id']
        	);
            $result .= $this->carTile($car, $destination);
        }
        
        $result .= $this->Operation->add('', 'Cars');
        
        $result .= "</div>";
        return $result;
    }

    public function carTile($car, $destination = null) {
        
        $parameters = array(
            'title' => $car['Car']['name'],
            'tile-size' => 'double',
            'destination' => $destination,
            'color' => 'bg-grayLighter',
            'image' => $this->Html->image($car['Car']['picture_url'], array('alt' => $car['Car']['name'], 'height' => '120', 'id' => 'carimage')),
            'text' => $car['Car']['hsn'] . "<br>" . $car['Car']['tsn'] . "<br>" . $car['Car']['modified'] . "<br>" . $car['Car']['created'] . "<br>" . ""
        );

        if ($destination === null) {
            return $this->Tile->selectableTile($user['User']['id'], $text, $parameters['image'], $onclickHandler, $selected);
        } else {
            return $this->Tile->linkTile('usertile', $text, $destination, $parameters['image']);
        }

    }

    /**
     * Creates fields for car add/edit
     * 
     */
    function createInputFields() {
        $fields = array();

        $fields[] = $this->Input->createTextInputFieldParams('name', __('Car description'));
        $fields[] = $this->Input->createTextInputFieldParams('hsn', __('Hsn'));
        $fields[] = $this->Input->createTextInputFieldParams('tsn', __('Tsn'));
//        $fields[] = $this->Input->createInputFieldParams('language_id', __('Language'), 'selection');
//        $fields[] = array('type' => 'hr');        
        return $fields;
    }

}

?>
