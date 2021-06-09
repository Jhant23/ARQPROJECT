<?php include '../core/templates/header.php';?>
<div id="wrapper">
  <!-- Page Content -->
  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="page-header">
            <li class="fa fa-history"></li>
            <?php echo $user->getProjectsData('projectName',PAGE,$_GET['id'],USER,$conexion), ' - Actualizaciones'; ?></h1>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="panel panel-default">
                <div class="panel-heading">
                  Actualizaciones
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                  <!-- Nav tabs -->
                  <ul class="nav nav-pills">
                    <li class="active"><a href="#total-updates" data-toggle="tab" aria-expanded="true">Todas las Actualizaciones</a>
                    </li>
                    <li class=""><a href="#ultimate-updates" data-toggle="tab" aria-expanded="false">Últimas Actualizaciones</a>
                    </li>
                    <li class=""><a href="#custom-updates" data-toggle="tab" aria-expanded="false">Buscar Actualización por fecha</a>
                    </li>
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">
                    <div class="tab-pane fade active in" id="total-updates">
                      <div class="panel-body">
                        <?php  if($user->getProjectsData('getUpdates',PAGE,$_GET['id'],USER,$conexion) != false):
                        $updt = array_reverse($user->getProjectsData('getUpdates',PAGE,$_GET['id'],USER,$conexion)); 
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

                    <div class="tab-pane fade" id="ultimate-updates">
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


                  <div class="tab-pane fade" id="custom-updates">
                    <p>Aún nos encontramos desarrollando éste complemento.</p>
                  </div>

                </div>
              </div>
              <!-- /.panel-body -->
            </div>
            <!-- 4444444444444444444444444444444 -->

          </div>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

  </div>
  <!-- /#wrapper -->
  <?php 
  require '../core/templates/footer.php';
  ?>
</body>
</html>
