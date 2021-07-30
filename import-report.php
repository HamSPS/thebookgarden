<?php 
    $where = '';
    $start = '';
    $end = '';
    if (isset($_POST['search'])) {
        $start = $_POST['start'];
        $end = $_POST['end'];
        $where = empty($start) && empty($end) ? " " : " WHERE imp_date >= '$start' AND imp_date <= '$end'";
    }
    include 'connectdb.php';
    include 'head.php';
    include 'menu.php';
?>

<div class="container-fluid" style="margin-top: 15px">
    <div class="alert alert-success alert-dismissible" style="text-align: center">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>ລາຍງານຂໍ້ມູນການນຳເຂົ້າ</strong>
    </div>

    <p class="d-flex justify-content-end">
        <a href="report/report-import-print.php?start=<?= $start ?>&end=<?= $end ?>" class="btn btn-info" target="_blank"><i
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




    <table class="table table-hover table-bordered" style="width:100%">
        <thead class="bg-dark text-white" style="text-align: center">
            <tr>
                <th>ລຳດັບ</th>
                <th>ລະຫັດການນຳເຂົ້າ</th>
                <th>ລາຍລະອຽດການນຳເຂົ້າ</th>
                <th>ຈຳນວນທັງໝົດ</th>
                <th>ລາຄາລວມ</th>
                <th>ພະນັກງານ</th>
                <th>ວັນທີນຳເຂົ້າ</th>
            </tr>
        </thead>
        <tbody>
        <?php 
            $sql="SELECT impid,DATE_FORMAT(imp_date, '%d/%M/%Y') as date,FirstName,LastName FROM tbimport i left JOIN tbstaff s ON i.stid=s.stid $where";
            $result = mysqli_query($con, $sql);
            $i=0;
            while($row = mysqli_fetch_array($result)){
                $i++;
        ?>
            <tr>
                <td><?= $i ?></td>
                <td><?= $row['impid'] ?></td>
                <td>
                    <?php
                        $cnt=0;
                        $j=0;
                        $sum=0;
                        $check = $row['impid'];
                        $fetch = mysqli_query($con, "SELECT bid,bkName,qty,im.price FROM import_detail im left JOIN tbbook b ON im.bid=b.Bkid WHERE impid='$check'");
                        while ($detail = mysqli_fetch_array($fetch)) {
                            $j++;
                            $cnt+=$detail['qty'];
                            $sum+=$detail['price'];
                            echo "ລາຍການ ".$j.": ".$detail['bkName']." <br>";
                        }
                    ?>
                </td>
                <td class="text-center"><?= $cnt ?></td>
                <td class="text-right"><?= number_format($sum, 2) ?> ກີບ</td>
                <td><?= $row['FirstName'] ?> <?= $row['LastName'] ?></td>
                <td><?= $row['date'] ?></td>
            <?php
                        }
                        ?>
            </tr>
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
    window.location.href = "import-report.php";
})
</script>

</body>

</html>