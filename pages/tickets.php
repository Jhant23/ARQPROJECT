
<?php 
include '../core/templates/header.php'; 
require '../core/controllers/commentController.php';

$update = new dateUpdate($conexion,USER);
$pages = new Pages(USER,$conexion);

if (!empty($_GET['ticketid'])) {

    $ticket = $_GET['ticketid'];

    $comment = new createComment(USER,$conexion,$ticket);
    $comment->insertComment();
}

if (!empty($_GET['edit'])) {
    require '../core/controllers/updatesController.php';

   $update->updateTicket($_GET['edit'],$ticket);
}


 if($user->getSiteConfig($conexion)['tickets'] == 1 && empty($ticket) && empty($_GET['edit'])): 

?>

    <div id="wrapper">
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><li class="fa fa-support"></li>  Tus tickets</h1>
                    </div>
                </div>
<?php

if (!empty($_GET['resolve']) && $_GET['resolve'] == 'true' && !empty($_GET['ticket'])) {
        
        $update->resolveTicket($_GET['resolve'],$_GET['ticket']);
        
        echo "<div class='alert alert-success'>Se ha actualizado el ticket correctamente</div>";

}                            
?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Tickets
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-pills">
                            <li class="active"><a href="#open-tickets" data-toggle="tab" aria-expanded="true">Tickets Abiertos</a>
                            </li>
                            <li class=""><a href="#all-tickets" data-toggle="tab" aria-expanded="false">Todos los Tickets</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="open-tickets">
                                <div class="panel-body">
                                            <tbody>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover">

<?php if(count($user->getProjectsData('getTicketsForType',0,$_GET['id'],USER,$conexion)) >= 1): ?>
                                            <thead>
                                                <tr>
                                                    <th>Marcar como resuelto</th>
                                                    <th>Nombre del Ticket</th>
                                                    <th>Fecha</th>
                                                    <th>Ver Ticket</th>
                                                </tr>
                                            </thead>
<?php foreach(array_reverse($user->getProjectsData('getTicketsForType',0,$_GET['id'],USER,$conexion)) as $unResolveTickets):

 $rurl = "tickets.php?page=mytickets".$url."&resolve=true&ticket=".$unResolveTickets['id'];
?>

                                                <tr>
                                                    <td><center>
                                                    <a href="<?php echo $rurl; ?>">
                                                    <li class="fa fa-check ticket" title="Marcar como resuelto"></li></a></center></td>
                                                    <td><?php echo $unResolveTickets['topic']; ?></td>
                                                    <td><?php echo $unResolveTickets['dtime']; ?></td>
                                                    <td><a href="tickets.php?page=mytickets<?php echo $url,'&ticketid=',$unResolveTickets['id'],'&p=1';?>" style="color: #E22211; text-decoration:underline">Ver Ticket</a>
                                                    </td>
                                                </tr>

                                            </tbody>
<?php  endforeach; else: echo "<h4>No tienes tickets abiertos. <a href='newticket.php?page=newticket",$url,"'>Crear Nuevo Ticket</a></h4>"; endif; ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="all-tickets">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Estado</th>
                                                    <th>Nombre del Ticket</th>
                                                    <th>Fecha</th>
                                                    <th>Ver Ticket</th>
                                                </tr>
                                            </thead>

<?php if($user->getProjectsData('getUserTickets',PAGE,$_GET['id'],USER,$conexion) != false): foreach(array_reverse($user->getProjectsData('getUserTickets',PAGE,$_GET['id'],USER,$conexion)) as $userTickets): ?>

<?php 
 if ($userTickets['resolved'] == 0) {
     $state = "<div class='alert alert-success'>Sin resolver</div>";
 } elseif ($userTickets['resolved'] == 1) {
     $state = "<div class='alert alert-danger'>Resuelto</div>";
 }
?>
                                            <tbody>
                                                <tr>
                                                    <td><?php echo $state;?></td>
                                                    <td><?php echo $userTickets['topic']; ?></td>
                                                    <td><?php echo $userTickets['dtime']; ?></td>
                                                    <td><a href="tickets.php?page=mytickets<?php echo $url,'&ticketid=',$userTickets['id'],'&p=1';?>" style="color: #E22211; text-decoration:underline">Ver Ticket</a>
                                                    </td>
                                                </tr>
                                            </tbody>
<?php endforeach; endif;?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                       </div>

                        </div>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
        <!-- /#wrapper -->
    </div>
<?php elseif($user->getSiteConfig($conexion)['tickets'] == 1 && !empty($ticket) && empty($_GET['edit']) or $_GET['edit'] === 'done'): ?>

    <div id="wrapper">
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        
                    </div>
                    <!-- /.col-lg-12 -->
