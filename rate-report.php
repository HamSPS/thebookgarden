<?php 
    
    include 'head.php';
    include 'menu.php';
?>

<div class="container-fluid" style="margin-top: 15px">
    <div class="alert alert-success alert-dismissible" style="text-align: center">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>ລາຍງານຂໍ້ມູນອັດຕາແລກປ່ຽນ</strong>
    </div>

    <p class="d-flex justify-content-end">
        <a href="report/rate-print.php" class="btn btn-info" target="_blank"><i class="fas fa-print"></i>
            ພີມລາຍງານ</a>
    </p>

    <div class="table-wrapper-scroll-y my-custom-scrollbar">
        <table class="table table-hover table-bordered" style="width:100%">
            <thead class="bg-dark text-white" style="text-align: center">
                <tr>
                    <th>ລະຫັດອັດຕາແລກປ່ຽນ</th>
                    <th>ຊື່ສະກຸນເງິນ</th>
                    <th>ອັດຕາແລກປ່ຽນ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                        $sql = "SELECT * FROM tbcurrency";
                        $result = mysqli_query($con, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            
                            ?>
                <tr>
                    <td style="text-align: center"><?= $row['cry_ID'] ?></td>
                    <td><?= $row['cry_name'] ?></td>
                    <td class="text-right"><?= number_format($row['cry_num'],2) ?> ກີບ</td>
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