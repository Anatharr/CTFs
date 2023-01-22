<?php

	if (isset($_GET['p']) and !empty($_GET['p'])) {
		include $_GET['p'] . '.php';
	} else {
		header("Location: /?p=home");
		exit();
	}

?>
