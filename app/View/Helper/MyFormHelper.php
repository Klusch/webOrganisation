<?php

App::uses('FormHelper', 'View/Helper');

class MyFormHelper extends FormHelper {

	public function mandatory($model, $key, $field = null) {
		return parent::_introspectModel($model, $key, $field);
	}
}

?>