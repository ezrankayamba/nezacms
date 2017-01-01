<?php
/** Constants */
define('APP_NAME', 'nezacms');


/** Auto load Classes **/

/**
 * 1.
 * App 
 */
function autoloadAppRecord($class_name) {
	$class_name = strtolower ( str_replace ( 'Record', '', $class_name ) );
	$filename = 'app/records/' . $class_name.'.php';
	//echo $filename.'<br/>';
	if (is_readable ( $filename )) {
		require_once '' . $filename;
	}
}
function autoloadAppModel($class_name) {
	$class_name = strtolower ( str_replace ( 'Model', '', $class_name ) );
	$filename = 'app/models/' . $class_name.'.php';
	//echo $filename.'<br/>';
	if (is_readable ( $filename )) {
		require_once '' . $filename;
	}
}
function autoloadAppController($class_name) {
	$class_name = strtolower ( str_replace ( 'Controller', '', $class_name ) );
	$filename = 'app/controllers/' . $class_name.'.php';
	//echo $filename.'<br/>';
	if (is_readable ( $filename )) {
		require_once '' . $filename;
	}
}
function autoloadAppView($class_name) {
	$class_name = strtolower ( str_replace ( 'View', '', $class_name ) );
	$filename = 'app/views/' . $class_name.'.php';
	//echo $filename.'<br/>';
	if (is_readable ( $filename )) {
		require_once '' . $filename;
	}
}

/**
 * 2.
 * Mvc 
 */
function autoloadMvcRecord($class_name) {
	$class_name = strtolower ( str_replace ( 'Neza', '', $class_name ) );
	$class_name = str_replace("irecord", 'i.record', $class_name);
	$filename = 'mvc/records/' . $class_name.'.php';
	//echo $filename.'<br/>';
	if (is_readable ( $filename )) {
		require_once '' . $filename;
	}
}
function autoloadMvcModel($class_name) {
	$class_name = strtolower ( str_replace ( 'Neza', '', $class_name ) );
	$class_name = str_replace("imodel", 'i.model', $class_name);
	$filename = 'mvc/models/' . $class_name.'.php';
	//echo $filename.'<br/>';
	if (is_readable ( $filename )) {
		require_once '' . $filename;
	}
}
function autoloadMvcController($class_name) {
	$class_name = strtolower ( str_replace ( 'Neza', '', $class_name ) );
	$class_name = str_replace("icontroller", 'i.controller', $class_name);
	$filename = 'mvc/controllers/' . $class_name.'.php';
	//echo $filename.'<br/>';
	if (is_readable ( $filename )) {
		require_once '' . $filename;
	}
}
function autoloadMvcView($class_name) {
	$class_name = strtolower ( str_replace ( 'Neza', '', $class_name ) );
	$class_name = str_replace("iview", 'i.view', $class_name);
	$filename = 'mvc/views/' . $class_name.'.php';
	//echo $filename.'<br/>';
	if (is_readable ( $filename )) {
		require_once '' . $filename;
	}
}
/** Database */
function autoloadDatabase($class_name) {
	$filename = 'data/db.php';
	//echo $filename.'<br/>';
	if (is_readable ( $filename )) {
		require_once '' . $filename;
	}
}
/** Application Boot */
function autoloadApplication($class_name) {
	$filename = 'mvc/factory.php';
	//echo $filename.'<br/>';
	if (is_readable ( $filename )) {
		require_once '' . $filename;
	}
}
function autoloadAppDefault($class_name) {
	$filename = 'app/controllers/default.php';
	//echo $filename.'<br/>';
	if (is_readable ( $filename )) {
		require_once '' . $filename;
	}
	$filename = 'app/views/default.php';
	//echo $filename.'<br/>';
	if (is_readable ( $filename )) {
		require_once '' . $filename;
	}
	$filename = 'app/models/default.php';
	//echo $filename.'<br/>';
	if (is_readable ( $filename )) {
		require_once '' . $filename;
	}
}

spl_autoload_register('autoloadMvcModel');
spl_autoload_register('autoloadMvcRecord');
spl_autoload_register('autoloadMvcController');
spl_autoload_register('autoloadMvcView');

spl_autoload_register('autoloadAppModel');
spl_autoload_register('autoloadAppModel');
spl_autoload_register('autoloadAppController');
spl_autoload_register('autoloadAppView');

spl_autoload_register('autoloadDatabase');
spl_autoload_register('autoloadApplication');
spl_autoload_register('autoloadAppDefault');