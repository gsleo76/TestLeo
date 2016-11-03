<?php
   session_start();
/*
   unset($_SESSION["username"]);
   unset($_SESSION["password"]);

   echo 'Logout effettuato con Successo! redirect verso pagina di Login.';
   header('Refresh: 2; URL = login.php');
*/
  session_unset();
  session_destroy();
  header("Location: login.php");
?>
