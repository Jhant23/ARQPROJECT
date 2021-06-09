<?php include '../core/templates/header.php'; include '../core/controllers/ticketController.php';

$ticket = new createTicket(USER,$conexion);
$ticket->newTicket();

if($user->getSiteConfig($conexion)['tickets'] == 1): 
?>
    <div id="wrapper">
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><li class="fa fa-pencil"></li>  Crear un nuevo ticket</h1>
                    </div>
                </div>
<?php if($user->getProjectsData('totalTickets',PAGE,$_GET['id'],USER,$conexion) >= 3): ?>
    <h4><li>Haz superado el limite de tickets abiertos por persona.</li></h4>
    <h6><a href="tickets.php?page=mytickets<?php echo $url;?>">Ver tus tickets</a></h6>
<?php else: ?>
                <div class="panel panel-info">
                   <div class="panel-heading">
                      <center>Crear Nuevo Ticket</center>
                  </div>    
                  <div class="panel-body">
                      <form action="newticket.php?page=newticket<?php echo $url;?>" method="POST" name="newTicket" id="newTicket">
                         <div class="form-group input-group">
                             <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                             <input type="text" maxlength="65" name="topic" class="form-control" placeholder="Asunto">
                         </div>

                         <textarea name="message" class="form-control" placeholder="Escriba su mensaje..." style=" max-width: 100%; min-height: 120px; max-height: 250px; margin-bottom: 20px;"></textarea>

                         <input type="submit" class="btn btn-primary btn-lg btn-block ticketform" name="newTicket" value="Enviar Ticket">

                         <?php if($errors): ?>
                            <div class="animated bounceInLeft">
                                <div class="errors"><?php echo $errors;?></div>
                            </div>
                        <?php elseif($success): ?>
                            <div class="animated bounceInLeft">
                                <div class="success"><?php echo $success;?></div>
                            </div>
                        <?php endif; ?>
                    </form>
                    <div class="alert alert-success ticketform">
                        <h4>Solo puedes tener 3 tickets abiertos</h4>
                    </div>
                </div>
<?php endif; ?>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<?php endif; ?>
<?php 
require '../core/templates/footer.php';
?>
</body>
</html>
