<?php
/*

 CForm creates html forms and returns parameters

 getForm returns a form and supports following inputfields;
 	textarea - name, label, value
 	hidden 	- name, value
 	search - name, label, value
 	number - name, label, value
 	date - name, label, value
 	text - name, label, value
 	password - name, label, value
 	checkbox - name(array), values (array), label, chosen values (array)
 	radio - name(array), values (array), label, chosen values (array)
 	select/option - name, values (array), label, selected value
 	submit - name, value

 'value' can be set to 'keep' if input values should be kept on submit (not done with SESSION but with GET and POST only)
 
 getData returns an associative array like "name" => "value" for each input field	
 
 */

class CForm {

	// MEMBERS
	private $form;
	private $data;
	private $method;

	// CONSTRUCTOR
	public function __construct() {
		$this->data = array();
		$this->form = null;
		$this->method = null;

	}

	// PUBLIC METHODS

	/**
	 * getForm returns html form
	 * @param $inputfields, array, input fields in order should be arranged like so inputfields[0]['type-of-field']['info']
	 * @param $method, string
	 * @param $class, string
 	 * @param $fieldsted, string
 	 * @return string
	 */
	public function getForm($inputfields, $method = 'POST', $class = null, $legend = null) {
		
		// Start form
		$this->form = "<form method='{$method}'";
		!isset($class) or $this->form .= " class='{$class}'";
		$this->form .= ">\n<fieldset>";
		!isset($legend) or $this->form .= "<legend>{$legend}</legend>\n";

		$this->method = ($method == 'GET') ? $_GET : $_POST ;

		foreach ($inputfields as $inputfield => $type) {

			$this->form .= isset($type['search'])		? $this->createInput($type['search'], 'search')		: null;
			$this->form .= isset($type['hidden'])		? $this->createHidden($type['hidden'])				: null;
			$this->form .= isset($type['number'])		? $this->createInput($type['number'], 'number')		: null;
			$this->form .= isset($type['date'])			? $this->createInput($type['date'], 'date')			: null;
			$this->form .= isset($type['text'])			? $this->createInput($type['text'], 'text')			: null;
			$this->form .= isset($type['password'])		? $this->createInput($type['password'], 'password')	: null;
			$this->form .= isset($type['textarea'])		? $this->createTextarea($type['textarea'])			: null;
			$this->form .= isset($type['checkbox'])		? $this->createCheckbox($type['checkbox'])			: null;
			$this->form .= isset($type['radiobutton'])	? $this->createRadiobutton($type['radiobutton'])			: null;
			$this->form .= isset($type['select'])		? $this->createSelect($type['select'])				: null;
			$this->form .= isset($type['submit']) 		? $this->createInput($type['submit'], 'submit')		: null;
		}

		$this->form .= "</fieldset></form>";
		return $this->form;
	}

	/**
	 * getData 
	 * @param $validate, boolean, set to true to validate according to type of field and using striptags() for text fields
	 * @return associative array, ordered like so 'name' => 'value'
	 */
	public function getData($validate=true) {
			
		$parameters = $this->getParameters();

		if($validate) {$parameters = $this->validate($parameters);}

 		$parameters = $this->arrangeArray($parameters);

		return $parameters;
	}

	// PRIVATE METHODS

	private function createHidden($info) {
		// Validate
		isset($info['name']) or die ('hidden inputfields must have a name');
		isset($info['value']) or die ('hidden inputfields must have a value');
		$name = htmlentities($info['name']);
		$value = htmlentities($info['value']);

		$input = '<input type="hidden" name="'. $name . '" value="' . $value . '">' . "\n";
		$this->data[]['inputs'] = $name;
		return $input;
	}

	private function createInput($info, $type) {
		// Validate
		isset($info['name']) or die ('Inputfields must have a name');
		$name = htmlentities($info['name']);

		// Keep input value
		if(isset($info['value']) && ($info['value'] == 'keep') && (isset($_POST[$name]) || isset($_GET[$name]))) {
			$value = 'value="' . htmlentities($this->method[$name]) . '"';
		}
		// Set custom input value
		else if (isset($info['value']) && ($info['value'] != 'keep')) {
			$value = isset($info['value']) ? 'value="' . htmlentities($info['value']) . '"' : null;
		}

		else {$value = null;}

		$label = isset($info['label']) ? '<label for="'. htmlentities($info['name']) .'">' .$info['label'] . "</label>\n"  : null;
		$disabled = isset($info['disabled']) && ($info['disabled'] == true) ? 'disabled' : null;
		$step = ($type == 'number') ? 'step="any"' : null;
		$input = $label . '<input id="' . $name . '" type="' . $type . '" ' . $step . ' name="' . $name . '" ' . $value . ' ' . $disabled . '>' . "\n";
		$this->data[]['inputs'] = array($name, $type);
		return $input;
	}

