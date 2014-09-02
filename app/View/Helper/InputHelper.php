
<?php

/**
 * InputHelper
 *
 *
 * @package       app.View.Helper
 */
class InputHelper extends AppHelper {

	public $helpers = array('Html', 'Form', 'MyForm', 'Tile', 'JSSubmit', 'User');
	private $datePicker = 'datepicker';

	private $deletePostFormId = 'post_52b2bc87e06bd718709271';
	private $unassignPostFormId = 'post_52b2bc87e06bd718709272';

	// ===========================================================================
	// ===================== Refactoring =========================================

	/**
	 * Creates a Fieldset form
	 *
	 * <form>
	 *      <fieldset>
	 *          ...
	 *      </fieldset>
	 * </form>
	 *
	 * @param array $fields   Fields, incl. type, label ...
	 * @param array $buttons  Buttons for Form, e.g. submit
	 * @param array $dynamics optional for dynamic content
	 * @return String         The fieldset
	 */
	public function createForm($model, $fields, $buttons = array(), $dynamics = '') {
		$target = $this->Form->create($model, array(
				'id' => $this->JSSubmit->modelFormId($model),
				'inputDefaults' => array(
						'label' => false,
						'div' => false
				)
		)
		);

		$target .= $this->createFieldset($fields, $buttons);
		$target .= $dynamics;

		$target .= $this->Form->end();

		$target .= $this->createPostForms($buttons);

		return $target;
	}

	/**
	 * Creates a Fieldset
	 *
	 * <form>
	 *      <fieldset>
	 *          ...
	 *      </fieldset>
	 * </form>
	 *
	 * @param array $fields   Fields, incl. type, label ...
	 * @param array $buttons  Buttons for Form, e.g. submit
	 * @param array $dynamics optional for dynamic content
	 * @return String         The fieldset
	 */

	public function createFieldset($fields, $buttons) {
		$fieldset = "<fieldset>";

		// fields
		foreach ($fields as $field) {
			switch ($field['type']) {
				case 'selection' :
					$fieldset .= $this->createSelectionField($field);
					break;
				case 'text' : {
					$value = null;
					if (!empty($field['value'])) {
						$value = $field['value'];
					}
					$fieldset .= $this->createTextInputField($field['id'], $field['label'], $field['placeholder'], $value, false);
					break;
				}
				case 'password' :
					$fieldset .= $this->createPasswordInputField($field['id'], $field['label'], $field['placeholder'], false);
					break;
				case 'hidden' :
					$fieldset .= $this->createHiddenInputField($field['id']);
					break;
				case 'file' :
					$fieldset .= $this->createFileInputField($field['id'], $field['label'], $field['placeholder']);
					break;
				case $this->datePicker :
					$fieldset .= $this->createDatePickerInputField($field['id'], $field['label'], $field['placeholder'], $field['value']);
					break;
                                case 'hr' : 
                                        $fieldset .= "<hr/>";
                                        break;
			}
		}

		$fieldset .= "<div align='right'>";

		// buttons
		foreach ($buttons as $button) {
			switch ($button['type']) {
                                case 'link' : $fieldset .= $this->createLinkButton($button['id'], $button['text'], $button['destination']);
				break;
				case 'ok' :
				case 'save' : {
					$fieldset .= $this->createSubmitButton($button);
				}
				break;
				case 'delete' : {
					if (!isset($button['message'])) {
						$button['message'] = __('Continue deleting?');
					}
					$button['style'] = 'danger';
					$button['post_form_id'] = $this->deletePostFormId;
					$button['icon'] = 'delete';
					$fieldset .= $this->createFormButton($button);
				}
				break;
				case 'unassign' :  {
					if (!isset($button['message'])) {
						$button['message'] = __('Continue unassign?');
					}
					$button['style'] = 'warning';
					$button['post_form_id'] = $this->unassignPostFormId;
					$button['icon'] = 'unassign';
					$fieldset .= $this->createFormButton($button);
				}
				break;
				case 'select_all' : $fieldset .= $this->createSelectAllButton();
				break;
				case 'toggle_selection' : $fieldset .= $this->createToggleSelectionButton();
				break;
				default: $fieldset .= $this->createDefaultButton($button);;
				break;
			}
		}

		$fieldset .= "</div>";

		$fieldset .= "</fieldset>";

		$target = $fieldset;

		return $target;
	}

