<?php

	session_start();
	unset($_SESSION['user']);
	header('Location: /?p=home');

?>
