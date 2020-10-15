<?php
error_reporting(E_ALL & ~E_NOTICE);
date_default_timezone_set('Asia/Ho_Chi_Minh');
require_once 'define.php';
require_once 'define_notice.php';
function __autoload($clasName)
{
	require_once LIBRARY_PATH . "{$clasName}.php";
}

Session::init();

$bootstrap = new Bootstrap();
$bootstrap->init();
