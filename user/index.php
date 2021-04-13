<?php
session_start();
if($_SESSION){
  if($_SESSION['role'] == 'User'){
  } else {
    header('location:../login.php');
  }
} else {
  header('location:../login.php');
}

include("../config/connection.php");
$hub = open_connection();
$a = @$_GET["a"];

switch($a) {
  case "list":
    read_data();
    break;
  case "logout":
    logout();
    break;
  default:
    read_data();
    break;
}

mysqli_close($hub);
?>

<?php
function read_data() {
  global $hub;
  $query = "SELECT * FROM dt_prodi";
  $result = mysqli_query($hub, $query);

  echo "<!DOCTYPE html>
    <html lang='en'>
      <head>
        <meta charset='UTF-8'/>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
        <link rel='stylesheet' href='../public/style.css'>
        <link rel='stylesheet' href='../public/fontawesome/css/all.css'/>
        <title>Topik 1 - PBD CRUD 1 TIER</title>
      </head>
      <body>
        <div class='container'>
          <div class='title'>
            <h2>Data Program Studi</h2>
            <p class='muted'>".$_SESSION['username']."@".$_SESSION['role']."</p>
          </div>
          <ul class='responsive-table'>
            <li class='table-header green'>
              <div class='col col-1'>ID</div>
              <div class='col col-2'>KODE</div>
              <div class='col col-3'>PRODI</div>
              <div class='col col-4'>AKREDITASI</div>
            </li>";
  
  while($row = mysqli_fetch_array($result)) {
    echo "<li class='table-row'>
              <div class='col col-1' data-label='ID'>".$row["idprodi"]."</div>
              <div class='col col-2' data-label='KODE'>".$row["kdprodi"]."</div>
              <div class='col col-3' data-label='PRODI'>".$row["nmprodi"]."</div>
              <div class='col col-4' data-label='AKREDITASI'>".$row["akreditasi"]."</div>
            </li>";
  }

  echo "<li class='button-input btn-bot'>
              <a href='index.php?a=logout' style='margin:0;'><button class='btn red'><i class='fas fa-sign-out-alt'></i> Logout</button></a>
            </li>
          </ul>
        </div>
      </body>
    </html>";
}

function logout() {
  session_start();
  session_destroy();
  header("location:../login.php");
}

?>