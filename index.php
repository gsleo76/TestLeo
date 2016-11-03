<?php
  include_once('inc/session.php');
  include_once('inc/connection.php');

  $pageHeader = "Dashboard";
  
  // Commento di prov per verifica git
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

            <div class="jumbotron">
              <div class="container">
                <h1>Portale Desktop Managment</h1>
                <p>Consultazione delle lavorazioni di HDA e reportistca di riferimento.</p>
              </div>
            </div>
            <!-- /.jumbotron -->

            <!-- Dashboard -->
            <?php include('html/partials/dashboard.php'); ?>

            <div class="row">
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
