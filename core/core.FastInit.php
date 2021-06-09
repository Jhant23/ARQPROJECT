<?php 
$user = new user();
$fireWall = new fireWall();
$date = new date();


if ($user->checkSession() == false) {
    header('Location: ../index.php');
}

define('USER', $_SESSION['arqUser']);
define('PAGE', $_GET['page']);

/*--------------------------------------------------------------------------*/
// Creamos una clase para determinar que fecha mostramos en cada comentario
/*--------------------------------------------------------------------------*/

class date {

    protected $conexion;
    protected $user;

    // Calculamos el total de días que tiene cada mes
    public static function totalMonthDays($month,$year){
      if( is_callable("cal_days_in_month")){

         return cal_days_in_month(CAL_GREGORIAN, $month, $year);

     } else {

         return date("d",mktime(0,0,0,$month+1,0,$year));
     }
 }

 // Creamos una función para mostrar el nombre de cada mes en Español
 public static function months($m){
    $months = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');

    $m = str_replace("0", "", $m);

    $m = (int)$m;

    echo $months[$m];
}
 // Creamos una función para mostrar los días en Español
public static function days($n) {
    $days = array('Lunes','Martes','Miercoles','Jueves','Viernes','Sábado','Domingo');

    $n = (int)$n - 1;

    return $days[$n];
}

}

/**
* Creamos una función para mostrar la fecha de publicación de un comentario
*/
class dateInText extends date
{

    public function __construct($id, $u, $c)
    {
        $this->conexion = $c;
        $this->user = $u;
        $this->id = $id;
    }

    public function commentDate(){

        // Traemos la fecha de publicación de cada comentario
        $m = $this->conexion->prepare('SELECT * FROM comments WHERE id = :id AND owner = :owner');
        $m->execute(array(':id' => $this->id,':owner' => $this->user));
        $m = $m->fetch();

        // Quitamos los (-) de cada fecha
        $month = str_replace("-","", substr($m['dtime'], 2,3));

        // Le restamos 1 al mes para hacer que el arreglo coincida
        $monthPosition = (int)$month - 1;

        // Extraemos los dos primeros numeros de la fecha
        $day = substr($m['dtime'],0,2);

        // Extraemos los dos primeros numeros de la hora
        $hour = substr($m['hour'],0,2);

        // Si la hora es menor a 11 es A.M
        if ($hour <= 11) {
            $abbreviation = 'A.M';


        // Si la hora es mayor a 12 y menor a 24 es P.M
        } elseif($hour >= 12 && $hour <= 24) {
            $abbreviation = 'P.M';
        }

        // Si el día de publicación es igual al dia actual y el mes de publicación es igual al mes actual el comentario se publico ese día
        if ($day == date('d') && $month == date('m')) {
            echo "Hoy a las: ".$m['hour']."&nbsp; $abbreviation";

          // Si el dia de publicación es igual al día actual menos 1 y el mes de publicacion es el mismo, el comentario se publico el día anterior
        } elseif ($day == date('d') - 1 && $month == date('m')) {

            echo "Ayer a las: ".$m['hour']."&nbsp; $abbreviation";

          // Si no se publico el mismo día ni el día anterior mostramos la fecha en la que se publico
        } else {

            echo self::months($monthPosition)."&nbsp;".$day.' de '.substr($m['dtime'],6,9),' , '.$m['hour']."&nbsp; $abbreviation";
        }
    }

    public function __destruct()
    {

    }
}


/**
* CREAMOS UNA CLASE PARA CREAR LA PÁGINACIÓN
*/

class Pages extends user
{

    function __construct($user,$conexion)
    {
        $this->user = $user;
        $this->conexion = $conexion;
    }

    public function calcPages($t,$url,$p,$query){

        // Quitamos los valores negativos (-) de una página
        $p = str_replace("-", "", $p);

        // Determinamos la página en la que se encuentra el usuario
        $page = (isset($p)) ? $p : 1 ; 

        // Calculamos el total de información que mostraremos por página
        $post = ($page > 1) ? ($page * $t - $t) : 0 ;

        // Traemos la información de la base de datos
        $statement = $this->conexion->prepare("$query LIMIT $post,$t");
        $statement->execute();
        $statement = $statement->fetchAll();

        // Guardamos el total de información qué nos devolvio la anterior consulta
        $countStatement = $this->conexion->query('SELECT FOUND_ROWS() AS countStatement');
        $countStatement = $countStatement->fetch()['countStatement'];

        // Calculamos el total de páginas
        $totalPages = ceil($countStatement / $t);


        // Creamos la páginación
        echo "<div class='pagination'><ul>";

        // Creamos el botón para ir a la página anterior
        if ($page == 1) {
            echo "<li class='back_desactive'>&laquo;</li>";
        } else {

            $back = $page - 1;

            echo "<li class='back_active'><a href=".'"'."$url&p=$back".'"'.">&laquo;</a></li>";
        }

        $buttons =  2;

        // Validamos que la página nunca sea menor a 1
        $totalPages = ($totalPages < 1) ? str_replace("$totalPages", "1", $totalPages) : $totalPages;
        

        // Creamos los botones para cada página
        for($i=1; $i <= $totalPages ; $i++) { 



            /*if ($page <= $buttons - 1) {

                if ($i > $buttons) {
                    continue;
                }*/

                if ($page == $i) {

                  echo "<li class='page_button_active'>".$i."</li>";

              } else {

                  echo "<li class='pages_button'><a href=".'"'."$url&p=$i".'"'.">$i</a></li>";

              }

            /*} elseif ($page > $buttons - 1) {

                if ($i < $buttons - 1) {
                    continue;
                }

                if ($page == $i) {

                         echo "<li class='page_button_active'>".$i."</li>";

                  } else {

                         echo "<li class='pages_button'><a href=".'"'."$url&p=$i".'"'.">$i</a></li>";

                 }
             }*/

         }

      // Creamos el botón para ir a la página siguiente  
         if ($page == $totalPages) {

          echo "<li class='back_desactive'>&#187;</li>";

      } else {

        $next = $page + 1;

        echo "<li class='back_active'><a href=".'"'."$url&p=$next".'"'.">&#187;</a></li>";
    }

    echo "</ul></div>";

}


function __destruct(){

}
} 

