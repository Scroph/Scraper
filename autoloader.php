<?php
!defined('DS') && define('DS', DIRECTORY_SEPARATOR);

spl_autoload_register(function($class)
{
	$path = str_replace('\\', DS, $class);
	$path = __DIR__.DS.$path.'.class.php';
	$path = strtolower($path);

	if(is_readable($path))
	{
		require_once $path;
	}
});