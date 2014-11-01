<?php
class I18nRoute extends CakeRoute {
/**
 * Constructor for a Route
 * Add a regex condition on the lang param to be sure it matches the available langs
 *
 * @param string $template Template string with parameter placeholders
 * @param array $defaults Array of defaults for the route.
 * @param string $params Array of parameters and additional options for the Route
 * @return void
 * @access public
 */
	public function __construct($template, $defaults = array(), $options = array()) {
		$options = array_merge((array)$options, array(
			'language' => join('|', Configure::read('Config.languages'))
		));
		parent::__construct($template, $defaults, $options);
	}

/**
 * Attempt to match a url array.  If the url matches the route parameters + settings, then
 * return a generated string url.  If the url doesn't match the route parameters false will be returned.
 * This method handles the reverse routing or conversion of url arrays into string urls.
 *
 * @param array $url An array of parameters to check matching with.
 * @return mixed Either a string url for the parameters if they match or false.
 * @access public
 */
	public function match($url) {
		if (empty($url['language'])) {
                    
			$url['language'] = Configure::read('Config.language');
		}
		return parent::match($url);
	}

}