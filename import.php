<?php
    include 'head.php';

    if (isset($_POST['search'])) {
        $start = $_POST['start'];
        $end = $_POST['end'];
    }

    @$act = $_GET['act'];
    if ($act == 'cancel') {
        unset($_SESSION['import']);
    }
    include 'menu.php';
?>

<div class="content">
    <div class="container-fluid">
        <div class="alert alert-primary alert-dismissible" style="text-align: center">
            <!-- <button type="button" class="close" data-dismiss="alert">&times;</button> -->
            <strong>ການນຳເຂົ້າສິນຄ້າ</strong>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h4>ການນຳເຂົ້າ</h4>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                            aria-controls="home" aria-selected="true">ລາຍການສັ່ງຊື້</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                            aria-controls="profile" aria-selected="false">ປະຫວັດການນຳເຂົ້າ</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered table-hover display" id="example">
                                <thead class="table-success text-center">
                                    <tr>
                                        <th>ລຳດັບ</th>
                                        <th>ລະຫັດການສັ່ງຊື້</th>
                                        <th>ລາຍການ</th>
                                        <th>ລາຄາລວມ</th>
                                        <th>ວັນທີສັ່ງຊື້</th>
                                        <th>ຜູ້ສະໜອງ</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                            $sql = "SELECT pcid,pdate,pc.stid,FirstName,LastName,sp.sup_id,sup_name FROM tbpurchase pc INNER JOIN tbstaff st ON pc.stid = st.stid INNER JOIN tbsuppliers sp ON pc.sup_id=sp.sup_id WHERE sts_id != 4";
                            $i=0;
                            $result = mysqli_query($con, $sql);
                            while ($row = mysqli_fetch_array($result)){
                                $i++;
                            ?>
                                    <tr>
                                        <td align="center"><?= $i ?>.</td>
                                        <td><?= $row['pcid'] ?></td>
                                        <td>
                                            <?php
                                        $sql = "SELECT bid,bkName,qty,price,price * qty as total FROM purchase_detail pd inner JOIN tbbook bk on pd.bid=bk.Bkid WHERE pcid = '$row[pcid]'";
                                        $query = mysqli_query($con, $sql);
                                        $j=1;
                                        $sum = 0;
                                        while ($detail = mysqli_fetch_array($query)) {
                                            $sum += $detail['total'];
                                            echo "<span class='text-danger'>ລາຍການທີ່ ".$j++."</span>: $detail[bkName]<br>";
                                            echo "&nbsp; &nbsp; &nbsp; ຈຳນວນ: $detail[qty] &nbsp; | ລາຄາ: ".number_format($detail['price'],2)."| ລວມ: ".number_format($detail['total'],2)."<br>";
                                        }
                                    ?>
                                        </td>
                                        <td align="right"><?= number_format($sum,2) ?> ກີບ</td>
                                        <td><?= $row['pdate'] ?></td>
                                        <td><?= $row['sup_name'] ?></td>
                                        <td>
                                            <a href="import-confirm.php?pcid=<?= $row['pcid'] ?>&act=add"
                                                class="btn btn-outline-info"><i class="fa fa-download"></i> ນຳເຂົ້າ</a>
                                        </td>
                                    </tr>
                                    <?php
                            }
                            ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="table-responsive">
                            <form action="" method="post" id="frmSearch">
                                <div class="col-md-5 d-flex my-3">
                                    <input type="date" name="start" id="start" value="<?= @$start ?>"
                                        class="form-control">
                                    <input type="date" name="end" id="end" value="<?= @$end ?>" class="form-control">
                                    <button type="submit" name="search" class="btn btn-success "><i
                                            class="fas fa-search"></i></button>
                                </div>
                            </form>
                            <table class="table table-bordered table-hover display" id="history" style="width: 100%;">
                                <thead class="table-success text-center">
                                    <tr class="fix_width">
                                        <th>ລຳດັບ</th>
                                        <th>ລະຫັດ</th>
                                        <th>ວັນທີນຳເຂົ້າ</th>
                                        <th>ນຳເຂົ້າໂດຍ</th>
                                        <th>ລາຍການນຳເຂົ້າ</th>
                                        <th>ລາຄາລວມ</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "";
                                    if (!empty($start) && !empty($end)) {
                                        $sql = "SELECT impid,imp_date,st.stid,FirstName,LastName FROM tbimport im INNER JOIN tbstaff st ON im.stid = st.stid WHERE imp_date BETWEEN '$start' AND '$end'";
                                    }else{
                                        $sql = "SELECT impid,imp_date,st.stid,FirstName,LastName FROM tbimport im INNER JOIN tbstaff st ON im.stid = st.stid";
                                    }
                                    $i=0;
                                    $result = mysqli_query($con, $sql);
                                    while ($row = mysqli_fetch_array($result)) {
                                       $i++;
                                    
                                    ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= $row['impid'] ?></td>
                                        <td><?= $row['imp_date'] ?></td>
                                        <td><?= $row['FirstName'] .' '. $row['LastName'] ?></td>
                                        <td>
                                            <?php
                                            $sql = "SELECT impNO,bid,bkName,qty,imd.price FROM import_detail imd INNER JOIN tbbook bk ON imd.bid=bk.Bkid WHERE impid = '$row[impid]'";
                                            $query = mysqli_query($con, $sql);
                                            $j = 0;
                                            $sum = 0;
                                            while($detail = mysqli_fetch_array($query)){
                                                $j++;
                                                $sum += $detail['price'];
                                                echo 'ລາຍການທີ '.$j.': '.$detail['bkName'].'<br>';
                                                echo '&nbsp; &nbsp; ຈຳນວນ: '.$detail['qty'].', ລາຄາ: '.number_format($detail['price'],2).' ກີບ<br>';
                                            }
                                        ?>
                                        </td>
                                        <td align="right"><?= number_format($sum, 2) ?> ກີບ</td>
                                        <td align="center">
                                            <a href="report/import-print.php?impid=<?= $row['impid'] ?>"
                                                class="btn btn-outline-info" target="_black"><i class="fa fa-eye"></i>
                                                ສະແດງ</a>
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    include 'footer.php';
?>
<script>
$('#myTab a').on('click', function(e) {
    e.preventDefault()
    $(this).tab('show')
})
// store the currently selected tab in the hash value
$("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
    var id = $(e.target).attr("href").substr(1);
    window.location.hash = id;
});

// on load of the page: switch to the currently selected tab
var hash = window.location.hash;
$('#myTab a[href="' + hash + '"]').tab('show');
</script>
</body>

</html>