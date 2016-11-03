<?php
include_once('inc/session.php');
include_once('inc/dbconfig.php');

if(isset($_GET['edit_id'])) {
  $id = $_GET['edit_id'];

  $sql_query = "SELECT * FROM vTickets WHERE ID=$id";
  if($result = $connection->query($sql_query)) {
    $rowTicket = $result->fetch_array();
  }
}


if(isset($_POST['btn-edit'])) {
  $statoId  = $_POST['statoId'];
  $repartoId = $_POST['repartoId'];
  $note = $_POST['Note'];
  $operatoreId= $login_operatoreId;


  $sql_cmd = "INSERT INTO tickets_work";
  $sql_cmd .= " (Id, statoId, operatoreId, repartoId, Note)";
  $sql_cmd .= " VALUES ($id, $statoId, $operatoreId, $repartoId, '$note') ";

  if($connection->query($sql_cmd)) {
	$sql_cmd = "UPDATE tickets_work SET operatoreId= $operatoreId,  statoId= $statoId, repartoId= $repartoId  WHERE Id=$id";
		if($connection->query($sql_cmd)) {
			echo "<script>window.location.href='tickets.php?saved=true';</script>";
			} else {
			echo "<script>alert('Errore di aggiornamento record.');</script>";
			}

    echo "<script>window.location.href='tickets.php?saved=true';</script>";
  } else {
    echo "<script>alert('Errore di salvataggio record.');</script>";
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

              <form action="#" method="POST">
                <div class="form-group col-md-6">
                    <label>Cliente</label>
                    <input class="form-control" type="text" 
                           value="<?php echo $rowTicket['Cliente']; ?>" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label>Stato</label>
                    <input class="form-control" type="text" 
                           value="<?php echo $rowTicket['Stato']; ?>" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label>Categoria</label>
                    <input class="form-control" type="text" 
                           value="<?php echo $rowTicket['Categoria']; ?>" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label>Operatore</label>
                    <input class="form-control" type="text" 
                           value="<?php echo $rowTicket['Operatore']; ?>" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label>Reparto</label>
                    <input class="form-control" type="text" 
                           value="<?php echo $rowTicket['Reparto']; ?>" readonly>
                </div>
                <div class="form-group col-md-12">
                    <label>Oggetto</label>
                    <input class="form-control" type="text" 
                           value="<?php echo $rowTicket['Oggetto']; ?>" readonly>
                </div>
                <div class="form-group col-md-12">
                    <label>Descrizione</label>
                    <textarea class="form-control" 
                              rows="5" readonly><?php echo $rowTicket['Descrizione']; ?></textarea>
                </div>
              </form>

			  </div>
			  <div class="row">
			   <h2>Gestione ticket</h2></div>
			   <form action="#" method="POST">
                <div class="form-group col-md-6">
                    <label>Stato</label>
                    <select name="statoId" class="form-control" required="required">
                      <option value="">--- selezionare ---</option>
                      <?php
                        global $connection;
                        $sql_query = "SELECT ID, Nome FROM Stati ORDER BY Nome";
                        $result = $connection->query($sql_query);
                        while($row = $result->fetch_array()) {
                          $stato_id = $row['ID'];
                          $stato_nome = $row['Nome'];

                          echo "<option value='$stato_id'>$stato_nome</option>";
                        }
                      ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>Reparto</label>
                    <select name="repartoId" class="form-control">
                      <option value="0">--- selezionare ---</option>
                      <?php
                        global $connection;
                        $sql_query = "SELECT ID, Nome FROM Reparti ORDER BY Nome";
                        $result = $connection->query($sql_query);
                        while($row = $result->fetch_array()) {
                          $reparto_id = $row['ID'];
                          $reparto_nome = $row['Nome'];

                          echo "<option value='$reparto_id'>$reparto_nome</option>";
                        }
                      ?>
                    </select>
                </div>
               
                <div class="form-group col-md-12">
                    <label>descrizione</label>
                    <textarea class="form-control" 
                              rows="5" name="Note"></textarea>
                </div>
                <div class="col-md-12">
                  <button type="submit" name="btn-edit" class="btn btn-default">Aggiorna ticket</button>
				  <!--<button type="submit" name="btn-add-assegna" class="btn btn-default">Salva e assegna</button>-->
                </div>
              </form>

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
