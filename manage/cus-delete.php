<?php

include_once '../connectdb.php';
$cusID = $_POST['cusID'];
//ລືບຮູບ
$sql = "SELECT img FROM tbCustomer WHERE cusID='$cusID'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
$img = $row['img'];
//ລຶບຮູບດ້ວຍ unlink
unlink("$img");

//ລືບຂໍ້ມູນ
$sql = "DELETE FROM tbCustomer WHERE cusID='$cusID' ";
mysqli_query($con, $sql);