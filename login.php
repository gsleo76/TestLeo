<?php
   ob_start();
   session_start();

   include('inc/connection.php');

   $title = 'Helpdesk - Login';

   // Controllo username e password per accesso
   if (isset($_POST['btn-login']) &&
       !empty($_POST['username']) && !empty($_POST['password'])) {


	   $myusername = $_POST ['username'];
	   $mypassword = $_POST ['password'];
	   //$myusername = "leonardo.licata";
	   //$mypassword = "a1b2c3";
	 // mysqli_real_escape_string posta dopo le definizioni delle due variabili myusername e mypassword

     $sql = "SELECT IDTecnico, Cognome + ' ' + Nome as Utente, UserName FROM TABPersonale WHERE UserName = '$myusername' and Password = '$mypassword'";
	 //$sql_query = "SELECT IDTecnico, Cognome + ' ' + Nome as Utente, UserName FROM TABPersonale WHERE UserName = 'leonardo.licata' and Password = 'a1b2c3'";

     //$result = mysqli_query($connection,$sql_query);
	 $result = sqlsrv_query($conn, $sql, array(), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
     //$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	 $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC);
     //$active = $row[0];
	 
     $count = sqlsrv_num_rows($result);

     // If result matched $myusername and $mypassword, table row must be 1 row


     if($count == 1) {
       //session_register("myusername");
       $_SESSION['login_user'] = $myusername;

       header("location: index.php");
     }else {
       $error = "Dati autenticazione non validi, riprovare!";
	 }
   }


?>

<!DOCTYPE html>
<html lang="it">

<head>
  <?php include('html/layout/head.php'); ?>
</head>

<body>

  <div class="container">
      <div class="row">
                <?php if(isset($error) && !empty($error)) { ?>
                  <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Messaggio: </strong> <?php echo $error; ?>
                  </div>
                <?php } ?>
      </div>
      <div class="row">
          <div class="col-md-4 col-md-offset-4">
              <div class="login-panel panel panel-default">
                  <div class="panel-heading">
                      <h3 class="panel-title">Area Riservata</h3>
                  </div>
                  <div class="panel-body">
                      <form role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                          <fieldset>
                              <div class="form-group">
                                  <input class="form-control" placeholder="Username" name="username" type="text" autofocus>
                              </div>
                              <div class="form-group">
                                  <input class="form-control" placeholder="Password" name="password" type="password" value="">
                              </div>
                              <div class="checkbox">
                                  <label>
                                      <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                  </label>
                              </div>
                              <!-- Change this to a button or input when using this as a form -->
                              <button type="submit" name="btn-login" class="btn btn-lg btn-success btn-block">Login</button>
                          </fieldset>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>

    <!-- script section -->
    <?php include('html/layout/script.php'); ?>
</body>

</html>
