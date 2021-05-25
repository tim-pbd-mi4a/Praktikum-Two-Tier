<?php
session_start();
if($_SESSION){
  if($_SESSION['role'] == 'Admin'){
  } else {
    header('location:../login.php');
  }
} else {
  header('location:../login.php');
}

include("../config/connection.php");
$hub = open_connection();
$a = @$_GET["a"];
$id = @$_GET["id"];
$sql = @$_POST["sql"];

switch($sql) {
  case "create":
    create_prodi();
    break;
  case "update":
    update_prodi();
    break;
  case "delete":
    delete_prodi();
    break;
}

switch($a) {
  case "list":
    read_data();
    break;
  case "input":
    input_data();
    break;
  case "edit":
    edit_data($id);
    break;
  case "hapus":
    hapus_data($id);
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
        <title>Topik 2 - PBD CRUD 2 TIER</title>
      </head>
      <body>
        <div class='container'>
          <div class='title'>
            <h2>Data Program Studi</h2>
            <p class='muted'>".$_SESSION['username']."@".$_SESSION['role']."</p>
          </div>
          <ul class='responsive-table'>
            <li class='button-input'><a href='index.php?a=input'><button class='btn blue'><i class='fas fa-plus'></i> TAMBAH</button></a></li>
            <li class='table-header green'>
              <div class='col col-1'>ID</div>
              <div class='col col-2'>KODE</div>
              <div class='col col-3'>PRODI</div>
              <div class='col col-4'>AKREDITASI</div>
              <div class='col col-5'>AKSI</div>
            </li>";
  
  while($row = mysqli_fetch_array($result)) {
    echo "<li class='table-row'>
              <div class='col col-1' data-label='ID'>".$row["idprodi"]."</div>
              <div class='col col-2' data-label='KODE'>".$row["kdprodi"]."</div>
              <div class='col col-3' data-label='PRODI'>".$row["nmprodi"]."</div>
              <div class='col col-4' data-label='AKREDITASI'>".$row["akreditasi"]."</div>
              <div class='col col-5 aksi'>
                <a href='index.php?a=edit&id=".$row["idprodi"]."'><button class='btn yellow edit'><i class='fas fa-edit'></i></button></a>
                <a href='index.php?a=hapus&id=".$row["idprodi"]."'><button class='btn red'><i class='fas fa-trash'></i></button></a>
              </div>
            </li>";
  }

  echo "<li class='button-input btn-bot'>
              <a href='user.php'><button class='btn blue'><i class='fas fa-user'></i> User</button></a>
              <a href='index.php?a=logout'><button class='btn red'><i class='fas fa-sign-out-alt'></i> Logout</button></a>
            </li>
          </ul>
        </div>
      </body>
    </html>";
}

function input_data() {
  $row = array(
    "kdprodi" => "",
    "nmprodi" => "",
    "akreditasi" => "-"
  );

  $cekNull = ($row["akreditasi"] == "" ||$row["akreditasi"] == "-" ) ? "checked='checked'" : "";
  $cekA = ($row["akreditasi"] == "A") ? "checked='checked'" : "";
  $cekB = ($row["akreditasi"] == "B") ? "checked='checked'" : "";
  $cekC = ($row["akreditasi"] == "C") ? "checked='checked'" : "";
 
  echo "<!DOCTYPE html>
    <html lang='en'>
      <head>
        <meta charset='UTF-8'/>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
        <link rel='stylesheet' href='../public/style.css'>
        <link rel='stylesheet' href='../public/fontawesome/css/all.css'/>
        <title>Topik 2 - PBD CRUD 2 TIER</title>
      </head>
      <body>
        <div class='container'>
          <div class='title-a'>
            <h2>Input Data Program Studi</h2>
          </div>
          <div class='form'>
            <form action='index.php?a=list' method='post'>
              <input type='hidden' name='sql' value='create'>
              <input type='text' name='kdprodi' value='".trim($row["kdprodi"])."' placeholder='Kode Prodi'/>
              <input type='text' name='nmprodi' value='".trim($row["nmprodi"])."' placeholder='Nama Prodi'/>
              <group class='inline-radio'>
                <div class='akre'>Akreditasi</div>
                <div><input type='radio' name='akreditasi' value='A' $cekA><label>A</label></div>
                <div><input type='radio' name='akreditasi' value='B' $cekB><label>B</label></div>
                <div><input type='radio' name='akreditasi' value='C' $cekC><label>C</label></div>
                <div><input type='radio' name='akreditasi' value='-' $cekNull><label>-</label></div>
              </group>
              <input type='submit' class='btn blue' name='action' value='TAMBAH'>
            </form>
            <a href='index.php'><button class='btn red'>BATAL</button></a>
          </div>
        </div>
      </body>
    </html>";
}

