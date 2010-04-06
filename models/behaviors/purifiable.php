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
	var $_settings = array(
		'fields' => array(),
		'overwrite' => false,
		'affix' => '_clean',
		'affix_position' => 'suffix',
		'config' => array(
			'HTML' => array(
				'DefinitionID' => 'purifiable',
				'DefinitionRev' => 1,
				'TidyLevel' => 'heavy',
				'Doctype' => 'XHTML 1.0 Transitional'
			),
			'Core' => array(
				'Encoding' => 'ISO-8859-1'
			),
		),
		'customFilters' => array(
		)
	);

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
		$this->settings[$model->alias] = array_merge_recursive($this->settings[$model->alias], (array)$config);
	}

/**
 * Before save callback
 *
 * @param object $model Model using this behavior
 * @return boolean True if the operation should continue, false if it should abort
 * @access public
 */
	function beforeSave(&$model) {
		foreach($this->settings[$model->alias]['fields'] as $fieldName) {
			if (!isset($model->data[$model->alias][$fieldName]) or empty($model->data[$model->alias][$fieldName])) {
				continue;
			}

			if ($this->settings[$model->alias]['overwrite']) {
				$model->data[$model->alias][$fieldName] = $this->clean($model, $model->data[$model->alias][$fieldName]);
			} else {
				$affix = $this->settings[$model->alias]['affix'];
				$affixedFieldName = "{$fieldName}{$affix}";
				if ($this->settings[$model->alias]['affix_position'] == 'prefix') {
					$affixedFieldName = "{$affix}{$fieldName}";
				}
				$model->data[$model->alias][$affixedFieldName] = $this->clean($model, $model->data[$model->alias][$fieldName]);
			}
		}
		return true;
	}

	function clean(&$model, $field) {
		App::import('Vendor', 'Purifiable.htmlpurifier/htmlpurifier');
		//the next few lines allow the config settings to be cached 
		$config = HTMLPurifier_Config::createDefault();
		foreach ($this->settings[$model->alias]['config'] as $namespace => $values) {
			foreach ($values as $key => $value) {
				$config->set("{$namespace}.{$key}", $value);
			}
		}

		if($this->settings[$model->alias]['customFilters']) {
			$filters = array();
			foreach($this->settings[$model->alias]['customFilters'] as $customFilter) {
				$filters[] = new $customFilter;
			}
			$config->set('Filter.Custom', $filters);
		}

		$cleaner =& new HTMLPurifier($config);
		return $cleaner->purify($field);
	}
	
}
?>