	/**
	 * Creates buttons for form
	 *
	 * @return The buttons
	 */
	public function createDeleteSaveButtons($deleteDestination = array()) {
		$buttons[] = array('type' => 'delete', 'text' => __('Delete'), 'destination' => $deleteDestination);
		$buttons[] = array('type' => 'save', 'text' => __('Save'));
		return $buttons;
	}

	/**
	 * Creates buttons for form
	 *
	 * @return The buttons
	 */
	public function createSelectAllSaveButtons() {
		$buttons[] = array('type' => 'select_all');
		$buttons[] = array('type' => 'save', 'text' => __('Save'));
		return $buttons;
	}

	/**
	 * Creates buttons for form
	 *
	 * @return The buttons
	 */
	public function createSelectAllDeleteSaveButtons($deleteDestination = array()) {
		$buttons[] = array('type' => 'select_all');
		$buttons[] = array('type' => 'delete', 'text' => __('Delete'), 'destination' => $deleteDestination);
		$buttons[] = array('type' => 'save', 'text' => __('Save'));
		return $buttons;
	}

	public function createSaveButton() {
		$buttons[] = array('type' => 'save', 'text' => __('Save'));
		return $buttons;
	}

	/**
	 * Creates a search field that does the JavaScript function doFilter()
	 * on each released key
	 *
	 * @param $id           An id for JavaScript
	 * @return String       The filter field
	 */
    public function createFilterField($id, $options=array()) {
        $options = $this->fillDefaults($options, array('filterFunction' => 'contentRequest'));
        $filterFunction = $options['filterFunction'];

		$result = "<div class='filter'>";
		$result .= $this->basicInputField($id, null, 'text', 'Transparent', null, null, 'btn-filter', false, 'txt-filter');
        $result .= "</div>
            <script>
                $('#$id').keyup(function () {
                   $filterFunction($('#$id').val());
                });
             </script>";
        
		return $result;
	}

    /**
     * Creates a field with selectable options
     *
     * @param array $field
     * @return String   A selection field
     */
    private function createSelectionField($field) {
        $modelName = Inflector::singularize($this->params['controller']);

        $label = $field['label'];
        if ($this->MyForm->mandatory($modelName, 'validates', $field['id']) != null) {
            $label .= " *";
        }

        $result = "<label>" . $label . "</label>";

        $tmp = $this->kindOfTextFieldsHelper($field);
        $field = $tmp['field'];
        $inp = $tmp['inp'];

        $result .= $this->Form->input($field['id'], $inp);
        return $result;
    }

    /**
	 * @see basicInputField()
	 * @return String   An input field for text
	 */
	private function createTextInputField($id, $label, $hint, $preInsertedText = null, $disabled = false) {
		return $this->basicInputField($id, $label, 'text', null, $hint, $preInsertedText, 'btn-clear', $disabled);
	}

	/**
	 * @see basicInputField()
	 * @return String   A hidden input field
	 */
	private function createHiddenInputField($id) {
		return $this->basicInputField($id, null, 'hidden', null, null, null, null, false);
	}

	/**
	 * @see basicInputField()
	 * @return String   An input field for passwords
	 */
	private function createFileInputField($id, $label, $hint, $disabled = false) {
		return $this->basicInputField($id, $label, 'file', null, $hint, null, 'btn-file', $disabled);
	}

	/**
	 * @see basicInputField()
	 * @return String   An field for file selection
	 */
	private function createPasswordInputField($id, $label, $hint, $disabled = false) {
		return $this->basicInputField($id, $label, 'password', null, $hint, null, 'btn-reveal', $disabled);
	}
	
	/**
	 * @see basicInputField()
	 * @return String   An field for datepicker selection
	 */
	private function createDatePickerInputField($id, $label, $hint, $preInsertedText = null) {
		return $this->basicInputField($id, $label, 'text', null, $hint, $preInsertedText, null, false, null, "data-format='$this->dateFormat'", 'datepicker');
	}
	
