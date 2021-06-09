<?php 
require('../core/core.php');
require('../core/core.Methods.php');

$user = new user();

if ($user->checkSession() === false) {
    header('Location: ../index.php');
}

$fireWall = new fireWall();

$fireWall->clearGetAndPost($_POST,$_GET);

$options = $user->getProjectsData('userProjects',0,0,$_SESSION['arqUser'],$conexion);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	$projectName = $_POST['option'];

	$getProjectId = $conexion->prepare('SELECT * FROM projects WHERE projectName = :projectName LIMIT 1');
	$getProjectId->execute(array(":projectName" => $projectName));
	$getProjectId = $getProjectId->fetchAll();

	foreach ($getProjectId as $id) {
		$pID = $id['id'];
	}

	$url = "panel.php?page=inicio&id=$pID";

	header("Location: $url");
}

?>