function edit_data($id) {
  global $hub;
  $query = "SELECT * FROM dt_prodi WHERE idprodi=$id";
  $result = mysqli_query($hub, $query);
  $row = mysqli_fetch_array($result);

  $cekNull = ($row["akreditasi"] == "" ||$row["akreditasi"] == "-" ) ? "checked='checked'" : "";
  $cekA = ($row["akreditasi"] == "A") ? "checked='checked'" : "";
  $cekB = ($row["akreditasi"] == "B") ? "checked='checked'" : "";
  $cekC = ($row["akreditasi"] == "C") ? "checked='checked'" : "";

  echo "<!DOCTYPE html>
  <html lang='en'>
    <head>
      <meta charset='UTF-8'/>
      <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
      <link rel='stylesheet' href='../public/style.css'>
      <link rel='stylesheet' href='../public/fontawesome/css/all.css'/>
      <title>Topik 2 - PBD CRUD 2 TIER</title>
    </head>
    <body>
      <div class='container'>
        <div class='title-a'>
          <h2>Edit Data Program Studi</h2>
        </div>
        <div class='form'>
          <form action='index.php?a=list' method='post'>
            <input type='hidden' name='sql' value='update'>
            <input type='hidden' name='idprodi' value='".trim($id)."'/>
            <input type='text' name='kdprodi' value='".trim($row["kdprodi"])."' placeholder='Kode Prodi'/>
            <input type='text' name='nmprodi' value='".trim($row["nmprodi"])."' placeholder='Nama Prodi'/>
            <group class='inline-radio'>
              <div class='akre'>Akreditasi</div>
              <div><input type='radio' name='akreditasi' value='A' $cekA><label>A</label></div>
              <div><input type='radio' name='akreditasi' value='B' $cekB><label>B</label></div>
              <div><input type='radio' name='akreditasi' value='C' $cekC><label>C</label></div>
              <div><input type='radio' name='akreditasi' value='-' $cekNull><label>-</label></div>
            </group>
            <input type='submit' class='btn blue' name='action' value='PERBARUI'>
          </form>
          <a href='index.php'><button class='btn red'>BATAL</button></a>
        </div>
      </div>
    </body>
  </html>";
}

function hapus_data($id) {
  global $hub;
  $query = "SELECT * FROM dt_prodi WHERE idprodi = $id";
  $result = mysqli_query($hub, $query);
  $row = mysqli_fetch_array($result);

  $cekNull = ($row["akreditasi"] == "" ||$row["akreditasi"] == "-" ) ? "checked='checked'" : "";
  $cekA = ($row["akreditasi"] == "A") ? "checked='checked'" : "";
  $cekB = ($row["akreditasi"] == "B") ? "checked='checked'" : "";
  $cekC = ($row["akreditasi"] == "C") ? "checked='checked'" : "";

  echo "<!DOCTYPE html>
  <html lang='en'>
    <head>
      <meta charset='UTF-8'/>
      <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
      <link rel='stylesheet' href='../public/style.css'>
      <link rel='stylesheet' href='../public/fontawesome/css/all.css'/>
      <title>Topik 2 - PBD CRUD 2 TIER</title>
    </head>
    <body>
      <div class='container'>
        <div class='title-a'>
          <h2>Hapus Data Program Studi</h2>
        </div>
        <div class='form'>
          <form action='index.php?a=list' method='post'>
            <input type='hidden' name='sql' value='delete'>
            <input type='hidden' name='idprodi' value='".trim($id)."'/>
            <input type='text' name='kdprodi' value='".trim($row["kdprodi"])."' placeholder='Kode Prodi' disabled/>
            <input type='text' name='nmprodi' value='".trim($row["nmprodi"])."' placeholder='Nama Prodi'disabled/>
            <group class='inline-radio'>
              <div class='akre'>Akreditasi</div>
              <div><input type='radio' name='akreditasi' value='A' $cekA disabled><label>A</label></div>
              <div><input type='radio' name='akreditasi' value='B' $cekB disabled><label>B</label></div>
              <div><input type='radio' name='akreditasi' value='C' $cekC disabled><label>C</label></div>
              <div><input type='radio' name='akreditasi' value='-' $cekNull disabled><label>-</label></div>
            </group>
            <input type='submit' class='btn blue' name='action' value='HAPUS'>
          </form>
          <a href='index.php'><button class='btn red'>BATAL</button></a>
        </div>
      </div>
    </body>
  </html>";
}

function create_prodi() {
  global $hub;
  global $_POST;
  $query = "INSERT INTO dt_prodi (kdprodi, nmprodi, akreditasi) VALUES ('".$_POST["kdprodi"]."', '".$_POST["nmprodi"]."', '".$_POST["akreditasi"]."')";
  mysqli_query($hub, $query) or die(mysqli_error());
}

function update_prodi() {
  global $hub;
  global $_POST;
  $query = "UPDATE dt_prodi SET kdprodi='".$_POST["kdprodi"]."', nmprodi='".$_POST["nmprodi"]."', akreditasi='".$_POST["akreditasi"]."' WHERE idprodi=".$_POST["idprodi"];
  mysqli_query($hub, $query) or die(mysqli_error());
}

function delete_prodi() {
  global $hub;
  global $_POST;
  $query = "DELETE FROM dt_prodi WHERE idprodi = ".$_POST['idprodi'];
  mysqli_query($hub, $query) or die(mysqli_error());
}

function logout() {
  session_start();
  session_destroy();
  header("location:../index.php");
}

?>