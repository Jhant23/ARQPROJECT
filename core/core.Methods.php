<?php 

/*--------------------------------------------------------------------------*/
// Creamos una clase para limpiar todos datos de tipo STRING antes de 
// insertarlos en la base de datos
/*--------------------------------------------------------------------------*/

class fireWall {

	public static  function clearString($a=true,$string){
		$string = str_replace("INSERT","&&",$string);  
		$string = str_replace("DELETE","&&",$string);
		$string = str_replace("FROM", "&&", $string);
		$string = str_replace("from", "&&", $string);
		$string = str_replace("WHERE", "&&", $string);
		$string = str_replace("where", "&&", $string);
		$string = str_replace("TRUNCATE","&&",$string);
		$string = str_replace("SELECT","&&",$string);
		$string = str_replace("ALTER","&&",$string);
		$string = str_replace("UPDATE","&&",$string);
		$string = str_replace("inert","&&",$string);  
		$string = str_replace("delete","&&",$string);
		$string = str_replace("truncate","&&",$string);
		$string = str_replace("select","&&",$string);
		$string = str_replace("alter","&&",$string);
		$string = str_replace("update","&&",$string);
		$string = str_replace("script","&&",$string);
		$string = str_replace("SCRIPT","&&",$string);
		$string = str_replace("META", "&&", $string);
		$string = str_replace("meta", "&&", $string);
		$string = str_replace("&#62;", "&#;62;", $string);
		$string = str_replace("&#60;", "&#;60;", $string);
		$string = str_replace('"','',$string);
		$string = str_replace("'","",$string);
		$string = str_replace("location","",$string);

		return $string;
	}

	public static function clearGetAndPost($d){

		if ($d) {
			$g = str_replace("INSERT","&&",$g);  
			$g = str_replace("DELETE","&&",$g);
			$g = str_replace("TRUNCATE","&&",$g);
			$g = str_replace("SELECT","&&",$g);
			$g = str_replace("ALTER","&&",$g);
			$g = str_replace("UPDATE","&&",$g);
			$g = str_replace("inert","&&",$g);  
			$g = str_replace("delete","&&",$g);
			$g = str_replace("truncate","&&",$g);
			$g = str_replace("select","&&",$g);
			$g = str_replace("alter","&&",$g);
			$g = str_replace("update","&&",$g);
			$g = str_replace("script","&&",$g);
			$g = str_replace("SCRIPT","&&",$g);
			$g = str_replace('"','',$g);
			$g = str_replace("'","",$g);

			return $d;
		}
	}

}

/*--------------------------------------------------------------------------*/
// Creamos una clase para generar contraseñas
/*--------------------------------------------------------------------------*/

class GeneretePassword {

	public $characters;
	public $process = false;
	protected $password;

	public function __construct($characters){
		$this->characters = $characters;
	}

	public function random(){

		$letters = array('A','1','B','2','C','D','3','F','4','F','5','G','6','H','I','J','7','K','8','L','9','M','N','O','P','Q','R','S','T','V','W','X','Y','Z','a','1','b','2','c','3','d','4','e','f','5','g','6','h','i','7','j','8','k','l','m','9','n','o','p','q','r','s','t','v','w','x','y','z');


		for ($i=0; $i < $this->characters; $i++) {

			$password = $letters[rand(0,count($letters) - 1)];

			$this->password = $password;

			self::password($this->password);

		}

		$this->process = true;

	}

	public function password($password){

		echo $this->password;
	}

	public function __destruct(){
		if ($this->process == true) {
			echo "Se ha generado la contraseña";
		} else {
			echo "Ha ocurrido un error al momento de generar la contraseña";
		}
	}
}

/*--------------------------------------------------------------------------*/
// Creamos una clase para realizar consultas a la base de datos
/*--------------------------------------------------------------------------*/

class user
{

	protected $conexion;
	protected $user;
	private $password;
	public $process = false;

	// Creamos una función para validar el usuario y la contraseña del login de clientes

