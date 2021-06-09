<?php include '../core/controllers/chooseOptionControllers.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Seleccionar Proyecto - ARQProject 1.0</title>
    <link rel="stylesheet" type="text/css" href="../style/css/style.css">
</head>
<body>
    <section class="content-container">
        <article class="wrapper">
            <header class="top">
                <div class="title">
                    <h1>Proyectos:</h1>
                </div>
            </header>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" id="pChoose" name="pChoose">
                <select class="chooseProject" name="option">
                    <?php 
                    foreach ($options as $pName) {
                        for ($i=0; $i <= count($options); $i++) { 
                            echo "<option ='",$pName['id'],"'>",$pName['projectname'],"</option>";
                            break;
                        }
                    }
                    ?>
                </select>
                <input type="button" class="__formcontrol" name="sendLogin" value="Acceder" onclick="pChoose.submit()">

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
