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
        .myrow{
            display:grid;
            grid-template-columns: 110px 1fr;
            grid-gap: 0 15px;
        }
        .myrow .row2 p{

        }
    </style>
</head>
<body onload="window.print()">
<div class="container">
                <div class="myrow pt-5">
                    <div>
                    <img src="../images/icon.png" width="100px" alt="the Book Garden">
                    </div>
                    <div class="row2">
                        <p>ຮ້ານສວນໜັງສື<br>
                        Book Garden</p>
                    </div>
                </div>
            

            <div class="col-md-12">
                <h3 class="text-center">ລາຍງານຂໍ້ມູນລູກຄ້າ</h3>
                <div class="d-flex flex-row">
                    <div class="flex-fill"><p>ວັນທີ: <?= @date("d/m/Y"); ?></p></div>
                    <div class="justify-content-end"><p>ຜູ້ໃຊ້ງານ: <?= @$_SESSION['name'] ?></p></div>
                </div>
                <table class="table table-hover table-bordered" id="example" style="width:100%">
                <thead class="bg-dark text-white" style="text-align: center">
                    <tr>
                        <th>ລະຫັດ</th>
                        <th>ຊື່ ແລະ ນາມສະກຸນ</th>
                        <th>ເພດ</th>
                        <th>ວັນເດືອນປີເກີດ</th>
                        <th>ອາຍຸ</th>
                        <th>ເບີໂທ</th>
                        <th>ອີເມວ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT cusID, cusName,gender,dateOfBirth,year(curdate())-year(dateOfBirth) AS age,address,img,tel,email FROM tbCustomer";
                    $result = mysqli_query($con, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        
                        ?>
                        <tr>
                            <td style="text-align: center" ><?= $row['cusID'] ?></td>
                            <td><?= $row['cusName'] ?></td>
                            <td style="text-align: center"><?= $row['gender'] ?></td>
                            <td><?= $row['dateOfBirth'] ?></td>
                            <td style="text-align: right"><?= $row['age'] ?></td>
                            <td><?= $row['tel'] ?></td>
                            <td><?= $row['email'] ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>

            </div>
</div>
</body>
</html>