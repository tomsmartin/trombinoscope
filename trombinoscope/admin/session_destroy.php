<?php
	session_start();
	session_destroy();
	header('location: /trombinoscope/index.php');
	exit;
?>