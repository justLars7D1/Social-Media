<?php 
session_start();
if (!empty($_SESSION['user'])) {
	session_destroy();
	echo "reload";	
} else {
	header('Location: ../../login.php');
}
?>