    /**
     * @param $id (required): column in database / mapping to model
     * @param $type (required): text, password or file
     * @param $state (optional): warning-state, error-state, info-state or success-state
     * @param $inlineButtonClass (optional): btn-clear, btn-reveal or btn-file
     *
     * @param $hint (optional): a hint inside field
     *                          1) automatically removed by typing
     *                          2) $preInsertedText overrides this value
     * @param $preInsertedText (optional): the value of this field prallocated
     * @param $disabled (optional): disables the field, no editing
     * @param $colorCSS (optional): A css-class for formating/coloring inputfield
     * @param $scriptComponent (optional): onabort, onblur, onchange, onclick, ondblclick, onerror,
     *                                     onfocus, onkeydown, onkeypress, onkeyup, onload, onmousedown,
     *                                     onmousemove, onmouseout, onmouseover, onmouseup, onreset,
     *                                     onselect, onsubmit, onunload, javascript
     */
    private function basicInputField($id, $label, $type, $state, $hint, $preInsertedText, $inlineButtonClass, $disabled, $colorCSS = null, $scriptComponent = null, $dataRole = 'input-control') {

        $modelName = Inflector::singularize($this->params['controller']);

        if ($this->MyForm->mandatory($modelName, 'validates', $id) != null) {
            $label .= " *";
        }

        $result = "<label>" . $label . "</label>
				<div class='input-control " . $type . " " . $state . "' data-role='$dataRole' " . $scriptComponent . ">";

        // Result: <input placeholder='".$hint."' value='".$preInsertedText."' type='text'>";
        $params = array('placeholder' => $hint,
            'type' => $type,
            'value' => $preInsertedText,
            'disabled' => $disabled,
            'div' => false,
            'class' => $colorCSS,
            'label' => false
        );

        if ($type == 'password') {
            $params['autocomplete'] = 'off';
        }

        // AK: Dirty, but necessary as the form changes id
        if (isset($inlineButtonClass)) {
            if ($inlineButtonClass == 'btn-filter') {
                $params['id'] = $id;
            }
        }

        $result .= $this->Form->input($id, $params);

        if (isset($inlineButtonClass)) {
            $result .= "<button type='button' class='" . $inlineButtonClass . "'></button>";
        }
        $result .= " </div>";

        return $result;
    }

    /**
	 * @see basicButton()createForm
	 * @return String   A button for submit of form
	 */
	private function createSubmitButton($button) {
		if (isset($button['message'])) {
			$message = $button['message'];
			$button['targetJSFunction'] = 'if (confirm("'.$message.'")) {submit();} event.returnValue = false; return false;';
		}
		
		$type = 'submit';
		if (isset($button['targetJSFunction'])) {
			$type = 'button';
		}
		$button = $this->fillDefaults(
				$button,
				array(
						'text' => __('Save'),
						'targetJSFunction' => ''
				)
		);
		return $this->basicButton('submitTileId', array('button', 'large', 'success', 'submit'), $button['text'], $type, $button['targetJSFunction']);
	}

	/**
	 * @see basicButton()
	 * @return String   A button for post forms
	 */
	private function createFormButton($button) {
		$buttonText = $button['text'];
		$message = $button['message'];
		$style = $button['style'];
		$targetJSFunction = 'if (confirm("'.$message.'")) {document.'. $button['post_form_id'].'.submit();} event.returnValue = false; return false;';

		return $this->basicButton('deleteTileId', array('button', 'large', $style, $button['icon']), $buttonText, 'button', $targetJSFunction);
	}

	public function createPostForms($buttons) {
		$postForms = '';
		foreach ($buttons as $button) {
			switch ($button['type']) {
				case 'delete' : {
					$button['post_form_id'] = $this->deletePostFormId;
					$postForms .= $this->createPostForm($button);
				}
				break;

				case 'unassign' : {
					$button['post_form_id'] = $this->unassignPostFormId;
					$postForms .= $this->createPostForm($button);
				}
				break;
			}
		}
		return $postForms;
	}

	private function createPostForm($button) {
		$postForm = $this->Form->create(
				null,
				array(
						'id' => $button['post_form_id'],
						'name' => $button['post_form_id'],
						'inputDefaults' => array('label' => false, 'div' => false),
						'type' => 'post',
						'url' => $button['destination']
				)
		);
		$postForm .= $this->Form->end();
		return $postForm;
	}