	public function userLogin($u ,$p ,$c){

		$this->conexion = $c;
		$this->user = $u;
		$this->password = $p;

		$user = $this->conexion->prepare('SELECT * FROM users WHERE user = :user AND password = :pass LIMIT 1');
		$user->execute(array(':user' => $this->user, ':pass' => $this->password));
		$user = $user->fetch();

		if ($user != false) {

			return true;

		} elseif($user == false) {

			return false;
		}
	}

	// Creamos una función para obtener las actualizaciones de cada proyecto
	public function getProjectsData($query, $p, $i, $u, $c) {

		$this->user = $u;
		$this->conexion = $c;

		/**
		* @Queries
		*----------------------------------------------------------------------*
		* userInfo = Obtener la información de un usuario                      *
		* getProjectImages = Traer imagenes de cada proyecto                   *
		* getUpdates = Traer el timeline de actualizaciones de cada proyecto   *
		* getUltimateUpdates = Obtener las ultimas actualizaciones             *
		* getUltimateImages = Obtener las ultimas imagenes                     *
		* totalUpdates = Obtener el total de actualuzaciones de un proyecto    *
		* projectName = Obtener el nombre de un proyecto                       *
		* totalTickets = Obtener el total de tickets de un usuario             *
		* userProjects = Obtener todos los proyectos de un mismo usuario       *
		* totalUserProjects = Obtener el total de proyectos de un usuario      *
		* getUserTickets =  Obtener todos los tickets de un usuario            *
		* getTicketsForType = Obtener tickets resueltos o no resueltos         *
		* getTicketDate = Obtener toda la información de un ticket             *
        * totalTickets = Obtener el total de tickets de un usuario             *
        * ticketComments = Obtener los comentarios en un ticket                *
		*----------------------------------------------------------------------*
		*/

		if (!empty($_GET['id'])) {

			$i = filter_var($i, FILTER_VALIDATE_INT);
			$i = (int)$i;
			$project = $this->conexion->prepare('SELECT * FROM projects WHERE id = :id AND owner = :owner LIMIT 1');
			$project->execute(array(':id' => $i, ':owner' => $this->user));
			$project =  $project->fetch();

			$pNAME = $project['projectname'];
			$pID = $project['id'];
		}

		if ($query === 'userInfo') {
			$userInfo = $this->conexion->prepare('SELECT * FROM users WHERE user = :user LIMIT 1');
			$userInfo->execute(array(':user' => $u));
			$userInfo = $userInfo->fetch();

			return $userInfo;
		}

		if ($query === 'query') {
			
		}
		elseif ($query === 'getProjectImages' && $p === 'projectimg') {

			$getImgs = $this->conexion->prepare('SELECT * FROM projectsimages WHERE owner = :owner AND projectname = :project');
			$getImgs->execute(array(':owner' => $this->user, ':project' => $pNAME));
			$getImgs = $getImgs->fetchAll();

			return $getImgs;

		} 


		elseif ($query === 'getUpdates') {
			$updates = $this->conexion->prepare('SELECT * FROM projectsupdates WHERE owner = :owner AND projectname = :project');
			$updates->execute(array(':owner' => $this->user, ':project' => $pNAME));
			$updates = $updates->fetchAll();

			return $updates;

		}  

		elseif ($query === 'getUltimateImages') {
			$images = $this->conexion->prepare('SELECT SQL_CALC_FOUND_ROWS * FROM projectsimages WHERE owner = :owner AND projectname = :project');
			$images->execute(array(':owner' => $this->user, ':project' => $pNAME));
			$images = $images->fetchAll();

			$tImages = $this->conexion->query('SELECT FOUND_ROWS() AS totalImages');
			$tImages = $tImages->fetch()['totalImages'];

			$ultimateImages = ($tImages > 3 ) ? ($tImages - 3 ) : 0; 

			$getUltimateImages = $this->conexion->prepare("SELECT  * FROM projectsimages WHERE owner = :owner AND projectname = :project LIMIT $ultimateImages, $tImages");
			$getUltimateImages->execute(array(':owner' => $this->user, ':project' => $pNAME));
			$getUltimateImages = $getUltimateImages->fetchAll();

			return $getUltimateImages;
		}

		elseif ($query === 'getUltimateUpdates') {

			$updates = $this->conexion->prepare('SELECT SQL_CALC_FOUND_ROWS * FROM projectsupdates WHERE owner = :owner AND projectname = :project');
			$updates->execute(array(':owner' => $this->user, ':project' => $pNAME));
			$updates = $updates->fetchAll();

			$tUpdates = $this->conexion->query('SELECT FOUND_ROWS() AS totalUpdates');
			$tUpdates = $tUpdates->fetch()['totalUpdates'];

			$ultimateUpdates = ($tUpdates > 3 ) ? ($tUpdates - 3 ) : 0; 

			$getUltimateUpdates = $this->conexion->prepare("SELECT  * FROM projectsupdates WHERE owner = :owner AND projectname = :project LIMIT $ultimateUpdates, $tUpdates");
			$getUltimateUpdates->execute(array(':owner' => $this->user, ':project' => $pNAME));
			$getUltimateUpdates = $getUltimateUpdates->fetchAll();

			return $getUltimateUpdates;
		}

		elseif ($query === 'totalUpdates') {

			$getImgsUpdates = $this->conexion->prepare('SELECT SQL_CALC_FOUND_ROWS * FROM projectsimages WHERE owner = :owner AND projectname = :project');
			$getImgsUpdates->execute(array(':owner' => $this->user, ':project' => $pNAME));
			$getImgsUpdates = $getImgsUpdates->fetchAll();

			$totalImgUpdates = $this->conexion->query('SELECT FOUND_ROWS() AS totalImgUpdates');
			$totalImgUpdates = $totalImgUpdates->fetch()['totalImgUpdates'];

			$getTimeLineUpdates = $this->conexion->prepare('SELECT SQL_CALC_FOUND_ROWS * FROM projectsupdates WHERE owner = :owner AND projectname = :project');
			$getTimeLineUpdates->execute(array(':owner' => $this->user, ':project' => $pNAME));
			$getTimeLineUpdates = $getTimeLineUpdates->fetchAll();

			$timeLineTotalUpdates = $this->conexion->query('SELECT FOUND_ROWS() AS totalUpdates');
			$timeLineTotalUpdates = $timeLineTotalUpdates->fetch()['totalUpdates'];


			$totalUpdates = $totalImgUpdates + $timeLineTotalUpdates;

			return $totalUpdates;
		}

		elseif($query === 'projectName'){
			$getProjectName = $this->conexion->prepare('SELECT * FROM projects WHERE owner = :owner AND id = :id LIMIT 1');
			$getProjectName->execute(array(':owner' => $this->user,':id' => $pID));
			$getProjectName = $getProjectName->fetch();

			return $getProjectName['projectname'];
		}

		elseif ($query === 'userProjects') {
			
			$getUserProjects = $this->conexion->prepare('SELECT * FROM projects WHERE owner = :owner');
			$getUserProjects->execute(array(':owner' => $this->user));
			$getUserProjects = $getUserProjects->fetchAll();

			return $getUserProjects;
		}

		elseif ($query === 'totalUserProjects') {

			$projects = $this->conexion->prepare('SELECT SQL_CALC_FOUND_ROWS * FROM projects WHERE owner = :owner');
			$projects->execute(array(':owner' => $this->user));
			$projects = $projects->fetchAll();

			$totalUserProjects = $this->conexion->query('SELECT FOUND_ROWS() AS totalUserProjects');
			$totalUserProjects = $totalUserProjects->fetch()['totalUserProjects'];

			return $totalUserProjects;
		}

		elseif ($query === 'getUserTickets') {
			$getUserTickets = $this->conexion->prepare('SELECT * FROM tickets WHERE owner = :owner');
			$getUserTickets->execute(array(':owner' => $this->user));
			$getUserTickets = $getUserTickets->fetchAll();

			return $getUserTickets;
		}


		elseif ($query === 'getTicketsForType') {
			$getUnresolveTickets = $this->conexion->prepare('SELECT * FROM tickets WHERE owner = :owner AND resolved = :resolved');
			$getUnresolveTickets->execute(array(':owner' => $this->user,':resolved' => $p));
			$getUnresolveTickets = $getUnresolveTickets->fetchAll();

			return $getUnresolveTickets;
		}

		elseif ($query === 'getTicketDate') {
			$getTicketDate = $this->conexion->prepare('SELECT * FROM tickets WHERE id = :id AND owner = :owner LIMIT 1');
			$getTicketDate->execute(array(':id' => $i,':owner' => $this->user));
			$getTicketDate = $getTicketDate->fetch();

			return $getTicketDate;
		}

		elseif ($query === 'totalTickets') {
			
			$tickets = $this->conexion->prepare('SELECT SQL_CALC_FOUND_ROWS * FROM tickets WHERE owner = :owner AND resolved = :resolved');
			$tickets->execute(array(':owner' => $this->user, ':resolved' => $p));
			$tickets = $tickets->fetchAll();

			$totalTickets = $this->conexion->query('SELECT FOUND_ROWS() AS totalTickets');
			$totalTickets = $totalTickets->fetch()['totalTickets'];

			return $totalTickets;
		}

		elseif ($query === 'ticketComments') {
			
			$getComments = $this->conexion->prepare('SELECT * FROM comments WHERE ticketid = :ticketid');
			$getComments->execute(array(':ticketid' => $i));
			$getComments = $getComments->fetchAll();

			return $getComments;
		}

		elseif ($query === 'totalUserComments') {
			
			$userComments = $this->conexion->prepare('SELECT SQL_CALC_FOUND_ROWS * FROM comments WHERE owner = :owner');
			$userComments->execute(array(':owner' => $this->user));
			$userComments = $userComments->fetchAll();

			$tUComments = $this->conexion->query('SELECT FOUND_ROWS() AS  tUComments');
			$tUComments = $tUComments->fetch()['tUComments'];

			return $tUComments;
		}
	}

