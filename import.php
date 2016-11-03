<?php
include_once('inc/dbconfig.php');


if(isset($_GET['import_file'])) {
    $file = 'upload/' . $_GET['import_file'];

    //$file = "data/regioni.csv";
    $handle = fopen($file,"r");
    
    //loop through the csv file and insert into database
    while ($data = fgetcsv($handle,1000,";")) {
        if ($data[0]) {
            $id = $data[0];
            $nome = mysql_real_escape_string($data[1]);
            $sql_cmd = "INSERT INTO Regioni (ID, Nome) VALUES ( $id, '$nome')";
            echo $sql_cmd."<br>";
            if(!$connection->query($sql_cmd)) {
                echo "ERRORE insert";
            }
        }
    }
}
//Print contenuto CSV
/*
$row = 1;
if (($handle = fopen("data/regioni.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        $num = count($data);
        echo "<p> $num fields in line $row: <br /></p>\n";
        $row++;
        for ($c=0; $c < $num; $c++) {
            echo $data[$c] . "<br />\n";
        }
    }
    fclose($handle);
}
*/



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




                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    Dati importati con successo!
                </div>






            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- script section -->
    <?php include('html/layout/script.php'); ?>
</body>

</html>
