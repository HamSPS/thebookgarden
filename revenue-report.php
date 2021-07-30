<?php 
    
    include 'connectdb.php';
    include 'head.php';
    include 'menu.php';
?>

<?php
        $get = "";
        $sql = "";
        if (isset($_POST['search'])) {
            $get = $_POST['date'];
            if ($get == "date") {
                $sql = "SELECT DATE_FORMAT(sl_date, '%d/%M/%Y') AS sdate, sum(total_price) as sl_sum,sum(qty) as qty FROM tbsale s left JOIN sale_detail sd ON s.slID=sd.slID GROUP BY DATE_FORMAT(sl_date, '%Y-%m-%d') LIMIT 30";   
            }
            if ($get == "month") {
                $sql = "SELECT DATE_FORMAT(sl_date, '%M/%Y') AS sdate, sum(total_price) as sl_sum,sum(qty) as qty FROM tbsale s left JOIN sale_detail sd ON s.slID=sd.slID GROUP BY DATE_FORMAT(sl_date, '%Y-%m') LIMIT 30";
            }
            if ($get == "year") {
                $sql = "SELECT DATE_FORMAT(sl_date, '%Y') AS sdate, sum(total_price) as sl_sum,sum(qty) as qty FROM tbsale s left JOIN sale_detail sd ON s.slID=sd.slID GROUP BY DATE_FORMAT(sl_date, '%Y') LIMIT 30";
            }
        }
    ?>
<div class="container-fluid" style="margin-top: 15px">
    <div class="alert alert-success alert-dismissible" style="text-align: center">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>ລາຍງານຂໍ້ມູນລາຍຮັບ</strong>
    </div>

    <!-- <p class="d-flex justify-content-end">
        <a href="report/sale-print.php?start=<?= $start ?>&end=<?= $end ?>" class="btn btn-info" target="_blank"><i
                class="fas fa-print"></i>
            ພີມລາຍງານ</a>
    </p> -->

    <form action="" method="post">
        <div class="row">
            <div class="col-md-3 offset-md-2" style="text-align: right">
                <label id="department">ເລືອກພີມລາຍງານຕາມປະເພດ</label>
            </div>
            <div class="col-md-4">
                <select class="form-control" id="date" name="date">
                    <option value="">----ເລືອກປະເພດ----</option>
                    <option value="date">ພີມລາຍງານຕາມວັນ</option>
                    <option value="month">ພີມລາຍງານຕາມເດືອນ</option>
                    <option value="year">ພີມລາຍງານຕາມປີ</option>
                </select>
            </div>
            <button type="submit" name="search" class="btn btn-primary">ຄົ້ນຫາ</button>
            &nbsp; &nbsp;
            <?php
                if ($get == "") {
                    echo "";
                }else{
                    echo '<a href="report/revenue-print.php?date='. $get .'" class="btn btn-info" target="_blank"><i class="fas fa-print"></i> ພີມລາຍງານ</a>';
                }
            ?>
        </div>
    </form>



    <?php
    if (!empty($sql)) {
    ?>
    <table class="table table-hover table-bordered display" style="width:100%">
        <thead class="bg-dark text-white" style="text-align: center">
            <tr>
                <th>ລຳດັບ</th>
                <th>ວັນທີ</th>
                <th>ລາຍຮັບ</th>
                <th>ຈຳນວນ</th>
            </tr>
        </thead>
        <tbody>
            <?php
            
                
                $result = mysqli_query($con, $sql) or die ("Error in query: $sql". mysqli_error($sql));
                $total = 0;
                $i = 0;
                $sum = 0;
                while ($row = mysqli_fetch_array($result)) {
                    $total += $row[1] ;
                    $sum += $row[2];
                    $i++;
                    
                    ?>
            <tr>
                <td><?= $i ?>.</td>
                <td><?= $row['sdate'] ?></td>
                <td class="text-right"><?= number_format($row['sl_sum'],2) ?>
                    ກີບ</td>
                    <td align="center"><?= $row['qty'] ?></td>
            </tr>

            <?php 
        }
        ?>
            <tr class="table-warning">
                <td colspan="2" align="right">ລວມ</td>
                <td><?= number_format($total, 2) ?></td>
                <td align="center"><?= $sum ?></td>
            </tr>
        </tbody>
    </table>
    <?php
    }else{
        echo "<p class='text-center mt-5 text-red'>ກະລຸນາເລືອກລາຍງານ</p>";
        echo '<hr>';
    }
    ?>
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

</body>

</html>