<?php

class JSSubmitHelper extends AppHelper {

	var $submitTileId = 'submitTileId';
	var $sendResponse = 'sendResponse';
	var $contentRequest = 'contentRequest';
	var $filterTileSuggestionInputId = 'filterTileSuggestionInputId';

	public function modelFormId($model) {
		return $model . 'Form';
	}

}
?>