	private function createTextarea($info) {
		// Validate
		isset($info['name']) or die ('textareas must have a name');
		$value = isset($info['value']) ? htmlentities($info['value'])  : null;
		$label = isset($info['label']) ? '<label for="'. htmlentities($info['name']) .'">' .$info['label'] . "</label>\n" : null;
		$name = htmlentities($info['name']);
		$disabled = isset($info['disabled']) && ($info['disabled'] == true) ? 'disabled' : null;

		$textarea = $label . "<textarea name='" .$name . "' " . $disabled . ">" . $value . "</textarea>\n";
		$this->data[]['inputs'] = array($name, 'textarea');
		return $textarea;
	}

	private function createCheckbox($info) {
		// Validate
		isset($info['name']) or die ('checkboxes must have a name');
		$label = isset($info['label']) ? '<label for="'. htmlentities($info['name']) .'">' .$info['label'] . "</label>\n" : null;
		$name = $info['name'];
		$disabled = isset($info['disabled']) && ($info['disabled'] == true) ? 'disabled' : null;
		$checkboxes = '</fieldset>' . $label . "<fieldset class='checkboxes' id='" . $name . "'>";
		foreach ($info['value'] as $value) {

			$checked = in_array($value, $info['chosen']) ? 'checked' : null;
			$value =  htmlentities($value);
			$checkboxes .= "<span class='checkbox'><input type='checkbox' name='" .$name . "' value='" . $value . "' " . $checked . " " . $disabled . "><p>" . $value . "</p></span>\n";
			$this->data[]['inputs'] = array($name, 'checkbox');

		}
		$checkboxes .= "</fieldset><fieldset>";
		return $checkboxes;
	}

	private function createRadiobutton($info) {
		// Validate
		isset($info['name']) or die ('radiobutton must have a name');
		$label = isset($info['label']) ? '<label for="'. htmlentities($info['name']) .'">' .$info['label'] . "</label>\n" : null;
		$name = $info['name'];
		$disabled = isset($info['disabled']) && ($info['disabled'] == true) ? 'disabled' : null;
		$radiobutton = '</fieldset>' . $label . "<fieldset class='radiobuttons' id='" . $name . "'>";
		$i = 0;
		foreach ($info['value'] as $value) {
			$i += 1;
			$checked = in_array($value, $info['chosen']) ? 'checked' : null;
			$value =  htmlentities($value);
			$radiobutton .= "<span class='radio-".$i."'><input type='radio' name='" .$name . "' value='" . $value . "' " . $checked . " " . $disabled . "><p>" . $value . "</p></span>\n";
			$this->data[]['inputs'] = array($name, 'radiobutton');

		}
		$radiobutton .= "</fieldset><fieldset>";
		return $radiobutton;
	}

	private function createSelect($info) {
		// Validate
		isset($info['name']) or die ('select/option must have a name');
		$label = isset($info['label']) ? '<label for="'. htmlentities($info['name']) .'">' .$info['label'] . "</label>\n" : null;
		$name = $info['name'];
		$disabled = isset($info['disabled']) && ($info['disabled'] == true) ? 'disabled' : null;
		
		$selectList = $label . "<select id='" . $name . "' name='" . $name . "' " . $disabled . ">";
		foreach ($info['value'] as $value) {

			$selected = ($value == $info['selected']) ? 'selected' : null;
			$value =  htmlentities($value);
			$selectList .= "<option value='" . $value . "' " . $selected . ">" . $value . "</option>\n";
			$this->data[]['inputs'] = array($name, 'select');

		}
		$selectList .= "</select>";
		return $selectList;
	}

	private function getParameters() {
		// Parameters
		$params = array();
		
		foreach ($this->data as $number => $input) {

			if(is_array($input)){
				foreach ($input as $field => $info) {
					
					if(is_array($info)){
						
						$name = $info[0];
						$params[$name]['value'] = isset($this->method[$name]) ? $this->method[$name] : null;
						$params[$name]['type'] = $info[1];	
											
					}
					else { 
						$name = $info;
						$params[$name]['value'] = isset($this->method[$info]) ? $this->method[$info] : null;
						$params[$name]['type'] = 'hidden';
						
					}
				}
			}
		}

		return $params;
	}

	private function validate($params) {

		foreach ($params as $key => $value) {

			if($value['type'] == 'number') { 
				is_numeric($value['value']) or is_null($value['value']) or empty($value['value']) or die($key . 'must be numeric');
			}

			if(in_array($value['type'], array('textarea', 'text', 'search','password',))) { 
				strip_tags($value['value']);
			}
		}

		return $params;

	}

	private function arrangeArray($params) {
		// Arranged parameters
		$newParams = array();

		foreach ($params as $key => $value) {
			$newParams[$key] = isset($value['value']) ? $value['value'] : null;
		}
		return $newParams;
	}


}