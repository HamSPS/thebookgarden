<?php

include_once '../connectdb.php';
$stid = $_POST['stid'];
//ລືບຮູບ
$sql = "SELECT img FROM tbstaff WHERE stid='$stid'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
$img = $row['img'];
//ລຶບຮູບດ້ວຍ unlink
unlink("$img");

//ລືບຂໍ້ມູນ
$sql = "DELETE FROM tbstaff WHERE stid='$stid' ";
mysqli_query($con, $sql);