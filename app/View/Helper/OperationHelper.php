
<?php

/**
 * OperationHelper
 *
 *
 * @package       app.View.Helper
 */
class OperationHelper extends AppHelper {

	public $helpers = array('Html', 'Form', 'Tile');
	public $addPictureUrl = 'navigation/add.png';

	public function add($id = null, $controller = null, $label = '') {
		$destination = array('action' => 'add', $id);
		if (isset($controller)) {
			$destination = array_merge(
					$destination,
					array('controller' => $controller)
			);
		}
		
		$text = __('Add');
		if (!empty($label)) {
			$text = $label;
		}
		return $this->actionAsPicture($this->addPictureUrl, $destination, $text, $id);
	}

	public function edit($id = null, $secondId = null) {
		return $this->action('pencil', 'edit', __('Edit'), $id, $secondId);
	}

	public function editDetails($id = null) {
		return $this->action('zoom-in', 'edit_details', __('Edit details'), $id);
	}

	public function schedule($id = null) {
		return $this->action('calendar', "schedule", __('Schedule'), $id);
	}

	public function action($icon, $action, $label, $id = null, $secondId = null, $linkid = null, $disabled = false) {
		$destination = $disabled ? array() : array('action' => $action . '/' . $id, $secondId);

		$icon = $this->Tile->icon($icon, $label);
		return $this->actionBase($label, $icon, $destination, $linkid);
	}

	public function actionAsPicture($icon, $action, $label, $id = null, $secondId = null, $linkid = null, $disabled = false) {

		$destination = array();
		if (!$disabled) {
			if (is_array($action)) {
				$destination = $action;
			} else {
				$destination = array('action' => $action . '/' . $id, $secondId);
			}
		}

		$icon = $this->Tile->picture(array('picture_url' => $icon, 'name' => $label));
		return $this->actionBase($label, $icon, $destination, $linkid);
	}
	
	private function actionBase($label, $icon, $destination, $linkid) {
		$link = $this->Tile->link($label, $icon, $destination, array(), $linkid);
		return $this->Tile->basic(
				$link, array(
						'tileClass' => 'Transparent'
				)
		);
	}
}
?>