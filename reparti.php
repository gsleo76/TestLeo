<?php
include_once('inc/session.php');
include_once('inc/dbconfig.php');

$title = "Corso VS - Reparti";
$pageHeader = "Reparti";

global $connection;


$edit_id = 0;
//Controllo accesso per editing....
if(isset($_GET['edit_id'])){
    $edit_id = $_GET['edit_id'];
}

//Controllo accesso per salvataggio edit
if(isset($_POST['btn-edit'])){
    $id = $_POST['id'];
    $reparto = ucwords(strtolower($_POST['reparto']));

    if(strlen($reparto)>0){

        $sql_query = "SELECT COUNT(ID) AS Totale FROM Reparti WHERE Nome='$reparto'";
        $result = $connection->query($sql_query);
        $row = $result->fetch_Array();

        if($row['Totale']==0){
            $sql_cmd = "UPDATE Reparti SET Nome='$reparto' WHERE ID=$id";
            if($connection->query($sql_cmd)) {
                $saved = true;
            }
        } else {
            $exist = true;
        }
    }
}


//Controllo accesso per delete
if(isset($_GET['delete_id'])){
    $id = $_GET['delete_id'];

    $sql_cmd = "DELETE FROM Reparti WHERE ID=$id";
    if($connection->query($sql_cmd)) {
        $deleted = true;
    }
}

if(isset($_GET['btn-add']) && isset($_GET['reparto'])){
    $reparto = ucwords(strtolower($_GET['reparto']));

    if(strlen($reparto)>0){

        $sql_query = "SELECT COUNT(ID) AS Totale FROM Reparti WHERE Nome='$reparto'";
        $result = $connection->query($sql_query);
        $row = $result->fetch_Array();

        if($row['Totale']==0){
            $sql_cmd = "INSERT INTO Reparti (Nome) VALUES ('$reparto')";
            if($connection->query($sql_cmd)) {
                $saved = true;
            }
        } else {
            $exist = true;
        }
    }
}

$sql_query = "SELECT * FROM Reparti";

if(isset($_GET['search'])) {
    $sql_query .= " WHERE Nome LIKE '%" . $_GET['search'] .  "%'";
}
$sql_query .= " ORDER BY Nome";

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
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    Record cancellato con successo!
                </div>
                <?php } ?>

                <?php if(isset($exist)) {  ?>
                <!-- Inserire nota per salvataggio con successo -->
                <div class="alert alert-warnig alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    Record già presente!
                </div>
                <?php } ?>

                <?php if(isset($saved)) { ?>
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
                <div class="col-md-4">
                    <button id="btn-add" class="btn btn-success" onClick="show_add()">
                        <i class="fa fa-plus"></i>
                    </button>

                    <form id="form-add" style="display:none;" action="#" method="GET" class="form-inline">
                        <div class="input-group">
                            <input type="text" class="form-control" name="reparto" placeholder="aggiungi reparto..." />
                        </div><!-- /input-group -->
                        <button type="submit" class="btn btn-success" name="btn-add">Aggiungi</button>
                    </form>
                </div>


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
                            <th>Id</th>
                            <th>Reparto</th>
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
                                 ?>
                                    <td>                                           
                                        <span id="span-<?php echo $row['ID']; ?>"><?php echo $row['Nome']; ?></span>
                           
                                        <form id="form-edit-<?php echo $row['ID']; ?>" style="display:none" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="form-inline">
                                            <input type="hidden" name="id" value="<?php echo $row['ID']; ?>" />
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="reparto" value="<?php echo $row['Nome']; ?>" />
                                            </div><!-- /input-group -->
                                            <button type="submit" class="btn btn-success" name="btn-edit">Salva</button>
                                        </form>
                                    
                                    
                                    </td>
                                <td>
                                    <button class='btn btn-default btn-sm' onClick="select(<?php echo $row['ID']; ?>)">
                                        modifica
                                    </button>
                                    <!--
                                    <a href='reparti.php?delete_id=<?php echo $row['ID']; ?>'
                                        class='btn btn-danger btn-sm'>
                                        cancella
                                    </a>
                                    -->
                                    <button class='btn btn-danger btn-sm'
                                        onclick="show_modal(<?php echo $row['ID']; ?>, '<?php echo $row['Nome']; ?>')">
                                        cancella
                                    </button>

                                </td>
                        <?php 
                                echo "</tr>";
                            }
                        }
                        ?>

                    </tbody>
                </table>


                <h2>Record Selezionato: <span id="record_id" ></span> </h2>
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

        <!-- Modals -->
        <div class="modal fade" id="formConferma" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Conferma di cancellazione</h4>
                    </div>
                    <div class="modal-body">
                        <p>Cancellare il record: <span id="lblConferma"></span> ?  </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>

                        <a id="btnConferma" href="#" class="btn btn-primary">Cancella</a>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


        <!-- script section -->
        <?php include('html/layout/script.php'); ?>


        <script>
            function select(id) {
                /*
                var span = document.getElementById('span-' + id);
                var form = document.getElementById('form-edit-' + id);

                form.style.display = "block";
                span.style.display = "none";
                */

                $('#span-' + id).hide();
                $('#form-edit-' + id).show();


            }

        function show_add() {
            var btn = document.getElementById('btn-add');
            var form = document.getElementById('form-add');

            form.style.display = "block";
            btn.style.display = "none";
        }

        function show_modal(id, reparto) {
            $('#lblConferma').text(reparto);
            $('#btnConferma').attr('href', 'reparti.php?delete_id=' + id);

            $('#formConferma').modal('show');
        }
        </script>
</body>

</html>
