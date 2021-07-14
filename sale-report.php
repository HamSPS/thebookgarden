<?php 
    $where = '';
    $start = '';
    $end = '';
    if (isset($_POST['search'])) {
        $start = $_POST['start'];
        $end = $_POST['end'];
        $where = empty($start) && empty($end) ? " " : "WHERE sl_date >= '$start' AND sl_date <= '$end'";
    }
    include 'connectdb.php';
    include 'head.php';
    include 'menu.php';
?>

<div class="container-fluid" style="margin-top: 15px">
    <div class="alert alert-success alert-dismissible" style="text-align: center">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>ລາຍງານຂໍ້ມູນການຂາຍ</strong>
    </div>

    <p class="d-flex justify-content-end">
        <a href="report/sale-print.php?start=<?= $start ?>&end=<?= $end ?>" class="btn btn-info" target="_blank"><i
                class="fas fa-print"></i>
            ພີມລາຍງານ</a>
    </p>

    <form action="" method="post" class="mb-3">
        <div class="col-md-4">
            <div class="d-flex">
                <div class="input-group">
                    <input type="date" name="start" id="start" class="form-control" required>
                    <input type="date" name="end" id="end" class="form-control" required>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" name="search" type="submit"><i
                                class="fas fa-search"></i></button>
                    </div>
                </div>
                <button type="button" name="clear" id="clear" class="btn btn-primary ml-2"><i
                        class="fas fa-sync"></i></button>
            </div>
        </div>
    </form>




    <table class="table table-hover table-bordered display" style="width:100%">
        <thead class="bg-dark text-white" style="text-align: center">
            <tr>
                <th>ລະຫັດ</th>
                <th>ວັນທີຂາຍ</th>
                <th>ຊື່ພະນັກງານ</th>
                <th>ຈຳນວນ</th>
                <th>ລາຄາລວມ</th>
                <th>ຈຳນວນທີ່ຈ່າຍ</th>
            </tr>
        </thead>
        <tbody>
            <?php
                        $sql = "SELECT slID,sl_date,FirstName,lastName,total_price,sl_pay FROM tbsale sl LEFT JOIN tbstaff st ON sl.stID=st.stid $where ORDER BY slID";
                        $result = mysqli_query($con, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            
                            ?>
            <tr>
                <td align="center"><?= $row['slID'] ?></td>
                <td align="center"><?= $row['sl_date'] ?></td>
                <td><?= $row['FirstName'] ?> <?= $row['lastName'] ?></td>
                <td align="center">
                    <?php
                            $detail = mysqli_query($con, "SELECT * FROM sale_detail WHERE slid = '$row[slID]'");
                            $d = mysqli_num_rows($detail);
                            echo $d;
                        ?>
                </td>
                <td align="right"><?= number_format($row['total_price'],2) ?> ກີບ</td>
                <td style="text-align: right">
                    <?php
                    if ($row['sl_pay'] == "") {
                        echo "";
                    }else{
                        echo $row['sl_pay'] .' ກີບ';
                    }
                ?>
                </td>
            </tr>
            <?php
                        }
                        ?>
        </tbody>
    </table>
</div>
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">ລາຍລະອຽດຂໍ້ມູນລູກຄ້າ</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" id="show_detail">

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <a href="report/cus-membership.php?cusID=<?= $row['cusID'] ?>" class="btn btn-success"
                    data-toggle="tooltip" data-placement="bottom" title="ແກ້ໄຂ"><i class="fas fa-print"></i> ພິມບັດ</a>
                <button type="button" class="btn btn-danger" data-dismiss="modal">ປິດ</button>
            </div>

        </div>
    </div>
</div>

</div>


<?php 
    include 'footer.php';
?>

<script>
$('#clear').click(function() {
    window.location.href = "sale-report.php";
})
</script>

</body>

</html>