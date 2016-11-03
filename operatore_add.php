<?php
include_once('inc/session.php');
include_once('inc/dbconfig.php');

if(isset($_POST['btn-add'])) {
  $cognome  = ucwords(strtolower($_POST['cognome']));
  $nome     = ucwords(strtolower($_POST['nome']));
  $comuneId = $_POST['comuneId'];
  $repartoId = $_POST['repartoId'];

  $sql_cmd = "INSERT INTO operatori (cognome, nome, comuneId, repartoId) VALUES ('$cognome', '$nome', $comuneId, $repartoId) ";
  if($connection->query($sql_cmd)) {
    echo "<script>window.location.href='operatori.php?saved=true';</script>";
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
                    <label>Cognome</label>
                    <input type="text" required="required" minlength="4" class="form-control" name="cognome" placeholder="Cognome">
                </div>
                <div class="form-group col-md-6">
                    <label>Nome</label>
                    <input type="text" required="required" class="form-control" name="nome" placeholder="Nome">
                </div>
                <div class="form-group col-md-6">
                    <label>Città (Id)</label>
                    <select name="comuneId" class="form-control">
                      <option value="0">--- selezionare ---</option>
                      <?php
                        global $connection;
                        $sql_query = "SELECT ID, Nome FROM comuni ORDER BY Nome";
                        $result = $connection->query($sql_query);
                        while($row = $result->fetch_array()) {
                          $comune_id = $row['ID'];
                          $comune_nome = $row['Nome'];

                          echo "<option value='$comune_id'>$comune_nome</option>";
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
                        $sql_query = "SELECT ID, Nome FROM reparti ORDER BY Nome";
                        $result = $connection->query($sql_query);
                        while($row = $result->fetch_array()) {
                          $reparto_id = $row['ID'];
                          $reparto_nome = $row['Nome'];

                          echo "<option value='$reparto_id'>$reparto_nome</option>";
                        }
                      ?>
                    </select>
                </div>
                <div class="col-md-12">
                  <button type="submit" name="btn-add" class="btn btn-default">Salva</button>
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