<?php 
if(!empty($uErrors)){

   echo "<div class='animated bounceInLeft'><div class='errors'>$uErrors</div></div>";

} elseif (!empty($uSuccess)) {
   
   echo "<div class='animated bounceInLeft'><div class='success'>$uSuccess</div></div>";
} 

?>
    <a href="tickets.php?page=mytickets<?php echo $url; ?>">
    <button class="btn btn-warning">Volver a tus tickets</button>
    </a>
                    <div class="panel-body">
                        <div class="panel-user">
                           <div class="user-image" style="background-image: url(http://demo.dnnrox.com/Portals/_default/Skins/Flatna/img/icons/user@2x.png);background-size: cover;">
                           </div>
                           <div class="user-realname">
                               <h5>
                                 <?php 
                                 $owner = $user->getProjectsData('getTicketDate',PAGE,$ticket,USER,$conexion)['owner'];

                                 echo $user->getProjectsData('userInfo',0,$_GET['id'],$owner,$conexion)['name'];?>
                               </h5>
                           </div>
                           <div class="total-tickets">
                               <li class="fa fa-support profile"></li>&nbsp;&nbsp;<b><?php echo $totalTickets; ?></b>
                           </div>
                           <div class="total-comments">
                                <li class="fa fa-comments profile"></li>&nbsp;&nbsp;<b><?php echo $totalUserComments; ?></b>
                           </div>
                        </div>
                        <!-- board -->
                        <div class="board">
                          <!-- board-title -->
                          <div class="board-title">
                             <div class="board-topic">
                                <h4>
<?php echo "<b>",$user->getProjectsData('getTicketDate',PAGE,$ticket,USER,$conexion)['topic'],"</b>"; ?>
                                </h4>  
                             </div>
                             <!-- board action -->
                             <div class="board-action">
                                 <li class="dropdown">
                                     <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                         Acción <i class="fa fa-caret-down"></i>
                                     </a>
                                     <ul class="dropdown-menu dropdown-user">
                                     <li>
                                        <a href="tickets.php?page=mytickets<?php echo $url."&ticketid=".$ticket."&p=".$_GET['p']."&edit=1"; ?>">
                                         <i class="fa fa-pencil"></i>&nbsp;Editar
                                        </a>
                                      </li>
                                     <?php if($user->getProjectsData('getTicketDate',PAGE,$ticket,USER,$conexion)['resolved'] == 0): ?>
                                        <li class="divider"></li>
                                        <li onclick="resolve();">
                                           <a href="#">
                                             <i class="fa fa-check"></i> Marcar como resuelto
                                           </a>
                                        </li>

                                      <?php endif; ?>

                                     </ul>
                                 </li>
                             </div>
                             <!-- board action -->
                          </div>

                          <!-- board-title -->

                          <!-- board-content -->
                          <div class="board-content">
<?php echo $user->getProjectsData('getTicketDate',PAGE,$ticket,USER,$conexion)['message']; ?>
                          </div>
                          <!-- board-content -->
                        </div>

                        <div class="panel-body">
                        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" id="formComment">

                          <textarea class="form-control comment" name="comment" rows="3" placeholder="Publicar un nuevo comentario..."></textarea>
          
                          <input class="btn btn-newcomment" type="submit" name="newComment" value="Comentar"> 
                          <?php if (!empty($errors)): ?>
                              <div class='animated bounceInLeft'><div class="errors"><?php echo $errors; ?></div></div>
                          <?php endif ?>
                        </form>
                        </div>

                        <!-- board -->
<?php 
  
  foreach ($user->getLimitContent($user->getSiteConfig($conexion)['page_comments'],$_GET['p'],"SELECT * FROM comments WHERE ticketid = $ticket",$conexion) as $comment): 

  if ($user->getProjectsData('userInfo',0,$_GET['id'],$comment['owner'],$conexion)['rank'] === 'user'):
