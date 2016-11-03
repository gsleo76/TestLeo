<?php
include_once('inc/session.php');

$filepath = "upload/";

if(isset($_POST['btn-upload'])) {
    if(isset($_FILES['file'])) {
        //print_r($_FILES['file']);
        $filename = $_FILES["file"]["name"];


        //Verifica Errore su Trasferimento
        if($_FILES['file']['error'] > 0) {
            echo "Errore di trasferimento codice: "
                . $_FILES['file']['error'];
        } elseif(file_exists($filepath . $_FILES["file"]["name"])) {
            $exist = true;
        } else {
            move_uploaded_file($_FILES["file"]["tmp_name"],
                $filepath . $_FILES["file"]["name"] );
            $saved = true;
        }



    }
}

?>
<!DOCTYPE html>
<html lang="it">

<head>
  <?php include('html/layout/head.php'); ?>
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include('html/layout/navbar.php'); ?>

        <div id="page-wrapper">
            <?php include('html/layout/pageHeader.php'); ?>

            <!-- /.row -->
            <div class="row">
              <!-- Page Content -->


                <?php if(isset($exist)) { ?>
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    File: <strong><?php echo $filename; ?></strong> già presente sul server!
                </div>
                <?php } ?>

                <?php if(isset($saved)) { ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    File: 
                    <strong>
                        <a href="<?php echo $filepath . $filename; ?>" target="_blank">
                            <?php echo $filename; ?>
                        </a>                     
                    </strong> 
                    trasferito con successo!
                </div>
                <?php } ?>



              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" 
                    enctype="multipart/form-data"  >
                <div class="form-group col-md-6">
                    <label>Titolo</label>
                    <input type="text" class="form-control" name="titolo" 
                        placeholder="Titolo">
                </div>
                <div class="form-group col-md-6">
                    <label>Autore</label>
                    <input type="text" class="form-control" name="autore" 
                            placeholder="Autore">
                </div>
                <div class="form-group col-md-12">
                    <input type="file" name="file" />
                </div>
                <div class="col-md-12">
                  <button type="submit" name="btn-upload" class="btn btn-default">Salva</button>
                </div>
              </form>

            </div>
            <!-- /.row -->

            <div class="row">

                <h2>Elenco File</h2>
                <div class="list-group">
                    <?php 
                        $files = scandir("C:/xampp/htdocs/f4_vs02/upload/");

                        for($i=2;$i<count($files);$i++) {
                    ?>
                            <a href="<?php echo $filepath . $files[$i]; ?>"
                                target="_blank"
                                class="list-group-item">
                                <?php echo $i - 1 . ' - ' . $files[$i]; ?>
                            </a>
                            <a href="/f4_vs02/import.php?import_file=<?php echo $files[$i]; ?>"  class="btn btn-default">import</a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- script section -->
    <?php include('html/layout/script.php'); ?>
</body>

</html>
