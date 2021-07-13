<?php 
    
    include 'head.php';
    include 'menu.php';
?>

<div class="container-fluid" style="margin-top: 15px">
    <div class="alert alert-success alert-dismissible" style="text-align: center">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>ລາຍງານຂໍ້ມູນຜູ້ສະໜອງ</strong>
    </div>

    <p class="d-flex justify-content-end">
        <a href="report/supplier-report-print.php" class="btn btn-info" target="_blank"><i class="fas fa-print"></i>
            ພີມລາຍງານ</a>
    </p>

    <div class="table-wrapper-scroll-y my-custom-scrollbar">
        <table class="table table-hover table-bordered" style="width:100%">
            <thead class="bg-dark text-white" style="text-align: center">
                <tr>
                    <th>ລະຫັດ</th>
                    <th>ຊື່ຜູ້ສະໜອງ</th>
                    <th>ຜູ້ຕິດຕໍ່</th>
                    <th>ເບີໂທ</th>
                    <th>ອີເມວ</th>
                    <th>ທີ່ຢູ່</th>
                </tr>
            </thead>
            <tbody>
                <?php
                        $sql = "SELECT * FROM tbSuppliers";
                        $result = mysqli_query($con, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            
                            ?>
                <tr>
                    <td style="text-align: center"><?= $row['sup_id'] ?></td>
                    <td><?= $row['sup_Name'] ?></td>
                    <td><?= $row['contactName'] ?></td>
                    <td class="text-center"><?= $row['sup_tel'] ?></td>
                    <td><?= $row['sup_email'] ?></td>
                    <td><?= $row['sup_address'] ?></td>
                </tr>
                <?php
                        }
                        ?>
            </tbody>
        </table>
    </div>
</div>


</div>
<?php 
    include 'footer.php';
?>


</body>

</html>