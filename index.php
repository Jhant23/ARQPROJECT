<?php 
require('core/controllers/loginController.php');
$session = new user();

if ($session->checkSession() === true) {
	header('Location: panel.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="description" content="Descripción del sitio">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE-edge, chrome=1">
	<title>ARQproject 1.0</title>
	<link rel="stylesheet" type="text/css" href="style/css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<link rel="stylesheet" href="style/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="style/css/animate.css">
</head>
<body>
	<section class="content-container">
		<article class="wrapper">
			<header class="top">
				<div class="title">
					<h1>ARQproject v1.0</h1>
				</div>
			</header>
			<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" id="uLogin" name="uLogin">

				<label for="user"><i class="fa fa-user" aria-hidden="true"></i></label>
				<input type="text" class="__formcontrol" name="user" placeholder="Nombre de usuario" value="<?php if($errors && !empty($_POST['user'])) echo $_POST['user']; ?>">

				<label for="password"><i class="fa fa-key" aria-hidden="true"></i></label>
				<input type="password" class="__formcontrol" name="password" placeholder="Contraseña">

				<input type="button" class="__formcontrol" name="sendLogin" value="Entrar" onclick="uLogin.submit()">

				<?php if(!empty($errors)): ?>
					<div class="animated bounceInLeft">
						<div class="errors"><?php echo $errors;?></div>
					</div>
				<?php endif;?>	
			</form>
		</article>
	</section>
</body>
</html>