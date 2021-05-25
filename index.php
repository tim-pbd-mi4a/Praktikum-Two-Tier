<?php
session_start();
if($_SESSION){
  if($_SESSION['role'] == 'Admin'){
    header('location:./admin/index.php');
  } else if($_SESSION['role'] == 'User') {
    header('location:./user/index.php');
  } else {
    header("location:../login.php");
  }
} else {
  header('location:../login.php');
}
?>