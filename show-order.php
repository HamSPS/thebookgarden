<?php
    include 'head.php';
    include 'menu.php';
?>

<div class="content">
    <div class="container-fluid">
        <div class="alert alert-primary alert-dismissible" style="text-align: center">
            <!-- <button type="button" class="close" data-dismiss="alert">&times;</button> -->
            <strong>ສະແດງລາຍການສັ່ງຊື້</strong>
        </div>
        <p><a href="order-add.php" class="btn btn-danger"><i class="fa fa-arrow-circle-left"></i> ກັບຄື</a></p>
        <div class="table-responsive">
            <table class="display table table-hover table-bordered" id="example">
                <thead class="table-success text-center">
                    <tr>
                        <th>ລຳດັບ</th>
                        <th>ລະຫັດການສັ່ງຊື້</th>
                        <th>ລາຍການສັ່ງຊື້</th>
                        <th>ຈຳນວນທັງໝົດ</th>
                        <th>ສັ່ງຊື້ນຳ</th>
                        <th>ວັນທີສັ່ງຊື້</th>
                        <th>ສະຖານະ</th>
                        <th>ສະແດງ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $sql="SELECT pcid,pdate,tbpurchase.sup_id,sup_name,tbpurchase.sts_id,sts_name FROM tbpurchase inner JOIN tbsuppliers on tbpurchase.sup_id=tbsuppliers.sup_id inner JOIN tbl_status on tbpurchase.sts_id = tbl_status.sts_id WHERE tbpurchase.sts_id != 4";
                        $result = mysqli_query($con, $sql);
                        $i=0;
                        while(@$row = mysqli_fetch_array($result)){
                            $i++;
                    ?>
                    <tr>
                        <td width="20px"><?=$i?></td>
                        <td><?= $row['pcid'] ?></td>
                        <td>
                            <?php 
                                $sql1 = "SELECT pcNO,bid,bkName,qty FROM purchase_detail inner JOIN tbbook on purchase_detail.bid=tbbook.bkid WHERE pcid = '$row[pcid]'";
                                $rst = mysqli_query($con, $sql1);
                                $i = 0;
                                $cnt = 0;
                                $sum = 0;
                                $total_price = 0;
                                while($prd = mysqli_fetch_array($rst)){
                                    $i++;
                                    echo "ລາຍການ $i: $prd[bkName]<br/>";
                                    $cnt += $prd['qty'];
                                }
                            ?>
                        </td>
                        <td class="text-center"><?= $cnt ?></td>
                        <td><?= $row['sup_name'] ?></td>
                        <td><?= $row['pdate'] ?></td>
                        <td><?= $row['sts_name'] ?></td>
                        <td>
                            <a href="report/purchase-print.php?pcid=<?= $row['pcid'] ?>" class="btn btn-outline-info"
                                target="_black"><i class="fas fa-print"></i> ພິມໃບບິນ</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
    include 'footer.php';
?>