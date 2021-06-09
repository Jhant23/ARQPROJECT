<?php 	

$errors = '';

if (isset($_POST['newComment'])) {

	if (!empty($_POST['comment'])) {

		$fireWall = new fireWall();

		$comment = $_POST['comment'];
		$comment = htmlspecialchars($comment);
		$comment = $fireWall->clearString(true,$comment);

		if (strlen($comment) <= 4) {
			$errors .= 'El comentario es demásiado corto.';
		}

		$ticketID = $_GET['ticketid'];
		$dtime = DATE;
		$hour = HOUR;

		if (!(int)$_GET['ticketid']) {
			$errors .= "<li>No se pudo insertar el comentario</li>";
		}

	} else {
		$errors .= 'Por favor inserta un comentario';
	}
}

?>
