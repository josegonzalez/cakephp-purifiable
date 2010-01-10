<?php
/**
 * Purifiable Model Behavior
 * 
 * Scrubs fields clean of sass
 *
 * @package default
 * @author Jose Diaz-Gonzalez
 **/
class PurifiableBehavior extends ModelBehavior {

/**
 * Contains configuration settings for use with individual model objects.
 * Individual model settings should be stored as an associative array, 
 * keyed off of the model name.
 *
 * @var array
 * @access public
 * @see Model::$alias
 */
	var $settings = array(
		'fields' => array(),
		'overwrite' => false,
		'affix' => '_clean',
		'affix_position' => 'suffix');

/**
 * Initiate Purifiable Behavior
 *
 * @param object $model
 * @param array $config
 * @return void
 * @access public
 */
	function setup(&$model, $config = array()) {
		$this->settings[$model->alias] = $this->_settings;

		//merge custom config with default settings
		$this->settings[$model->alias] = array_merge($this->settings[$model->alias], (array)$config);
	}

/**
 * Before save callback
 *
 * @param object $model Model using this behavior
 * @return boolean True if the operation should continue, false if it should abort
 * @access public
 */
	function beforeSave(&$model) {
		return true;
	}
}
?>