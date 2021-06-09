<?php 

$errors = "";
$success = "";


if (isset($_POST['newTicket'])) {

	if (!empty($_POST['topic']) && !empty($_POST['message'])) {

		$fireWall = new fireWall();

		$topic = $_POST['topic'];
		$message = $_POST['message'];

		$topic = $fireWall->clearString(true,$topic);;
		$message = $fireWall->clearString(true,$message);
		
		$date = date('d').'-'.date('m').'-'.date('Y');

		if (strlen($topic) < 5) {
			$errors .= '<li>El asunto del ticket es demasiado corto</li></br>';
		} elseif (strlen($topic) >= 75) {
			$errors .= '<li>El titulo es demasiado largo</li>';
		}

		if (strlen($message) < 12) {
			$errors .= '<li>El mensaje es demasiado corto, debes proporcionar más información</li></br>';
		}

		$success .= 'Se ha creado un nuevo ticket.';

	} elseif(empty($_POST['topic']) && empty($_POST['message'])) {
		$errors .= '<li>Debes rellenar todos los campos.</li>';
	}
}
?>