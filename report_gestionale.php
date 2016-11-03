<?php
include_once('inc/session.php');
include_once('inc/connection.php');

global $connection;
$sql_query = "select CodiceTkt, Domanda, Oggetto, convert(varchar(10), DataCreazione, 121) DataCreazione, Stato, Tipo, Priorità, Destinatario, Oggetto, FornCli, Riferimento, Persona from vW_PA_TicketGestionale";

if(isset($_GET['search'])) {
	$sql_query .= " WHERE Stato LIKE '%" . $_GET['search'] .  "%'";
}
$sql_query .= " ORDER BY Stato, DataCreazione Asc";

//$result = $connection->query($sql_query);
$result = sqlsrv_query($conn, $sql_query);//, array(),array( "Scrollable" => 'static' ));



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
			
		
            <div class="well">
                <div id="datetimepicker1" class="input-append date">
                    <input data-format="dd/MM/yyyy hh:mm:ss" type="text"></input>
                    <span class="add-on">
                        <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                        </i>
                    </span>
                </div>
            </div>
            <script type="text/javascript">
  $(function() {
    $('#datetimepicker1').datetimepicker({
      language: 'pt-BR'
    });
  });
            </script>

				<!-- Toolbar -->
				<div class="row">
					<a href="operatore_add.php" class="btn btn-success">Nuovo </a>

					<div class="pull-right col-md-4">
						<form action="#" method="GET">
							<div class="input-group">
								<input type="text" class="form-control" name="search" placeholder="Search for..." />
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
								<th>CodiceTkt</th>
								<th>Destinatario</th>
								<th>Oggetto</th>
								<th>Stato</th>
                                <th>Data Creazione</th>
								<th>Riferimento</th>
                                <th>Persona</th>

							</tr>
						</thead>
						<tbody>
							<?php
                        if($result===false) {
                          echo "<tr><td colspan='5'>nessun record trovato</td></tr>";
                        } else {
							while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC) ) {
                            echo "<tr>";
                            echo "<td>" . $row['CodiceTkt'] . "</td>";
                            echo "<td>" . $row['Destinatario'] . "</td>";
                            echo "<td>" . $row['Oggetto'] . "</td>";
							echo "<td>" . $row['Stato'] . "</td>";
                            echo "<td>" . $row['DataCreazione'] . "</td>";
							echo "<td>" . $row['Riferimento'] . "</td>";
							echo "<td>" . $row['Persona'] . "</td>";
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
