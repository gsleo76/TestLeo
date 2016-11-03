<?php 
include_once('inc/session.php');
include_once('inc/dbconfig.php');


if(isset($_GET['delete_id'])) {
  $id = $_GET['delete_id'];
  
  $sql_query = "SELECT clienti.ID, clienti.Cognome, clienti.Nome, comuni.Nome AS Citta FROM clienti LEFT JOIN comuni ON clienti.comuneId = comuni.ID WHERE clienti.ID=$id";
  if($result = $connection->query($sql_query)) {
    $row = $result->fetch_array();
  }
}


if(isset($_POST['btn-delete'])) {
  $id = $_POST['delete_id'];
  
  $sql_cmd = "DELETE FROM clienti WHERE ID=$id";
  if($connection->query($sql_cmd)) {
    echo "<script>window.location.href='clienti.php?saved=true';</script>";
  } else {
    echo "<script>alert('Errore di cancellazione record.');</script>";
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
    <input type="hidden" name="delete_id" value="<?php echo $row['ID']; ?>" >
    <div class="form-group col-md-6">
        <label>Cognome</label>
        <input type="text" disabled class="form-control" name="cognome" value="<?php echo $row['Cognome']; ?>" placeholder="Cognome">
    </div>
    <div class="form-group col-md-6">
        <label>Nome</label>
        <input type="text" disabled class="form-control" name="nome" value="<?php echo $row['Nome']; ?>" placeholder="Nome">
    </div>
    <div class="form-group col-md-6">
      
        <label>Città</label>
        <input type="text" class="form-control" name="citta" value="<?php echo $row['Citta']; ?>" placeholder="Città">
    </div>
    <div class="col-md-12">
      <a href="clienti.php" class="btn btn-default">Annulla</a> 
      <button type="submit" name="btn-delete" class="btn btn-danger">Cancella</button>    
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