?>
                      <!-- User board comment -->
                         <div class="panel-user">
                           <div class="user-image" style="background-image: url(http://demo.dnnrox.com/Portals/_default/Skins/Flatna/img/icons/user@2x.png);background-size: cover;">
                           </div>
                           <div class="user-realname">
                               <h5><?php echo $user->getProjectsData('userInfo',0,$_GET['id'],$comment['owner'],$conexion)['name']?></h5>
                           </div>
                           <div class="total-tickets">
                               <li class="fa fa-support profile"></li>&nbsp;&nbsp;<b><?php echo $totalTickets; ?></b>
                           </div>
                           <div class="total-comments">
                                <li class="fa fa-comments profile"></li>&nbsp;&nbsp;<b><?php echo $totalUserComments; ?></b>
                           </div>
                        </div>
                        <div class="comment">
                            <div class="comment-title">
                              <div class="comment-topic">
                                 <h4>
                                    <?php 
                                    echo '<b>#'.$comment['commentid'].'&nbsp;</b>';
                                    $date = new dateInText($comment['id'],$comment['owner'],$conexion);
                                    $date->commentDate()
                                    ?>
                                 </h4>
                              </div>
                             <!-- board action -->
                             <?php if($user->getProjectsData('userInfo',0,$_GET['id'],USER,$conexion)['rank'] === 'admin'): ?>
                             <div class="board-action">
                                 <li class="dropdown">
                                     <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                         Acción <i class="fa fa-caret-down"></i>
                                     </a>
                                     <ul class="dropdown-menu dropdown-user">

                                        <li onclick="resolve();">
                                           <a href="#">
                                             <i class="fa fa-check"></i> Marcar como resuelto
                                           </a>
                                        </li>
    
                                        <!-- <li class="divider"></li> -->
                                     </ul>
                                 </li>
                             </div>
                           <?php endif;?>
                             <!-- board action -->
                            </div>
                            <div class="board-content">
                              <?php echo $comment['comment']; ?>
                            </div>
                        </div>
                       <!-- User board comment -->
<?php elseif($user->getProjectsData('userInfo',0,$_GET['id'],$comment['owner'],$conexion)['rank'] === 'admin'): ?>

                        <!-- Admin board comment -->
                        <div class="panel-admin">
                          <div class="user-image" style="background-image: url(http://www.iconsfind.com/wp-content/uploads/2015/10/20151012_561baed03a54e.png);background-size: cover;"> 
                          </div>
                          <div class="user-rank">
                               <h5><?php echo $user->getProjectsData('userInfo',0,$_GET['id'],$comment['owner'],$conexion)['rank']?></h5>
                           </div>
                           <div class="user-realname admin">
                               <b><?php echo $user->getProjectsData('userInfo',0,$_GET['id'],$comment['owner'],$conexion)['name']?></b>
                           </div>
                        </div>
                        <div class="comment">
                            <div class="comment-title">
                             <div class="comment-topic">
                                 <h4>
                                    <?php 
                                    echo '<b>#'.$comment['commentid'].'&nbsp;</b>';
                                    $date = new dateInText($comment['id'],$comment['owner'],$conexion);
                                    $date->commentDate()
                                    ?>
                                 </h4>
                              </div>
                            </div>
                            <div class="board-content">
                              <?php echo $comment['comment']; ?>
                            </div>
                        </div>
                       <!-- Admin board comment -->
<?php 

endif; endforeach; 

$pUrl = 'tickets.php?page=mytickets' . $url . "&ticketid=" . $ticket;

$pages->calcPages($user->getSiteConfig($conexion)['page_comments'],$pUrl,$_GET['p'],"SELECT SQL_CALC_FOUND_ROWS * FROM comments WHERE ticketid = $ticket");

?>
                  
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

</div>
<script type="text/javascript">
    function resolve(){
        empty=confirm("¿Deseas marcar éste ticket como resuelto?");
       if (empty)
          window.location.href = "tickets.php?page=mytickets"+"<?php echo $url, '&resolve=true&ticket='.$user->getProjectsData('getTicketDate',PAGE,$ticket,USER,$conexion)['id'];?>";
       else
          alert('La acción ha sido cancelada...')
    }
</script>

<?php endif; include '../core/templates/footer.php'; 
if(!empty($_GET['edit']) && $_GET['edit'] === '1'): ?>

<div id="wrapper">
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
            <button class="btn btn-warning" onclick="history.back()">Volver atrás</button>
                <div class="row">
                        <!-- board -->
                        <div class="board edit">
                          <!-- board-title -->
                          <div class="board-title">
                             <div class="board-topic">
                                <h4>
<?php echo "<b>",$user->getProjectsData('getTicketDate',PAGE,$ticket,USER,$conexion)['topic'],"</b>"; ?>
                                </h4>  
                             </div>
                          </div>

                          <!-- board-title -->

                          <!-- board-content -->
                          <div class="board-content">
                          <form action="tickets.php?page=mytickets<?php echo $url."&ticketid=".$ticket."&p=".$_GET['p']."&edit=done"; ?>" method="POST">
                            <textarea class="form-control edit" name="message_edited"><?php echo $user->getProjectsData('getTicketDate',PAGE,$ticket,USER,$conexion)['message']; ?></textarea>  

                            <input class="btn btn-newcomment edit" type="submit" name="saveChanges" value="Guardar Cambios">

                          </form>
                          </div>
                          <!-- board-content -->
</div>


<?php endif; ?>
</body>
</html>
