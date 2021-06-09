<?php include '../core/templates/header.php';?>
        <div id="wrapper">
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><li class="fa fa-home"></li>   Inicio</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-custom">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-clock-o fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">
                                          <span id="updates">
                                              0
                                          </span>
                                        </div>
                                        <div>Actualizaciones!</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-custom">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-folder fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">
                                          <span id="projects">
                                              0
                                          </span>   
                                        </div>
                                        <?php  if($user->getProjectsData('totalUserProjects',PAGE,$_GET['id'],USER,$conexion) == 1): ?>
                                            <div>Proyecto!</div>
                                        </div>
                                    </div>
                                </div>
                            <?php elseif($user->getProjectsData('totalUserProjects',PAGE,$_GET['id'],USER,$conexion) > 1):?>
                                <div>Proyectos!</div>
                            </div>
                        </div>
                    </div>
                    <a href="chooseproject.php">
                        <div class="panel-footer">
                            <span class="pull-left">Ver Más</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-custom">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-support fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">
                               <span id="tickets">
                                  0
                               </span>
                            </div>
                            <div>Tickets de soporte!</div>
                        </div>
                    </div>
                </div>
                <a href="tickets.php?page=mytickets<?php echo $url;?>">
                    <div class="panel-footer">
                        <span class="pull-left">Ver Más</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="panel panel-yellow">
        <div class="panel-heading">
           Últimos Avances:
       </div>
       <div class="panel-body">
        <div class="row show-grid">
            <?php  if($user->getProjectsData('getUltimateImages',PAGE,$_GET['id'],USER,$conexion) != false):
            $imgt = array_reverse($user->getProjectsData('getUltimateImages',PAGE,$_GET['id'],USER,$conexion)); 
            foreach($imgt as $img): 
                ?>
            <ul class="galeria">
                <li class="galeria__item"><?php echo $img['img']; ?></li>
            </ul>
<?php  endforeach; else: echo "<center><h6>No hay imágenes disponibles</h6></center>"; endif;  ?>
    </div>
</div>
</div>

<div class="panel panel-primary">
    <div class="panel-heading">
       Últimas Actualizaciones:
   </div>
   <div class="panel-body">
     <?php  if($user->getProjectsData('getUltimateUpdates',PAGE,$_GET['id'],USER,$conexion) != false):
     $updt = array_reverse($user->getProjectsData('getUltimateUpdates',PAGE,$_GET['id'],USER,$conexion)); 
     foreach($updt as $upd): 
        ?>
    <div class="row show-grid">
      <div class="col-xs-6 col-md-4">
          <?php echo '<b>Fecha:</b> ',$upd['dtime'],' - ',$upd['projectname']; ?>
      </div>
      <div class="col-xs-12 col-md-8">
          <?php echo $upd['update']; ?>
      </div>
  </div>
<?php  endforeach; else: echo "<center><h6>No hay actualizaciones disponibles</h6></center>"; endif;  ?>
</div>
</div>
</div>
<!-- /-row -->
</div>
</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script type="text/javascript">

var comma_separator_number_step = $.animateNumber.numberStepFactories.separator(',')
$('#number').animateNumber(
  {
    number: 10,
    numberStep: comma_separator_number_step
  }
);
</script>

<script src="../style/vendor/jquery/jquery.min.js"></script>
<script src="../style/js/jquery.animateNumber.min.js"></script>
<script src="../style/vendor/jquery/modal.js"></script>


<script type="text/javascript">

$('#updates')
  .animateNumber(
    {
      number: "<?php echo $user->getProjectsData('totalUpdates',PAGE,$_GET['id'],USER,$conexion);?>"
    },
    'low'
  );

$('#projects')
  .animateNumber(
    {
      number: "<?php echo $user->getProjectsData('totalUserProjects',PAGE,$_GET['id'],USER,$conexion);?>"
    },
    'normal'
  );

$('#tickets')
  .animateNumber(
    {
      number: "<?php echo $totalTickets; ?>"
    },
    'normal'
  );
</script>
<script src="../style/vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="../style/vendor/metisMenu/metisMenu.min.js"></script>

<!-- Morris Charts JavaScript 
<script src="../style/vendor/raphael/raphael.min.js"></script>
<script src="../style/vendor/morrisjs/morris.min.js"></script>
<script src="../style/data/morris-data.js"></script>
-->
<!-- Custom Theme JavaScript -->
<script src="../style/dist/js/sb-admin-2.js"></script>

</body>

</html>
