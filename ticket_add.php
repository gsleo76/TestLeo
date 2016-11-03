<?php
include_once('inc/session.php');
include_once('inc/dbconfig.php');

if(isset($_POST['btn-add']) || isset($_POST['btn-add_assegna'])) {
  $clienteId = $_POST['clienteId'];
  $oggetto  = $_POST['oggetto'];
  $descrizione  = $_POST['descrizione'];
  $categoriaId = $_POST['categoriaId'];
  $owner = $login_session;
  $errori_sql=0;

	if(isset($_POST['btn-add']))  {
	  $statoId=1;       //stato default in fase di creazione
	  $operatoreId=0;
	} else {
	  $statoId=4;							//stato di default in fase di assegnazione
	  $operatoreId = $login_operatoreId;   //operatore logato a sistema
	}

  $sql_cmd = "INSERT INTO tickets";
  $sql_cmd .= " (clienteId, oggetto, descrizione, categoriaId, statoId, operatoreId, owner)";
  $sql_cmd .= " VALUES ($clienteId, '$oggetto', '$descrizione', $categoriaId, $statoId, $operatoreId, '$owner')";
  //echo $sql_cmd;
  
		if($connection->query($sql_cmd)) {   //fa insert into nella tickets
			$ticketid = $connection->insert_id; //restituisce l'ultimo id inserito in tabella
			
		//nel caso viene fatta l'operazione di assegnazione devo scrivere il record sulla tabella work
			if(isset($POST['btn-add-assegna'])) {
			  $sql_cmd = "INSERT INTO tickets_works";
			  $sql_cmd .= " (ticketId, statoId, operatoreId, Note)";
			  $sql_cmd .= " VALUES ($ticketId, $statoId, $operatoreId, 'autoassegnazione') ";

		if(!$connection->query($sql_cmd)) {  //il ! prima della $connection indica un errore nell'operazione di command
		$errori_sql++;
		//echo "<script>window.location.href='tickets.php?saved=true';</script>";
		//echo "<script>alert('Errore di salvataggio record.');</script>"; //condizione falsa dell/if di connection
		} 
			} 
		} else {
  $errori_sql++;
		}

//controlli errori sql per rerindirizzare alla pagina di tickets	
			if($errori_sql==0){
				echo "<script>window.location.href='tickets.php?saved=true';</script>";	
				} else {
				echo "<script>alert('Errore di salvataggio record.');</script>"; //condizione falsa dell/if di connection  
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
                    <select name="clienteId" class="form-control" required="required">
                      <option value="">--- selezionare ---</option>
                      <?php
                        global $connection;
                        $sql_query = "SELECT ID, CONCAT(Cognome, ' ', Nome) AS Cliente FROM Clienti ORDER BY Cognome, Nome";
                        $result = $connection->query($sql_query);
                        while($row = $result->fetch_array()) {
                          $cliente_id = $row['ID'];
                          $cliente_nominativo = $row['Cliente'];

                          echo "<option value='$cliente_id'>$cliente_nominativo</option>";
                        }
                      ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>Categoria</label>
                    <select name="categoriaId" class="form-control">
                      <option value="0">--- selezionare ---</option>
                      <?php
                        global $connection;
                        $sql_query = "SELECT ID, Nome FROM Categorie ORDER BY Nome";
                        $result = $connection->query($sql_query);
                        while($row = $result->fetch_array()) {
                          $categoria_id = $row['ID'];
                          $categoria_nome = $row['Nome'];

                          echo "<option value='$categoria_id'>$categoria_nome</option>";
                        }
                      ?>
                    </select>
                </div>
                <div class="form-group col-md-12">
                    <label>Oggetto</label>
                    <input type="text" required="required" minlength="4" class="form-control" name="oggetto" placeholder="Oggetto">
                </div>
                <div class="form-group col-md-12">
                    <label>descrizione</label>
                    <textarea class="form-control" 
                              rows="5" name="descrizione"></textarea>
                </div>
                <div class="col-md-12">
                  <button type="submit" name="btn-add" class="btn btn-default">Salva</button>
				  <button type="submit" name="btn-add-assegna" class="btn btn-default">Salva e assegna</button>
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