	/**
	 * @see basicButton()
	 * @return String A button for select all tiles
	 */
	private function createSelectAllButton() {
		return $this->basicButton('selectAll', array('button', 'large', 'primary', 'select_all'), __('Select all'), 'button', 'toggleSelectAll()');
	}

	/**
	 * @see basicButton()
	 * @return String A button for toggle selection tiles
	 */
	private function createToggleSelectionButton() {
		return $this->basicButton('toggleSelection', array('button', 'large', 'primary', 'toggle_selection'), __('Toggle selection'), 'button', 'toggleSelection()');
	}

	/**
	 * @see basicButton()
	 * @return String   A default button
	 */
	private function createDefaultButton($button) {
		$button = $this->fillDefaults(
				$button,
				array(
						'class' => '',
						'text' => __('Press'),
						'targetJSFunction' => ''
				)
		);
		return $this->basicButton('', array('button', 'large', 'inverse', $button['class']), $button['text'], 'button', $button['targetJSFunction']);
	}

	/**
	 * @see basicButton()
	 * @return String   A link
	 */
	private function createLinkButton($id, $buttonText, $destination) {
		$link = $this->Html->link(
				$buttonText,
				$destination,
				array(
                                    'id' => $id,
				    'style' => 'padding: 20px',
				    'title' => $buttonText
				)
		);
		return $link;
	}

	/**
	 *
	 * @param $id (optional): only needed for jScript
	 * @param array $buttonClasses (required): button, command-button, image-button, shortcut
	 *                                         There are a lot of additional classes available @see Metro-UI
	 * @param topic
	 * @return string
	 */
	public function basicButton($id, $buttonClasses, $topic, $type = 'button', $targetJSFunction = '') {
		$classes = '';
		foreach ($buttonClasses as $class) {
			$classes .= $class . " ";
		}
		$result = "<button id='" . $id . "' class='" . $classes . "' type='" . $type . "'";
		if (!empty($targetJSFunction)) {
			$result .= " onclick='" . $targetJSFunction . "'";
		}
		$result .= ">";
		$result .= $topic;
		$result .= "</button>";
		return $result;
	}

	/**
	 *
	 * @param $id (optional): only needed for jScript
	 * @param array $buttonClasses (required): button, command-button, image-button, shortcut
	 *                                         There are a lot of additional classes available @see Metro-UI
	 * @param topic
	 * @return string
	 */
	private function basicDiv($id, $buttonClasses, $topic, $type = 'button', $targetJSFunction = '') {
		$classes = '';
		foreach ($buttonClasses as $class) {
			$classes .= $class . " ";
		}
		$result = "<div id='" . $id . "' class='" . $classes . "' type='" . $type . "' onclick='" . $targetJSFunction . "'>";
		$result .= $topic;
		$result .= "</div>";
		return $result;
	}

	// ===========================================================================
	// ===========================================================================
	// ===========================================================================
	// ====================== ADD/EDIT Masken ====================================


	public function createIdInputFieldParams() {
		return $this->createTextInputFieldParams('id', '', null);
	}

	/**
	 * Reused after refactoring
	 */
	public function createTextInputFieldParams($id, $label = '', $value = '', $placeholder = '') {
		return $this->createInputFieldParams($id, $label, 'text', false, null, false, array(), $value, $placeholder);
	}

	public function createDatePickerFieldParams($label, $id = null, $value = null) {
		if ($id == null) {
			$id = $this->datepicker;
		}
		return $this->createInputFieldParams($id, $label, $this->datePicker, false, null, false, array(), $value);
	}

	public function createChoiseFieldParams($id, $model, $label = '', $enabled = false) {
		return array(
				'id' => $id,
				'type' => 'choise',
				'label' => $label,
				'enabled' => $enabled,
				'model' => $model,
				'dataField' => $id,
				'text' => ''
		);
	}

	/**
	 * Reused after refactoring
	 */
	public function createInputFieldParams($id, $label, $type, $disabled = false, $selection = null, $emptySelectable = false, $options = array(), $value = null, $placeholder = '') {
		return array(
				'id' => $id,
				'label' => $label,
				'type' => $type,
				'disabled' => $disabled,
				'selection' => $selection,
				'emptySelectable' => $emptySelectable,
				'options' => $options,
				'value' => $value,
				'placeholder' => $placeholder
		);
	}

