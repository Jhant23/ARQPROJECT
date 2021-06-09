<?php 
 require('core/core.php');
 require('core/core.Methods.php');

/*----------------------------------------------------*/
// Creamos una variable para almacenar errores
/*----------------------------------------------------*/

$errors = '';


/*----------------------------------------------------*/
// Comprobamos que se hayan enviado datos por POST
/*----------------------------------------------------*/

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if (!empty($_POST['user']) && !empty($_POST['password'])) {

		$query = new user();
		
		$user = (string)$_POST['user'];
		$user = filter_var($user, FILTER_SANITIZE_STRING);
		$user = htmlspecialchars($user);
		$user = trim($user);
		$user = strtolower($user);

		$pass = $_POST['password'];
		$pass = trim($pass);
		$pass = hash('md5', $pass);

		if ($query->userLogin($user,$pass,$conexion) === true) {

			$_SESSION['arqUser'] = $user;
			$_SESSION['arqPassword'] = $pass;

			header('Location: panel.php');
		} elseif($query->userLogin($user,$pass,$conexion) === false) {
			$errors = '<li>El usuario o la contraseña son incorrectos</li>';
		}

	}
}

?>