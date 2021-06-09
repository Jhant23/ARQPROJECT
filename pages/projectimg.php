<?php include '../core/templates/header.php';

$pages = new Pages(USER,$conexion);

?>
<div id="wrapper">
  <!-- Page Content -->
  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="page-header">
            <li class="fa fa-image"></li>
            <?php echo $user->getProjectsData('projectName',PAGE,$_GET['id'],USER,$conexion), ' - Imágenes'; ?>
          </h1>
        </div>
        <?php  

        if($user->getProjectsData('getProjectImages',PAGE,$_GET['id'],USER,$conexion) != false):


          $imgupdt = array_reverse($user->getLimitContent($user->getSiteConfig($conexion)['page_images'],$_GET['p'],"SELECT * FROM projectsimages WHERE owner = $pOWNER AND projectname = $pNAME ORDER BY id DESC",$conexion)); 

        foreach(array_reverse($imgupdt) as $img): 
          ?>
        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-default">
              <div class="panel-heading custom">
               <b>Fecha de Publicación: </b>
               <div class="imgdtime"><?php echo $img['dtime']?></div>
             </div>
             <!-- /.panel-heading -->
             <div class="panel-body">
               <div class="col-lg-6">

                 <div class="panel panel-greenx">
                  <div class="panel-heading img">
                    Avances:
                  </div>
                  <!-- /.panel-heading -->
                  <div class="panel-body">
                    <ul class="galeria">
                      <li class="galeria__item"><?php echo $img['img']; ?></li>
                    </ul>
                  </div>
                  <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
              </div>
              <div class="col-lg-6">
                <div class="panel panel-redx">
                  <div class="panel-heading info">
                   Información:
                 </div>
                 <!-- /.panel-heading -->
                 <div class="panel-body">
                  <?php echo $img['description'];?>
                </div>
                <!-- /.panel-body -->
              </div>                                <!-- /.panel -->
            </div>
          </div>
        </div>

      <?php endforeach; $pUrl = 'projectimg.php?page=projectimg' . $url;

      $pages->calcPages($user->getSiteConfig($conexion)['page_images'],$pUrl,$_GET['p'],"SELECT SQL_CALC_FOUND_ROWS * FROM projectsimages WHERE owner = $pOWNER AND projectname = $pNAME");  else: echo "<center><h4>No hay Imágenes disponibles</h4></center>"; endif; 
      ?>
    </div>
  </div>

  <!-- /.panel-body -->
</div>
<!-- /.panel -->
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
