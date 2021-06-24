<?php

include_once '../connectdb.php';
$catID = $_POST['catID'];

//ລືບຂໍ້ມູນ
$sql = "DELETE FROM tbCategory WHERE catID='$catID' ";
mysqli_query($con, $sql);