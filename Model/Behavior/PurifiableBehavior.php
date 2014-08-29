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
	public $_settings = array(
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
				'Encoding' => 'UTF-8'
			),
			'AutoFormat' => array(
				'RemoveSpansWithoutAttributes' => true,
				'RemoveEmpty' => true
			),
		),
		'customFilters' => array(
		)
	);

/**
 * Initiate Purifiable behavior
 *
 * @param object $model instance of model
 * @param array $config array of configuration settings.
 * @return void
 */
	public function setup(Model $model, $config = array()) {
		$this->settings[$model->alias] = $this->_settings;

		//merge custom config with default settings
		$this->settings[$model->alias] = Hash::merge($this->settings[$model->alias], (array)$config);
	}

/**
 * Before save method. Called before all saves
 *
 * Handles purifying data
 *
 * @param Model $model Model instance
 * @param array $options Options passed from Model::save().
 * @return boolean
 */
	public function beforeSave(Model $model, $options = array()) {
		foreach ($this->settings[$model->alias]['fields'] as $fieldName) {
			if (empty($model->data[$model->alias][$fieldName])) {
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

/**
 * Sanitizes content
 *
 * @param Model $model Model instance
 * @param string $fieldValue value that will be sanitized
 * @return boolean
 */
	public function clean(Model $model, $fieldValue) {
		if (!class_exists('HTMLPurifier')) {
			App::import('Vendor', 'htmlpurifier/htmlpurifier');
		}

		//the next few lines allow the config settings to be cached
		$config = HTMLPurifier_Config::createDefault();
		foreach ($this->settings[$model->alias]['config'] as $namespace => $values) {
			foreach ($values as $key => $value) {
				$config->set("{$namespace}.{$key}", $value);
			}
		}

		if ($this->settings[$model->alias]['customFilters']) {
			$filters = array();
			foreach ($this->settings[$model->alias]['customFilters'] as $customFilter) {
				$filters[] = new $customFilter;
			}
			$config->set('Filter.Custom', $filters);
		}

		$cleaner = new HTMLPurifier($config);
		return $cleaner->purify($fieldValue);
	}

}
