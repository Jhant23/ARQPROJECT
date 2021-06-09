<?php 
  $uErrors = '';
  $uSuccess = '';

  if (isset($_POST['saveChanges'])) {
  	 if (!empty($_POST['message_edited'])) {
  	 	 
  	 	 $fireWall = new fireWall();

  	 	 $message =  $_POST['message_edited']; 
  	 	 $message = htmlspecialchars($message);
  	 	 $message = $fireWall->clearString(true,$message);

  	 	 if (strlen($message) < 6) {
  	 	 	$uErrors .= 'No se pudo actualizar el ticket: </br></br> <li>El mensaje es demasiado corto, debes proporcionar más información.</li>';
  	 	 }

       $uSuccess .= 'Se ha actualizado el ticket correctamente.';
  	 } else {
  	 	$uErrors .= 'No se pudo actualizar el ticket: </br></br> <li>El mensaje no puede estar vacio.</li>';
  	 }
  }
?>