<?php
/* SVN FILE: $Id$ */
/**
 * Requests collector.
 *
 *  This file collects requests if:
 *	- no mod_rewrite is avilable or .htaccess files are not supported
 *	-/public is not set as a web root.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 *  Get Cake's root directory
 */
//	define('APP_DIR', 'app');
//	define('DS', DIRECTORY_SEPARATOR);
//	define('ROOT', dirname(__FILE__));
//	define('WEBROOT_DIR', 'webroot');
//	define('WWW_ROOT', ROOT . DS . APP_DIR . DS . WEBROOT_DIR . DS);
/**
 * This only needs to be changed if the cake installed libs are located
 * outside of the distributed directory structure.
 */
require 'webroot' . DIRECTORY_SEPARATOR . 'index.php';
?>