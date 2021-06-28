<?php
     include 'head.php';
     include 'menu.php';
?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h5 class="text-center alert alert-success">ປະຫວັດການຂາຍ</h5>
                <a href="frmSale.php" class="btn btn-danger my-2 text-right"><i class="fas fa-backspace"></i>
                    ກັບໜ້າຂາຍ</a>
                <table class="table table-bordered table-striped table-hover" id="example">
                    <thead class="text-center table-success">
                        <tr>
                            <th>ລຳດັບ</th>
                            <th>ລະຫັດ</th>
                            <th>ລາຍການ</th>
                            <th>ຈຳນວນ</th>
                            <th>ລາຄາລວມ</th>
                            <th>ຈຳນວນເງິນທີ່ຈ່າຍ</th>
                            <th>ວັນທີຂາຍ</th>
                            <th>ຜູ້ຂາຍ</th>
                            <th>ສະແດງ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                    $sql = "SELECT slID,sl_date,s.stID,firstName,lastName,total_price,sl_pay FROM tbsale s LEFT JOIN tbstaff st ON s.stID=st.stid";
                                    $query = mysqli_query($con, $sql);
                                    $i=0;
                                    if (mysqli_num_rows($query) != 0) {
                                        # code...
                                    
                                    while ($row = mysqli_fetch_array($query)) {
                                        $i++;
                                    
                                ?>
                        <tr>
                            <td><?= $i ?>.</td>
                            <td><?= $row['slID'] ?></td>
                            <td>
                                <?php
                                        $j=0;
                                        $sum_qty=0;
                                            $book = "SELECT slNo,sd.bkID,bkName,b.price as b_price,qty,sd.price FROM sale_detail sd LEFT JOIN tbbook b ON sd.bkID=b.Bkid WHERE slID = '$row[slID]'";
                                            $fetch = mysqli_query($con, $book);
                                            while ($detail = mysqli_fetch_array($fetch)) {
                                                $j++;
                                                $sum_qty += $detail['qty'];
                                                echo "<p>ລາຍການທີ $j: $detail[bkName].<br>";
                                                echo "<span style='font-size: 14px;margin-left: 1rem;'>ລາຄາຕໍ່ຫົວ: ".number_format($detail['b_price'],2)."</span><br>";
                                                echo "<span style='font-size: 14px;margin-left: 1rem;'>ຈຳນວນ: $detail[qty].</span><br></p>";
                                            }
                                        ?>
                            </td>
                            <td><?= $sum_qty ?></td>
                            <td align="right"><?= number_format($row['total_price'],2) ?> ກີບ</td>
                            <td align="right"><?= number_format($row['sl_pay'],2) ?> ກີບ</td>
                            <td><?= $row['sl_date'] ?></td>
                            <td><?= $row['firstName'] ?></td>
                            <td>
                                <a href="#" class="btn btn-outline-info"><i class="fas fa-receipt"></i> ສະແດງໃບບິນ</a>
                            </td>
                        </tr>
                        <?php
                                }
                            }else{
                                echo '<tr>';
                                echo '<td colspan="9">ບໍ່ມີຂໍ້ມູນ</td>';
                                echo '</tr>';
                            }
                                ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php 
    include 'footer.php';
?>


</body>

</html>