<?php
App::uses('AppModel', 'Model');
class Page extends AppModel {

	public $useTable = false;
	
	public function getMenues() {
		$sampleLeft = "<div class='tile double'>
                                   <div class='tile-content image'>
                                       <img src='img/Banken/Comerzbank.jpg'>
                                   </div>
                               </div>";
		
                $sampleRight = "cars";                               
                               
		return array(
			'left' => array($sampleLeft),
			'middle' => array(),
			'right' => array($sampleRight)
			    );	
	}
}
