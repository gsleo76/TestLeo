<?php
// include_once('inc/session.php');
include_once('inc/connection.php');

/*
global $conn;
$sqlsrv_query = "select IDProtocollo, Stato from dbo.TABChiamateStati";

if(isset($_GET['search'])) {
  $sqlsrv_query .= " WHERE Stato LIKE '%" . $_GET['search'] .  "%'";
}
$sqlsrv_query .= " ORDER BY Stato";

$result = $conn->query($sql_query);
*/
?>

<!DOCTYPE html>
<html lang="it">

<head>
  <?php // include('html/layout/head.php'); ?>
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php // include('html/layout/navbar.php'); ?>

        <div id="page-wrapper">
            <?php // include('html/layout/pageHeader.php'); ?>

            <!-- Alerts -->
              <div class="row">
                <?php if(isset($deleted)) { ?>
                  <!-- Inserire nota per salvataggio con successo -->
                  <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    Record cancellato con successo!
                  </div>
                <?php } ?>

                <?php if(isset($_GET['saved'])) { ?>
                  <!-- Inserire nota per salvataggio con successo -->
                  <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    Record salvato con successo!
                  </div>
                <?php } ?>
              </div>

              <!-- Toolbar -->
              <div class="row">
                <a href="cliente_add.php" class="btn btn-success">Nuovo Cliente</a>

                <div class="pull-right col-md-4">
                  <form action="#" method="GET">
                    <div class="input-group">
                      <input type="text" class="form-control" name="search" placeholder="Search for...">
                      <span class="input-group-btn">
                        <button type="submit" class="btn btn-default" type="button">Go!</button>
                      </span>
                    </div><!-- /input-group -->
                  </form>
                </div>
              </div>

              <!-- Page Content -->
              <div class="row">

                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Id</th>
                        <th>Cognome</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                      <?php /*
                        if($result->num_rows==0) {
                          echo "<tr><td colspan='5'>nessun record trovato</td></tr>";
                        } else {
                          while($row = $result->fetch_array()) {
                            echo "<tr>";
                            echo "<td>" . $row['IDProtocollo'] . "</td>";
                            echo "<td>" . $row['Stato'] . "</td>";
                            
                         }
                        } */
                      ?>

                    </tbody>
                  </table>

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- script section -->
    <?php // include('html/layout/script.php'); ?>
</body>

</html>
