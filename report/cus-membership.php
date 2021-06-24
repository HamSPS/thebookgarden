<?php
     include '../connectdb.php';
     if (isset($_POST['cusID'])) {
    $sql = "SELECT cusID, cusName, gender,dateOfBirth,year(curdate())-year(dateOfBirth) AS age,address,img,tel,email FROM tbCustomer WHERE cusID = '$cusID'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $name = $row['cusName'];
    $img = $row['img'];
}
?>
<div class="row">
<div class="col-lg-12 d-inline-block align-top pr-5">
   <div class="row">
        <div class="col-md-3">
            <img src="../<?= @$row['img'] ?>" alt="ຮູບລູກຄ້າ">
        </div>
        <div class="col-md-9">
            <p>ຊື່ ແລະ ນາມສະກຸນ: <?= @$name ?></p>
        </div>
   </div>
</div>
</div>