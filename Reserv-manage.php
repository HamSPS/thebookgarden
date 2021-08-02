<?php
    include 'head.php';
    include 'menu.php';
?>
<div class="content">
    <div class="container-fluid">
        <div class="alert alert-primary alert-dismissible" style="text-align: center">
            <!-- <button type="button" class="close" data-dismiss="alert">&times;</button> -->
            <strong>ສະແດງລາຍການຈອງໜັງສື</strong>
        </div>
        <p><a href="Reserv_add.php" class="btn btn-info"><i class="fas fa-plus-circle"></i> ເພີ່ນລາຍການຈອງ</a></p>
        <div class="table-responsive">
            <table class="display table table-hover table-border" id="example">
                <thead class="table-success">
                    <tr>
                        <th>ລະຫັດການຈອງ</th>
                        <th>ລາຍການຈອງ</th>
                        <th>ຈຳນວນ</th>
                        <th>ລາຄາ</th>
                        <th>ຈອງໂດຍ</th>
                        <th>ວັນທີຈອງ</th>
                        <th>ສະຖານະການຈອງ</th>
                        <th>ສະແດງ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $sql="SELECT rsID,revDate,stid,tbreserv.cusid,cusName,address,tel,tbreserv.sts_id,sts_name FROM tbreserv INNER JOIN tbcustomer on tbreserv.cusid=tbcustomer.cusID inner JOIN tbl_status on tbreserv.sts_id = tbl_status.sts_id WHERE tbreserv.sts_ID != 4";
                        $result = mysqli_query($con, $sql);
                        while(@$row = mysqli_fetch_array($result)){
                    ?>
                    <tr>
                        <td><?= $row['rsID'] ?></td>
                        <td>
                            <?php 
                                $sql1 = "SELECT rsNO,bid,bkName,tbbook.price as b_price,qty FROM reserv_detail inner JOIN tbbook on reserv_detail.bid=tbbook.bkid WHERE rsID = '$row[rsID]'";
                                $rst = mysqli_query($con, $sql1);
                                $i = 0;
                                $cnt = 0;
                                $sum = 0;
                                $total_price = 0;
                                while($prd = mysqli_fetch_array($rst)){
                                    $i++;
                                    echo "ລາຍການ $i: $prd[bkName]<br/>";
                                    $cnt += $prd['qty'];
                                    $sum = $prd['qty']*$prd['b_price'];
                                    $total_price += $sum;
                                }
                            ?>
                        </td>
                        <td><?= $cnt ?></td>
                        <td><?= number_format($total_price, 2) ?> ກີບ</td>
                        <td>
                            <?php 
                                echo 'ຊື່ລູກຄ້າ: '.$row['cusName'].'<br/>';
                                echo 'ທີ່ຢູ່: '.$row['address'].'<br/>';
                                echo 'ເບີໂທ:​ '.$row['tel'].'<br/>';
                            ?>
                        </td>
                        <td><?= $row['revDate'] ?></td>
                        <td><?= $row['sts_name'] ?></td>
                        <td>
                            <a href="bill-rev.php?revID=<?= $row['rsID'] ?>" class="btn btn-outline-info fas fa-shopping-cart"></a>
                            |
                            <a href="report/rev-bill-print.php?revID=<?= $row['rsID'] ?>" class="btn btn-outline-success fa fa-print" target="_black"></a>
                            |
                            <a href="#" onclick="deletedata(<?= $row['rsID'] ?>)" class="btn btn-outline-danger fas fa-trash-alt" data-toggle="tooltip" data-placement="left" title="ລືບ"></a>
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

<script>
    function deletedata(id) {
        swal({
            title: "ເຈົ້າຕ້ອງການລືບແທ້ ຫຼື ບໍ?",
            text: "ຂໍ້ມູນລຫັດ " + id + ", ເມື່ອລືບຈະບໍ່ສາມາດກູ້ຂໍ້ມູນຄືນໄດ້!",
            icon: "warning",
            buttons: true,
            dangerMode: true
        })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "manage/Reserv_del.php",
                            method: "post",
                            data: {rsid: id},
                            success: function(data) {
                                swal("ຂໍ້ມູນຖືກລົບສໍາເລັດແລ້ວ!", {
                                    icon: "success"
                                });
                                setTimeout(function() {
                                    location.reload();
                                }, 2000); //2000 = 2ວິນາທີ
                            }
                        });

                    }
                });
    }
</script>
</body>

</html>