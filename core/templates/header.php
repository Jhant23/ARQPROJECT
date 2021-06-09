<?php 
require('../core/core.php');
require('../core/core.Methods.php');
require('../core/core.FastInit.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>ARQProject v1.0</title>
    <link href="../style/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
    <link href="../style/dist/css/sb-admin-2.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../style/css/animate.css">
    <link href="../style/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../style/vendor/morrisjs/morris.css">
</head>
<body>
<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="panel.php?page=inicio<?php echo $url;?>">ARQPROJECT v1.0</a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-messages">
                <?php  if($user->getProjectsData('getUltimateUpdates',PAGE,$_GET['id'],USER,$conexion) != false):
                $updt = array_reverse($user->getProjectsData('getUltimateUpdates',PAGE,$_GET['id'],USER,$conexion)); 
                foreach($updt as $upd): 
                    ?>
                <li>
                    <a href="#">
                        <div>
                            <strong>
                                <?php 
                                if (strlen($upd['projectname']) > 60) {
                                    echo substr($upd['projectname'], 0, 60),'...'; 
                                } else {
                                    echo substr($upd['projectname'], 0, 60);
                                }
                                ?>
                            </strong>
                            <span class="pull-right text-muted">
                                <em>
                                    <?php echo $upd['dtime']; ?>
                                </em>
                            </span>
                        </div>
                        <div>
                            <?php 
                            if (strlen($upd['update']) > 120) {
                              echo substr($upd['projectname'], 0, 120),'...';
                          }   else {
                              echo $upd['update']; 
                          }
                          ?> 
                      </div>
                  </a>
              </li>
              <li class="divider"></li>
              <?php 
              endforeach; else: echo "<center><h6>No hay actualizaciones disponibles</h6></center>"; endif; ?>

              <?php  if($user->getProjectsData('getUltimateUpdates',PAGE,$_GET['id'],USER,$conexion) != false): ?>
               <a class="text-center" href="projecth.php?page=projectline<?php echo $url;?>">
                <strong>Ver todas las actualizaciones</strong>
                <i class="fa fa-angle-right"></i>
            </a>
        <?php endif; ?>

    </ul>
    <!-- /.dropdown-messages -->
</li>
<!-- /.dropdown -->
<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="user-name"><?php echo USER; ?></i>
    </a>
    <!-- /.dropdown-user -->
</li>
<!-- /.dropdown -->
<!-- /.dropdown -->
<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="fa user-img" style="height: 27px; width: 27px; border-radius:100px; background-color:#fff;"><img src="http://demo.dnnrox.com/Portals/_default/Skins/Flatna/img/icons/user@2x.png"></i>
    </a>
        <ul class="dropdown-menu dropdown-user">
        <li><a href="#"><i class="fa fa-user fa-fw"></i> Perfil de Usuario</a>
        </li>
        <li class="divider"></li>
        <li><a href="../logout.php"><i class="fa fa-sign-out fa-fw"></i> Cerrar Sesión</a>
        </li>
    </ul>
    <!-- /.dropdown-user -->
</li>
<!-- /.dropdown -->
</ul>
<!-- /.navbar-top-links -->

<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="panel.php?page=inicio<?php echo $url;?>"><i class="fa fa-dashboard fa-fw"></i> Inicio</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-cubes fa-fw"></i>Actualizaciones<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="projectimg.php?page=projectimg<?php echo $url.'&p=1';?>">Imagenes</a>
                    </li>
                    <li>
                        <a href="projecth.php?page=projectline<?php echo $url.'&p=1';?>">Historial de Avances</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
<?php if($user->getSiteConfig($conexion)['tickets'] == 1): ?>
            <li>
                <a href="#"><i class="fa fa-life-bouy fa-fw"></i>Soporte<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="newticket.php?page=newticket<?php echo $url;?>">Nuevo Ticket</a>
                    </li>
                    <li>
                        <a href="tickets.php?page=mytickets<?php echo $url;?>">Tus Tickets</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
<?php endif; ?>
            <li>
                <a href="../logout.php"><i class="fa fa-sign-out fa-fw"></i>Cerrar Sesión</a>
            </li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->
</nav>