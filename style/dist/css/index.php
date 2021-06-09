<?php
if (isset($_SESSION['user'])) {
	header('Location: chooseproject.php');
} else {
	header('Location: ../../index.php');
}
?>