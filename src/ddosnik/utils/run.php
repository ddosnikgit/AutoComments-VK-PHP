<?php

	start();

	function makeClassLoader() {
		require_once(BOT_PATH . "src/ddosnik/WallPost.php");
	}

	function prepare(){
		define('BOT_PATH', realpath(getcwd()) . DIRECTORY_SEPARATOR);
		define('START_TIME', time());
	}

	function start() {
		prepare();
		makeClassLoader();

		new \ddosnik\WallPost();
	}
?>