	/**
	 * Creates a form div element and adds the hidden id field, used in edit views.
	 *
	 * @param array $model the model name,
	 * if set used to support form submit,
	 * if set to an empty string, the JS submit function is used
	 * @param array $fields list of field parameters
	 * @return string the form div
	 */
	public function formDivWithId($model = null, $fields = array()) {
		$fields[] = $this->createIdInputField();
		return $this->formDiv($model, $fields);
	}

	//@@ To be refactored @@
	/**
	* Creates a form div element, used in add views.
	*
	* @param array $model the model name,
	* if set to an empty string, the JS submit function is used, otherwise the form submit
	* @param array $fields list of field parameters
	* @return string the form div
	*/
	public function formDiv($model = null, $fields = array()) {

		$target = '<div id="hgl-add" class="exampleXXX">';
		$target .= $this->Form->create($model, array(
				'id' => $this->JSSubmit->modelFormId($model),
				'inputDefaults' => array(
						'label' => false,
						//'div' => false
				)
		));

		$target .= '<table class="table striped">
				<tbody>';

		foreach ($fields as $i => $field) {
			if ($field['id'] == 'id') {
				$target .= $this->Form->input($field['id']);
			} else {
				$target .= $this->typeField($field);
			}
		}

		$target .= '</tbody>
				</table>';

		$target .= $this->JSSubmit->enter($model);

		$target .= '</div>';

		return $target;
	}

	private function typeField($field) {
		switch ($field['type']) {
			case 'choise' :
				return $this->choiseFields($field);
			case 'choose' :
				return $this->chooseFields($field);
			case 'switch' :
				return $this->switchFields($field);
			default:
				return $this->kindOfTextFields($field);
		}
	}

	/**
	 * Extracted while Refactoring
	 *
	 * @param type $field
	 * @return type
	 */
	private function kindOfTextFieldsHelper($field) {
		$inp = array(
				'selected' => $field['selection'],
				'label' => false,
				'disabled' => $field['disabled']
		);

		switch ($field['type']) {
			case 'text' :
				$inp['div'] = array('class' => 'input-control text', 'data-role' => 'input-control');
				break;
			case 'password' :
				$inp['autocomplete'] = 'off';
				$inp['type'] = 'password';
				$inp['div'] = array('class' => 'input-control password', 'data-role' => 'input-control');
				break;
			case 'selection' :
				$inp['div'] = array('class' => 'input-control select', 'data-role' => 'input-control');
				break;
			case $this->datePicker :
				$inp['id'] = $field['id'];
				$inp['readonly'] = 'readonly';
				$inp['div'] = array('class' => 'input-control text', 'data-role' => 'datepicker', 'data-format' => $this->dateFormat);
				break;
		}


		if ($field['value'] != null) {
			$inp['value'] = $field['value'];
		}

		if ($field['emptySelectable']) {
			$inp['empty'] = true;
		}
		if ($field['options']) {
			$inp['options'] = $field['options'];
		}

		$inp['placeholder'] = $field['placeholder'];

		return array('field' => $field, 'inp' => $inp);
	}

	private function kindOfTextFields($field) {
		$tmp = $this->kindOfTextFieldsHelper($field);
		$field = $tmp['field'];
		$inp = $tmp['inp'];

		return $this->createTableElement($field, $inp);
	}

	private function createTableElement($field, $inp) {
		return "<tr>
				<td class='text-left' style='vertical-align:middle;'><strong>" . $field['label'] . ":</strong></td>
						<td>" . $this->Form->input($field['id'], $inp) . "</td>
								</tr>";
	}

	private function chooseFields($fields) {
		$model = 'BaseStation';
		$dataFieldConcat = 'AquireData';
		$dataField = 'aquire_data';
		$result = "<tr>
				<td class='text-left' style='vertical-align:middle;'><strong>" . $fields['label'] . "</strong></td>
						<td>
						<div class='input-control radio default-style inline-block' data-role='input-control'>";
		foreach ($fields['buttons'] as $field) {
			$result .= "<label class='inline-block'>
					<input id='" . $model . $dataFieldConcat . "' name='data[" . $model . "][" . $dataField . "]' ";
			if ($field['checked']) {
				$result .= "checked='' ";
			}
			$result .= "type='radio'>
					<span class='check'></span>" . $field['name'] .
					"</label>";
		}
		$result .= "</div></td></tr>";
		return $result;
	}

