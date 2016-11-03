<?php
include_once('inc/session.php');
include_once('inc/dbconfig.php');

$page = 1;
$skip = 0;
$pageRecords = 1;
$pageCount = 0;

if(isset($_GET['page'])) {
  $page = $_GET['page'];
  $skip = ($page-1) * $pageRecords;
}


global $connection;

$sql_query = "SELECT COUNT(*) AS Totale FROM Clienti";
$result = $connection->query($sql_query);
$row = $result->fetch_array();
$numRecords = $row['Totale'];

$sql_query = "SELECT * FROM vClienti";

if(isset($_GET['search'])) {
  $sql_query .= " WHERE Cognome LIKE '%" . $_GET['search'] .  "%'";
}

$sql_query .= " ORDER BY Cognome, Nome";

//$sql_query .= " LIMIT $skip, $pageRecords";

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
                          $pageCount = $numRecords / $pageRecords;
                          echo "pagecount: $pageCount";

                          while($row = $result->fetch_array()) {
                            echo "<tr>";
                            echo "<td>" . $row['ID'] . "</td>";
                            echo "<td>" . $row['Cognome'] . "</td>";
                            echo "<td>" . $row['Nome'] . "</td>";
                            echo "<td>" . $row['Comune'] . "</td>";
                            echo "<td><a href='cliente_edit.php?edit_id=".$row['ID']."' class='btn btn-default btn-sm'>modifica</a> ";
                            echo "<a href='cliente_delete.php?delete_id=".$row['ID']."' class='btn btn-danger btn-sm'>cancella</a></td>";
                            echo "</tr>";
                         }
                        }
                      ?>
                    </tbody>
                  </table>

                          <nav aria-label="Page navigation">
                          <ul class="pagination">
                            <li>
                              <a href="clienti.php?page=<?php echo $page - 1; ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                              </a>
                            </li>
                            <?php 
                                for($i=1;$i<$pageCount;$i++)
                                {
                                    echo "<li><a href='clienti.php?page=$i'>$i</a></li>";

                                }
                            ?>
                            <li>
                              <a href="clienti.php?page=<?php echo $page + 1; ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                              </a>
                            </li>
                          </ul>
                        </nav>

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- script section -->
    <?php include('html/layout/script.php'); ?>
</body>

</html>
