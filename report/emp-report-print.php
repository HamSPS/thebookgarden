<?php 
    include '../connectdb.php';
    include '../check-login.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <title>ລາຍງານຂໍ້ມູນພະນັກງານ</title>
    <style>
        body{
            font-family: NotoSansLao;
        }
        p{
            font-size: larger;
        }
    </style>
</head>
<body onload="window.print()">
<div class="container">
    
    
    <div class="col-md-12">
                <div class="mt-1 text-center">
                    <div>
                    <img src="../images/icon.svg" width="100px" alt="the Book Garden">
                    </div>
                    <div class="row2">
                        <h4>ຮ້ານສວນໜັງສື<br>
                        Book Garden</้>
                    </div>
                </div>
                <h3 class="text-center mt-5"><u>ລາຍງານຂໍ້ມູນພະນັກງານ</u></h3>
                <p>ວັນທີ: <?= @date("d/m/Y"); ?></p>
                <p>ຜູ້ໃຊ້ງານ: <?= @$_SESSION['name'] ?></p>
                <table class="table table-bordered" style="width:100%">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>ລະຫັດ</th>
                            <th>ຊື່ ແລະ ນາມສະກຸນ</th>
                            <th>ເພດ</th>
                            <th>ອາຍຸ</th>
                            <th>ຊື່ບັນຊີຜູ້ໃຊ້</th>
                            <th>ອີເມວ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT stid, FirstName, lastName,gender,dateOfBirth,year(curdate())-year(dateOfBirth) AS age,address,img,tel,email,username FROM tbstaff";
                        $result = mysqli_query($con, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            
                            ?>
                            <tr>
                                <td style="text-align: center" ><?= $row['stid'] ?></td>
                                <td><?= $row['FirstName'] ?> <?= $row['lastName'] ?></td>
                                <td style="text-align: center"><?= $row['gender'] ?></td>
                                <td style="text-align: right"><?= $row['age'] ?></td>
                                <td><?= $row['username'] ?></td>
                                <td><?= $row['email'] ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>

            </div>
            <div style="page-break-before: always;"></div>
</div>
</body>
</html>