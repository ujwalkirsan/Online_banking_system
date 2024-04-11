<?php
session_start();
include('conf/config.php'); //get configuration file
if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = sha1(md5($_POST['password'])); //double encrypt to increase security
  $stmt = $mysqli->prepare("SELECT email, password, client_id  FROM iB_clients   WHERE email=? AND password=?"); //sql to log in user
  $stmt->bind_param('ss', $email, $password); //bind fetched parameters
  $stmt->execute(); //execute bind
  $stmt->bind_result($email, $password, $client_id); //bind result
  $rs = $stmt->fetch();
  $_SESSION['client_id'] = $client_id; //assaign session toc lient id
  //$uip=$_SERVER['REMOTE_ADDR'];
  //$ldate=date('d/m/Y h:i:s', time());
  if ($rs) { //if its sucessfull
    header("location:pages_dashboard.php");
  } else {
    #echo "<script>alert('Access Denied Please Check Your Credentials');</script>";
    $err = "Access Denied Please Check Your Credentials";
  }
}
/* Persisit System Settings On Brand */
$ret = "SELECT * FROM `iB_SystemSettings` ";
$stmt = $mysqli->prepare($ret);
$stmt->execute(); //ok
$res = $stmt->get_result();
while ($auth = $res->fetch_object()) {
?>
  <!DOCTYPE html>
  <html>
  <meta http-equiv="content-type" content="text/html;charset=utf-8" />
  <?php include("header.php"); ?>
  <head>

    <link rel="stylesheet" href="admin_login_style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
  <body class="hold-transition login-page">
    

          <form  method="post">
        <div class="flex-container-1">
          
  <div class="flex-item">
                <h2>Client Login</h2>
     
       </div>

            <label><b>Username</b></label>
            <div class="flex-item">
                <input name = "email" type="text" name="admin_uname" required>
   
         </div>

            <label><b>Password</b></label>
            <div class="flex-item">
                <input name = "password" type="password" name="admin_psw" required>
  
          </div>
        </div>

        <div class="flex-container-2">
            <div class="flex-item">
                <button name = "login" type="submit">Login</button>
   
         </div>

            <div class="flex-item">
                <button type="button" class="cancelbtn"><a href="pages_client_signup.php" class="text-center">Register a new account</a></button>
            </div>
   
     </div>
    </form>


          <!-- /.social-auth-links -->

          <!-- <p class="mb-1">
            <a href="pages_reset_pwd.php">I forgot my password</a>
          </p> -->

        
 

  
  </body>

  </html>
<?php
} ?>