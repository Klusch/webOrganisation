<?php

class JSSubmitHelper extends AppHelper {

	var $submitTileId = 'submitTileId';
	var $sendResponse = 'sendResponse';
	var $contentRequest = 'contentRequest';
	var $filterTileSuggestionInputId = 'filterTileSuggestionInputId';

	public function modelFormId($model) {
		return $model . 'Form';
	}

	public function enter($model = '', $options = array()) {
		$options = $this->fillDefaults($options,
				array(
						'sendResponse' => $this->sendResponse,
						'suggestionInputId' => $this->filterTileSuggestionInputId
				)
		);
			
		$sendResponse = $options['sendResponse'];
		$suggestionInputId = $options['suggestionInputId'];

		$submitFunction = '';
		if (empty($model)) {
			$submitFunction = $sendResponse."();";
		} else {
			$submitFunction = "$('#".$this->modelFormId($model)."').submit();";
		}
		return "<script>
					(function execute() {
						$('#".$this->submitTileId."').click(function() {
								".$submitFunction."				
						})
					})();
	
					function checkKeyboard(e) {
						if (e.keyCode == 13 && document.activeElement.id != '".$suggestionInputId."') {
								".$submitFunction."
						}
					}
					window.onkeypress = checkKeyboard;
				</script>";
	}
}
?>