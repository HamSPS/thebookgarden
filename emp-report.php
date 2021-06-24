<?php 
    
    include 'head.php';
    include 'menu.php';
?>

<div class="container-fluid" style="margin-top: 15px">
            <div class="alert alert-success alert-dismissible" style="text-align: center">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>ລາຍງານຂໍ້ມູນພະນັກງານ</strong>
            </div>

            <p class="d-flex justify-content-end">
                <a href="report/emp-report-print.php" class="btn btn-info" target="_blank"><i class="fas fa-print"></i> ພີມລາຍງານ</a>
            </p>

            <table class="table table-hover table-bordered" style="width:100%">
                <thead class="bg-dark text-white" style="text-align: center">
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
                    $sql = "SELECT stid, FirstName, LastName,gender,dateOfBirth,year(curdate())-year(dateOfBirth) AS age,address,img,tel,email,username FROM tbstaff";
                    $result = mysqli_query($con, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        
                        ?>
                        <tr>
                            <td style="text-align: center" ><?= $row['stid'] ?></td>
                            <td><?= $row['FirstName'] ?> <?= $row['LastName'] ?></td>
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

        
</div>
<?php 
    include 'footer.php';
?>


</body>

</html>