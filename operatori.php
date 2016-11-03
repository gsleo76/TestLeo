<?php
include_once('inc/session.php');
include_once('inc/dbconfig.php');

global $connection;
$sql_query = "SELECT * FROM vOperatori";

if(isset($_GET['search'])) {
  $sql_query .= " WHERE Cognome LIKE '%" . $_GET['search'] .  "%'";
}
$sql_query .= " ORDER BY Cognome, Nome";

$result = $connection->query($sql_query);
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
                <a href="operatore_add.php" class="btn btn-success">Nuovo </a>

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
                        <th>Nome</th>
                        <th>Comune</th>
                        <th>Azioni</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        if($result->num_rows==0) {
                          echo "<tr><td colspan='5'>nessun record trovato</td></tr>";
                        } else {
                          while($row = $result->fetch_array()) {
                            echo "<tr>";
                            echo "<td>" . $row['ID'] . "</td>";
                            echo "<td>" . $row['Cognome'] . "</td>";
                            echo "<td>" . $row['Nome'] . "</td>";
                            echo "<td>" . $row['Comune'] . "</td>";
                            echo "<td><a href='operatore_edit.php?edit_id=".$row['ID']."' class='btn btn-default btn-sm'>modifica</a> ";
                            echo "<a href='operatore_delete.php?delete_id=".$row['ID']."' class='btn btn-danger btn-sm'>cancella</a></td>";
                            echo "</tr>";
                         }
                        }
                      ?>

                    </tbody>
                  </table>

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- script section -->
    <?php include('html/layout/script.php'); ?>
</body>

</html>