	public function getSiteConfig($c) {
		$this->conexion = $c;

		$siteconfig = $this->conexion->prepare('SELECT * FROM siteconfig');
		$siteconfig->execute();
		$siteconfig = $siteconfig->fetch();

		return $siteconfig;
	}

	public function getLimitContent($t,$p,$query,$c){

		$this->conexion = $c;

		$page = (isset($p)) ? $p : 0 ; 

		$post = ($p > 1) ? ($page * $t - $t) : 0 ;

		$statement = $this->conexion->prepare("$query LIMIT $post,$t");
		$statement->execute();
		$statement = $statement->fetchAll();

		return $statement;
	}


	// Creamos una función para validar que un usuario halla iniciado sesión
	
	public function checkSession() {
		if (!$_SESSION) {
			return false;
		} else {
			return true;
		}
	}
}

/*--------------------------------------------------------------------------*/
// Creamos una clase para insertar nuevos comentarios en la base de datos
/*--------------------------------------------------------------------------*/

class createComment extends user
{
	public $process = false;

	function __construct($user,$conexion,$ticketid)
	{
		$this->user = $user;
		$this->conexion = $conexion;
		$this->i = $ticketid;
	}

	public function insertComment(){

		if (isset($_POST['newComment'])) {

			include '../core/controllers/commentController.php';

			if (!$errors) {

				if ($this->process == false) {

					$ticketComments = $this->conexion->prepare('SELECT SQL_CALC_FOUND_ROWS * FROM comments WHERE ticketid = :ticketid');
					$ticketComments->execute(array(':ticketid' => $this->i));
					$ticketComments = $ticketComments->fetchAll();

					$totalTicketComments = $this->conexion->query('SELECT FOUND_ROWS() AS totalTicketComments');
					$totalTicketComments = $totalTicketComments->fetch()['totalTicketComments'];

					$uComment = ($totalTicketComments > 1) ? ($totalTicketComments - 1) : 0;

					$ultimateComment = $this->conexion->prepare("SELECT * FROM comments WHERE ticketid = :ticketid LIMIT $uComment,$totalTicketComments");
					$ultimateComment->execute(array(':ticketid' => $this->i));
					$ultimateComment = $ultimateComment->fetch();

					if ($ultimateComment['owner'] == $this->user) {

						$newComment = $ultimateComment['comment']."<br><hr><b><i>Actualización:</i></b> $dtime - $hour </br></br>".$comment;

						$updateComment = $this->conexion->prepare('UPDATE comments SET 
							comment = :comment WHERE id = :id');
						$updateComment->execute(array('comment' => $newComment, ':id' => $ultimateComment['id']));

						$this->process = true;


					} else {

						$commentId = ($totalTicketComments >= 1) ? ($totalTicketComments + 1) : 1;

						$insertComment = $this->conexion->prepare('INSERT INTO comments (id,owner,ticketid, dtime,hour,comment,commentid) VALUES (null,:owner,:ticketid,:dtime,:hour,:comment,:commentid)');
						$insertComment->execute(array(':owner' => $this->user,':ticketid' => $ticketID,':dtime' => $dtime,':hour' => $hour,':comment' => $comment,':commentid' => $commentId));

						$this->process = true;
					}
				}

			} 
		}
	}

	function __destruct(){
		if ($this->process) {

			echo "<meta http-equiv='refresh' content='0.30'/>";

		}
	}

}

/**
* 
*/
class createTicket extends user
{
	
