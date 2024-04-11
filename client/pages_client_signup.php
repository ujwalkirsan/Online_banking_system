<?php
session_start();
include('conf/config.php');

//register new account
if (isset($_POST['create_account'])) {
  //Register  Client
  $name = $_POST['name'];
  $national_id = $_POST['national_id'];
  $client_number = $_POST['client_number'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];
  $password = sha1(md5($_POST['password']));
  $address  = $_POST['address'];

  //$profile_pic  = $_FILES["profile_pic"]["name"];
  //move_uploaded_file($_FILES["profile_pic"]["tmp_name"],"dist/img/".$_FILES["profile_pic"]["name"]);

  //Insert Captured information to a database table
  $query = "INSERT INTO iB_clients (name, national_id, client_number, phone, email, password, address) VALUES (?,?,?,?,?,?,?)";
  $stmt = $mysqli->prepare($query);
  //bind paramaters
  $rc = $stmt->bind_param('sssssss', $name, $national_id, $client_number, $phone, $email, $password, $address);
  $stmt->execute();

  //declare a varible which will be passed to alert function
  if ($stmt) {
    $success = "Account Created";
  } else {
    $err = "Please Try Again Or Try Later";
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
  <html><!-- Log on to alphacodecamp.com.ng for more projects! -->
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
                <h2>Client Sign-Up</h2>
     
       </div>

            <label><b>Username</b></label>
            <div class="flex-item">
            <input type="text" name="name" required class="form-control" placeholder="Client Full Name">
   
         </div>

            <label><b>Id Number</b></label>
            <div class="flex-item">
            <input type="text" required name="national_id" class="form-control" placeholder="National ID Number">
  
          </div>
          <label><b>Client Number</b></label>
          <?php
              //PHP function to generate random
              $length = 4;
              $_Number =  substr(str_shuffle('0123456789'), 1, $length); ?>
            <div class="flex-item">
            <input type="text" name="client_number" value="iBank-CLIENT-<?php echo $_Number; ?>" class="form-control" placeholder="Client Number">
  
          </div>
          
          <label><b>Phone No</b></label>
            <div class="flex-item">
            <input type="text" name="phone" required class="form-control" placeholder="Client Phone Number">
  
          </div>
          <label><b>Address</b></label>
            <div class="flex-item">
            <input type="text" name="address" required class="form-control" placeholder="Client Address">
  
          </div>
          <label><b>Email</b></label>
            <div class="flex-item">
            <input type="text" name="email" required class="form-control" placeholder="Client Email Address">
  
          </div>
          <label><b>Password</b></label>
            <div class="flex-item">
            <input type="password" name="password" required class="form-control" placeholder="Password">
  
          </div>
        </div>

        <div class="flex-container-2">
            <div class="flex-item">
                <button type="submit" name="create_account" class="btn btn-success btn-block">Sign Up</button>
   
         </div>

            
         <p class="mb-0">
            <a href="pages_client_index.php" class="text-center">Login</a>
          </p>
     </div>
    </form>
    

  </body>
 

  </html>
<?php
} ?>