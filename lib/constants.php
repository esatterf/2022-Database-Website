<?php

define ('DEBUG', false);

$_SERVER = filter_input_array (INPUT_SERVER, FILTER_SANITIZE_STRING);
define ('SERVER', $_SERVER['SERVER_NAME']);

define ('DOMAIN', '//' . SERVER);

define ('PHP_SELF', $_SERVER['PHP_SELF']);
define ('PATH_PARTS', pathinfo(PHP_SELF));

define ('BASE_PATH', DOMAIN . PATH_PARTS ['dirname'] . '/');
define ('LIB_PATH', 'lib/');

if(DEBUG){
	echo DOMAIN;
	echo PHP_SELF;
	echo PATH_PARTS;
	echo BASE_PATH;
	echo LIB_PATH;
}

?>
