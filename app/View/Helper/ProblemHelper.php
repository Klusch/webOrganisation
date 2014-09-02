<?php

class ProblemHelper extends AppHelper {

    public $helpers = array('Tile', 'Html', 'Form', 'Input', 'Operation');
    
    public function carProblems($problems) {
        $result = "<div id='accordion-list'>";
        foreach ($problems as $problem) {
        	$destination = array(
        			'controller' => 'Problems',
        			'action' => 'edit', $problem['Problem']['id']
        	);
            $result .= $this->carTile($problem, $destination);
        }
        
        $result .= $this->Operation->add('', 'Problems');
        
        $result .= "</div>";
        return $result;
    }

    public function problemTile($car, $destination = null) {
/*
        $parameters = array(
            
            'title' => $user['User']['username'],
            'tile-size' => 'double',
            'destination' => $destination,
            'color' => 'bg-grayLighter',
            'image' => $this->Html->image($user['Group']['picture_url'], array('alt' => $user['User']['username'], 'height' => '120', 'id' => 'userimage')),
            'row1' => '<b>' . $user['User']['username'] . '</b>',
            'row2' => $user['User']['first_name'] . ' ' . $user['User']['last_name'],
            'row3' => $user['User']['phone'],
            'row4' => '<i>' . $user['Company']['name'] . '</i>',
            'row5' => $user['Company']['country'] . ', ' . $user['Company']['zip'] . ' ' . $user['Company']['city'] . '</i>'
        );

        $text = $parameters['row1'] . "<br>" . $parameters['row2'] . "<br>" . $parameters['row3'] .
                "<br>" . $parameters['row4'] . "<br>" . $parameters['row5'];
        
        if ($destination === null) {
        	return $this->Tile->selectableTile($user['User']['id'], $text, $parameters['image'], $onclickHandler, $selected);
        } else {
        	return $this->Tile->linkTile('usertile', $text, $destination, $parameters['image']);
        }
 */
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
