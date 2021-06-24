<?php
    include '../connectdb.php';

    $getid = $_POST['cur_id'];

    $sql = "DELETE FROM tbcurrency WHERE cry_ID = '$getid'";
    mysqli_query($con, $sql);

?>