<?php 
    $where = '';
    $start = '';
    $end = '';
    if (isset($_POST['search'])) {
        $start = $_POST['start'];
        $end = $_POST['end'];
        $where = empty($start) && empty($end) ? " " : " WHERE pdate >= '$start' AND pdate <= '$end'";
    }
    include 'connectdb.php';
    include 'head.php';
    include 'menu.php';
?>

<div class="container-fluid" style="margin-top: 15px">
    <div class="alert alert-success alert-dismissible" style="text-align: center">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>ລາຍງານຂໍ້ມູນການສັ່ງຊື້</strong>
    </div>

    <p class="d-flex justify-content-end">
        <a href="report/order-print.php?start=<?= $start ?>&end=<?= $end ?>" class="btn btn-info" target="_blank"><i
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
                <th>ລະຫັດການສັ່ງຊື້</th>
                <th>ລາຍການສັ່ງຊື້</th>
                <th>ຈຳນວນທັງໝົດ</th>
                <th>ຜູ້ສະໜອງ</th>
                <th>ພະນັກງານ</th>
                <th>ວັນທີສັ່ງຊື້</th>
                <th>ສະຖານະ</th>
            </tr>
        </thead>
        <tbody>
        <?php 
            $sql="SELECT pcid,pdate,p.sup_id,sup_name,p.sts_id,sts_name,FirstName,LastName FROM tbpurchase p inner JOIN tbsuppliers sp on p.sup_id=sp.sup_id inner JOIN tbl_status st on p.sts_id = st.sts_id left JOIN tbstaff s on p.stid=s.stid $where";
            $result = mysqli_query($con, $sql);
            $i=0;
            while($row = mysqli_fetch_array($result)){
                $i++;
        ?>
            <tr>
                <td><?= $i ?></td>
                <td><?= $row['pcid'] ?></td>
                <td>
                    <?php 
                        $sql1 = "SELECT pcNO,bid,bkName,qty FROM purchase_detail inner JOIN tbbook on purchase_detail.bid=tbbook.bkid WHERE pcid = '$row[pcid]'";
                        $rst = mysqli_query($con, $sql1);
                        $j = 0;
                        $cnt = 0;
                        $sum = 0;
                        $total_price = 0;
                        while($prd = mysqli_fetch_array($rst)){
                            $j++;
                            echo "ລາຍການ $j: $prd[bkName]<br/>";
                            $cnt += $prd['qty'];
                        }
                    ?>
                </td>
                <td class="text-center"><?= $cnt ?></td>
                <td><?= $row['sup_name'] ?></td>
                <td><?= $row['FirstName'] ?> <?= $row['LastName'] ?></td>
                <td><?= $row['pdate'] ?></td>
                <td><?= $row['sts_name'] ?></td>
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
    window.location.href = "order-report.php";
})
</script>

</body>

</html>