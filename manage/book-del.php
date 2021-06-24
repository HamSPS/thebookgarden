<?php
include '../connectdb.php';

$Bkid = $_POST['Bkid'];

$sql = "SELECT img FROM tbBook WHERE Bkid = '$Bkid'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
$img = $row['img'];
unlink($img);

$sql = "DELETE FROM tbBook WHERE Bkid = '$Bkid'";
mysqli_query($con, $sql);