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

//inserire il codice per l'impaginazione
$pageSize= 5;
$page= 1;

if(isset($_GET['page'])) {
	$page = $_GET['page'];
}
$pagePrev= $page -1;
$pageNext= $page +1;

$offset = ($page - 1) * $pageSize;

//$sql .=  " LIMIT ($offset); ($pageSize)";
//$sql .=  'LIMIT ' . $offset . "," . $pageSize;
//fine codice impaginazione

$result = sqlsrv_query($conn, $sql);


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
						<?php if($pagePrev==0) { echo "class='disabled'"; }?>
						<?php if($pagePrev==0) { ?>
						<a href="#" aria-label="Previous">
							<span aria-hidden="true">&laquo;</span>
						</a>
						<?php } else { ?>
						<a href="index.php?page=<?php echo $pagePrev; ?>" aria-label="Previous">
							<span aria-hidden="true">&laquo;</span>
						</a>
						<?php } ?>
					</li>



					<li>
						<a href="index.php?page=<?php echo $pageNext; ?>" aria-label="Next">
							<span aria-hidden="true">&laquo;</span>
						</a>
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