/*--------------------------------------------------------------------------*/
// Calculamos el total de Tickets creado por un usuario
/*--------------------------------------------------------------------------*/

// Traemos el total de tickets resueltos y no resueltos
$unResolvedTickets = $user->getProjectsData('totalTickets', 0,$_GET['id'],USER,$conexion);
$resolvedTickets = $user->getProjectsData('totalTickets', 1,$_GET['id'],USER,$conexion);

// Sumamos los tickets resueltos y sin resolver para obtener el total de tickets
$totalTickets = $unResolvedTickets + $resolvedTickets;

// Traemos el total de comentarios de un usuario
$totalUserComments = $user->getProjectsData('totalUserComments', 0,$_GET['id'],USER,$conexion);


/*--------------------------------------------------------------------------*/
// Sí hay un id traemos la información del proyecto con dicho id
/*--------------------------------------------------------------------------*/

if (!empty($_GET['id'])) {

    $i = $_GET['id'];
    $i = filter_var($i, FILTER_VALIDATE_INT);
    $fireWall->clearString(true,$_GET['id']);
    $i = (int)$i;
    $project = $conexion->prepare('SELECT * FROM projects WHERE id = :id AND owner = :owner LIMIT 1');
    $project->execute(array(':id' => $i, ':owner' => USER));
    $project =  $project->fetch();

    $pNAME = $project['projectname'];
    $pNAME = "'".$pNAME."'";

    $pID = $project['id'];

    $pOWNER = $project['owner'];
    $pOWNER = "'".$pOWNER."'";
}

/**
 
 GET SECURITY RESTRINCTIONS

*/
 

 /*
 if (!empty($_GET['p']) && $user->getLimitContent($user->getSiteConfig($conexion)['page_images'],$_GET['p'],"SELECT * FROM projectsimages WHERE owner = $pOWNER AND projectname = $pNAME",$conexion) == false or !empty($_GET['page']) && $_GET['page'] == 'projectimg' && empty($_GET['p'])) {

    header('Location: error.php');
}


if (!empty($_GET['ticketid'])) {

    $ticket = $_GET['ticketid'];
}

if (!empty($_GET['ticket']) && !empty($_GET['p']) && $user->getLimitContent($user->getSiteConfig($conexion)['page_comments'],$_GET['p'],"SELECT * FROM comments WHERE ticketid = $ticket",$conexion) == false or !empty($_GET['ticketid']) && empty($_GET['p'])) {

   header('Location: error.php');
}
*/

/*--------------------------------------------------------------------------*/
// Limpiamos datos envíados por GET
/*--------------------------------------------------------------------------*/

if (!empty(PAGE)) {
    $page = PAGE;
    $page = filter_var($page,FILTER_SANITIZE_STRING);
    $page = htmlspecialchars($page);
    $page = trim($page);
    $page = $fireWall->clearString(true,$page);
}

/*--------------------------------------------------------------------------*/
// Validamos que la URl del sitio contenga una página y un id por GET
/*--------------------------------------------------------------------------*/

if (empty(PAGE) or empty($_GET['id'])) {

    header('Location: chooseproject.php');
}

/*--------------------------------------------------------------------------*/
// Comprobamos que la página en la que se encuentra el usuario exista
/*--------------------------------------------------------------------------*/

if (!empty(PAGE)) {

    if (PAGE === 'inicio' or PAGE === 'projectimg' or PAGE === 'projectline' or PAGE === 'newticket' or PAGE === 'mytickets' or PAGE === 'profile') {

        $url = "&id=".$_GET['id']."";
        
    }  else {

        header('Location: chooseproject.php');
    }
}

/*--------------------------------------------------------------------------*/
// Preguntamos si se ha creado un nuevo ticket para redireccionar al usuario
/*--------------------------------------------------------------------------*/

/*
if (!empty($_POST['topic']) && !empty($_POST['message'])) {
    $url = "tickets.php?page=mytickets".$url;
    header("Location: $url");
}
*/
/*--------------------------------------------------------------------------*/
// Validamos que todos los ID sean de carácter numerico
/*--------------------------------------------------------------------------*/

if(!filter_var($_GET['id'], FILTER_VALIDATE_INT) or !empty($_GET['ticketid']) && !filter_var($_GET['ticketid'], FILTER_VALIDATE_INT) or !empty($_GET['ticket']) && !filter_var($_GET['ticket'], FILTER_VALIDATE_INT) or !empty($_GET['p']) && !filter_var($_GET['p'], FILTER_VALIDATE_INT)) {
    header('Location: chooseproject.php');
}

/*--------------------------------------------------------------------------*/
// Validamos que los tickets existan en la base de datos
/*--------------------------------------------------------------------------*/
if (!empty($_GET['ticketid']) && $user->getProjectsData('getTicketDate',PAGE,$_GET['ticketid'],USER,$conexion) == false) {
    header('Location: error.php');
}


if (!empty($_GET['edit'])) {
    
    $fireWall->clearString(true,$_GET['edit']);

}
?>