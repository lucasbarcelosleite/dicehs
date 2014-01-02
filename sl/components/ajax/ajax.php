<?

switch (WMain::$task) {
	default:
		require "ajax.".WMain::$task.".php";
		break;
}

?>