	private function choiseFields($fields) {
		$model = $fields['model'];
		$dataField = $fields['dataField'];
		$dataFieldConcat = Inflector::camelize($dataField);
		$text = $fields['text'];

		$result = "<tr>
				<td class='text-left' style='vertical-align:middle;'><strong>" . $fields['label'] . "</strong></td>
						<td>
						<div class='input-control checkbox' data-role='input-control'>
						<label class='inline-block'>
						<input id='" . $model . $dataFieldConcat . "' name='data[" . $model . "][" . $dataField . "]' ";
		if ($fields['enabled']) {
			$result .= "checked='checked' ";
		}
		$result .= " type='checkbox'>
				<span class='check'></span>" .
				$text
				. "</label>
						</div>
						</td>
						</tr>";
		return $result;
	}

	private function switchFields($field) {
		$model = 'BaseStation';
		$dataFieldConcat = 'AquireData';
		$dataField = 'aquire_data';
		$value = $this->request->data[$model][$dataField];

		$result = "<tr>
				<td class='text-left' style='vertical-align:middle;'><strong>" . $field['label'] . "</strong></td>
						<td class='text-left' style='vertical-align:middle;'>
						<div class='input-control switch' data-role='input-control'>
						<label class='inline-block' style='margin-right: 20px'>
						<input id='" . $model . $dataFieldConcat . "' value='" . $value . "' ";
		if ($value == 1) {
			$result .= "checked='false' ";
		}
		$result .= "type='checkbox' name='data[" . $model . "][" . $dataField . "]'>
				<span class='check'></span>
				</label>
				</div>
				</td>
				</tr>";
		return $result;
	}

	public function dynamicTextField($id, $label, $value = '', $options = array()) {
		$options = $this->fillDefaults($options, array(
				'maxlength' => 255,
				'type' => 'text',
				'required' => false
		));
		$maxlength = $options['maxlength'];
		$required = $options['required'] ? "required='required'" : "";
		return "
		<div class='input-control text' data-role='input-control'>
		<input maxlength='$maxlength' type='text' value='$value' id='$id' placeholder='$label' $required>
		<button class='btn-clear' tabindex='-1' type='button'></button>
		</div>
		";
	}

	public function dynamicForm($contents) {
		$width = '200px';
		return "
		<div style='width:$width'>" .
		implode(" ", $contents) . "
				</div>";
	}

	//@@ reused @@
	public function dynamicSelectionField($id, $possibilities, $selected = null) {
		return "
		<div id='$id' class='input-control select' data-role='input-control'>
		<select>" .
		call_user_func(function ($possibilities) use ($selected) {
			$r = "";
			foreach ($possibilities as $i => $p) {
				$r .= "<option value='$i'" . ($i == $selected ? " selected='selected'" : "") . "> $p </option>";
			}
			return $r;
		}, $possibilities) . "
				</select>
				</div>
				"
				;
	}

	public function dynamicDatePicker($id, $label, $default = null) {
		return "
		<div id='$id' class='input-control text'>
		<input type='text'>
		<button class='btn-date'></button>
		</input>
		</div>
		<script>" .
		($default != null ? "$('input', '#$id').val('$default')" : "") . "
		$('#$id').datepicker();
		</script>
		";
	}


    public function filterFunctionJS($functionName, $entityClass){
        return "
            function $functionName(element){
               var xp = new RegExp(element, 'i');
               $('.$entityClass').each(function (i, v) {
                   var regex = /<br\s*[\/]?>/gi;
                   $(v).html($(v).html().replace(regex, '\\n\\n'));
                   $(v).removeClass('filterVisible');
                   $(v).removeClass('filterHidden');
                   if($(v).text().search(xp) != -1){
                       $(v).show();
                       $(v).addClass('filterVisible');
                   }
                   else{
                       $(v).hide();
                       $(v).addClass('filterHidden');
                   }
               });
        }";
    }
}
?>
