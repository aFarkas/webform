<?php
/**
 * @package gossi\webform
 */
namespace gossi\webform;

/**
 * Represents a ComboBox
 */
class ComboBox extends Control {

	private $options = array();
	
	/**
	 * Adds an option to the receiver
	 * 
	 * @param Option $option the new option
	 */
	public function addOption(Option $option) {
		if (!in_array($option, $this->options)) {
			$this->options[] = $option;
		}
	}

	/**
	 * Creates an option and adds it to the receiver
	 * 
	 * @param String $value
	 * @param String $label
	 * @param (boolean) $checked
	 * @param (String) $id
	 */
	public function createOption($value, $label, $checked = false, $id = null) {
		// by incoming request
		$val = $this->getRequestValue();
		if ($val != null && $val == $value) {
			$checked = true;
		} else if ($val != null && $val != $value) {
			$checked = false;
		}

		$option = new Option();
		$option->setValue($value);
		$option->setLabel($label);
		$option->setChecked($checked);

		if (!is_null($id)) {
			$option->setId($id);
		}
		$this->options[] = $option;

		return $option;
	}

	public function toXML() {
		$xml = $this->createXML('ComboBox');
		$root = $xml->documentElement;

		foreach($this->options as $option) {
			$import = $xml->importNode($option->toXML()->documentElement, true);
			$root->appendChild($import);
		}

		$xml->appendChild($root);

		return $xml;
	}
}
?>