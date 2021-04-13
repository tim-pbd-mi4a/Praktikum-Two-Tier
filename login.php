<?php
session_start();
include("./config/connection.php");
if(isset($_POST["submit"])) {
  $conn = open_connection();
  $username = $_POST["username"];
  $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
  $query = "select * from dt_user where username='$username'";
  $hasil = mysqli_query($conn, $query);
  if($username != "" && $password != "") {
    if(mysqli_num_rows($hasil) > 0) {
      $hasil = mysqli_fetch_assoc($hasil);
      if(password_verify($_POST["password"], $hasil["password"])){
        if($hasil["role"] == "Admin") {
          $_SESSION["role"] = $hasil["role"];
          $_SESSION["username"] = $hasil["username"];
          header("location:admin/index.php");
        } else {
          $_SESSION["role"] = $hasil["role"];
          $_SESSION["username"] = $hasil["username"];
          header("location:user/index.php");
        }
      } else {
        $_SESSION["msg"] = "Username atau password salah!";
      }
    } else {
      $_SESSION["msg"] = "Username atau password salah!";
    }
  } else {
    $_SESSION["msg"] = "Jangan kosongkan form!";
  }
}

?>

<!DOCTYPE html>
<html lang='en'>
  <head>
    <meta charset='UTF-8'/>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
    <link rel='stylesheet' href='./public/style.css'>
    <link rel='stylesheet' href='./public/fontawesome/css/all.css'/>
    <title>Topik 1 - PBD CRUD 1 TIER</title>
  </head>
  <body>
    <div class='container'>
      <div class='title-a'>
        <h2>Login</h2>
      </div>
      <div class='form'>
        <form action='' method='post'>
          <?php if(isset($_SESSION["msg"])) { echo "<p class='msg'>* ".$_SESSION['msg']."</p>"; unset($_SESSION["msg"]); } ?>
          <input type='text' name='username' placeholder='Username'/>
          <input class="password" type='password' name='password' placeholder='Password'/>
          <i class="fas fa-eye fa-sm field-icon toggle-password"></i>
          <input type='submit' class='btn blue' name='submit' value='LOGIN'>
        </form>
      </div>
    </div>
    <script src="./public/jquery-3.6.0.min.js"></script>
    <script src="./public/script.js"></script>
  </body>
</html>