	public $process = false;

	function __construct($user,$conexion)
	{
		$this->user = $user;
		$this->conexion = $conexion;
	}

	public function newTicket(){

		include('../core/controllers/ticketController.php');

		if (isset($_POST['newTicket'])) {

			if (!$errors) {


				$projectname = self::getProjectsData('projectName',null,$_GET['id'],$this->user,$this->conexion);

				$insertTicket = $this->conexion->prepare('INSERT INTO tickets (id,owner,topic,message,projectname,resolved,dtime) VALUES (null,:owner,:topic,:message,:projectname,0,:dtime)');

				$insertTicket->execute(array(':owner' => $this->user,':topic' => $topic,':message' => $message,':projectname' => $projectname,':dtime' => $date));

				$this->process = true;
			}
		}
	}

	function __destruct(){
		if ($this->process) {
			
			echo "<meta http-equiv='refresh' content='0.30'>";

		}
	}
}


/*--------------------------------------------------------------------------*/
// Creamos una clase para actualizar los tickets en la base de datos
/*--------------------------------------------------------------------------*/

class dateUpdate extends user {

	public $process = false;

	public function __construct($conexion,$user){
		$this->conexion = $conexion;
		$this->user = $user;
		$this->fireWall = new fireWall();
	}

	public function resolveTicket($r=true,$i){

		$fireWall = new fireWall();

		$r = $this->fireWall->clearString(null,$r);
		$i = $this->fireWall->clearString(null,$i);
		$i = (int)$i;

		$resolve = $this->conexion->prepare('UPDATE tickets SET resolved = 1 WHERE id = :id AND owner = :owner');
		$resolve->execute(array(':id' => $i,':owner' => $this->user));

		$this->process = true;
	}

	public function updateTicket($s,$i){

		include ('../core/controllers/updatesController.php');

		$this->fireWall->clearString(null,$s);
		$this->fireWall->clearString(null,$i);
		$i = (int)$i;

		if (!$uErrors && $s === 'done' && !empty($message)) {

			$upTicket = $this->conexion->prepare('UPDATE tickets SET message = :message WHERE id = :id LIMIT 1');
			$upTicket->execute(array(':message' => $message,':id' => $i));
			
			$this->process = true;
		} 
	}

	public function __destruct(){
		if ($this->process) {
			$success = 'Se ha actualizado correctamente.';
		}
	}
}


?>