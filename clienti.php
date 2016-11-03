<?php
include_once('inc/session.php');
include_once('inc/connection.php');

global $conn;
//$sql = "select IDProtocollo, Stato from TABChiamateStati";
$sql = "select top 30 IdProtocollo, Destinatario, Subject, convert(varchar(10), Data, 121) Data from TabChiamate";

if(isset($_GET['search'])) {
	$sql .= " WHERE IdProtocollo LIKE '%" . $_GET['search'] .  "%'";
}
$sql .= " ORDER BY Destinatario";

$result = sqlsrv_query($conn, $sql, array(),array( "Scrollable" => 'static' ));

//inserire il codice per l'impaginazione

// Set the number of rows to be returned on a page.
$rowsPerPage = 10;

// Get the total number of rows returned by the query.
$rowsReturned = sqlsrv_num_rows($result);
if($rowsReturned === false)
    die( print_r( sqlsrv_errors(), true));
elseif($rowsReturned == 0)
{
    echo "No rows returned.";
    exit();
}
else
{
    /* Calculate number of pages. */
    $numOfPages = ceil($rowsReturned/$rowsPerPage);
}

//fine codice impaginazione

function getPage($result, $pageNum, $rowsPerPage)
{
    $offset = ($pageNum - 1) * $rowsPerPage;
    $rows = array();
    $i = 0;
    while($row = sqlsrv_fetch_array($stmt,
                                    SQLSRV_FETCH_NUMERIC,
                                    SQLSRV_SCROLL_ABSOLUTE,
                                    $offset + $i)
           && $i < $rowsPerPage)
    {
        array_push($rows, $row);
        $i++;
    }
    return $rows;
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

			<!-- Alerts -->
			<div class="row">
				<?php if(isset($deleted)) { ?>
				<!-- Inserire nota per salvataggio con successo -->
				<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					Record cancellato con successo!
				</div>
				<?php } ?>

				<?php if(isset($_GET['saved'])) { ?>
				<!-- Inserire nota per salvataggio con successo -->
				<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
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
							<input type="text" class="form-control" name="search" placeholder="Ricerca tkt" />
							<span class="input-group-btn">
								<button type="submit" class="btn btn-default">Go!</button>
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
							<th>Ticket</th>
							<th>Destinatario</th>
							<th>Subject</th>
							<th>Data</th>

						</tr>
					</thead>
					<tbody>
						<?php
					    if($result === false) {
							echo "<tr><td colspan='5'>nessun record trovato</td></tr>";
                        } else {
							while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC) ) {
								echo "<tr>";
								echo "<td>" . $row['IdProtocollo'] . "</td>";
								echo "<td>" . $row['Destinatario'] . "</td>";
								echo "<td>" . $row['Subject'] . "</td>";
								echo "<td>" . $row['Data'] . "</td>";
							}
                        }


                        ?>

					</tbody>
				</table>

			</div>
			<!-- /#page-wrapper -->

			<!-- pagination -->
			<nav aria-label="Page navigation">
				<ul class="pagination">
					<li>
						<?php if($pageNum > 1) {
						$prevPageLink = "?pageNum=".($pageNum -1);
						echo "<a href='$prevPageLink'>Previous</a>";
						}
                        ?>
						</li>
										
						<li>
						<?php if($pageNum < $numofpages) {
						$nextpagelink="?pageNum=" .($pagenum + 1);
						echo "<a href='$nextPageLink'>Next Page</a>";
						}
						?>
					</li>
				</ul>
			</nav>
		</div>
	</div>
	<!-- /#wrapper -->

	<!-- script section -->
	<?php include('html/layout/script.php'); ?>
</body>

</html>
