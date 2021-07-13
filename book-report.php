<?php 
    $cat = '';
    $where = '';

    if (isset($_GET['category'])) {
        $cat = $_GET['category'];
        $where = empty($cat) ? " " : "WHERE b.catID = '$cat'";
    }
    include 'head.php';
    include 'menu.php';
?>

<div class="container-fluid" style="margin-top: 15px">
    <div class="alert alert-success alert-dismissible" style="text-align: center">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>ລາຍງານຂໍ້ມູນໜັງສື</strong>
    </div>
    <form action="" method="get">
        <div class="row">
            <div class="col-md-3 offset-md-2" style="text-align: right">
                <label id="department">ເລືອກພີມລາຍງານຕາມປະເພດ</label>
            </div>
            <div class="col-md-4">
                <select class="form-control" id="category" name="category" onchange="form.submit()">
                    <option value="">----ເລືອກປະເພດ----</option>
                    <?php
                            $sql = "SELECT * FROM tbCategory";
                            $result = mysqli_query($con, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                    <option value="<?= $row['catID'] ?>" <?php if ($row['catID'] == @$department) echo "selected"; ?>>
                        <?= $row['catName'] ?></option>
                    <?php
                            }
                            ?>

                </select>
            </div>
            <button type="submit" onclick="window.location: book-report.php?" class="btn btn-primary"><i
                    class="fas fa-redo-alt"></i></button> &nbsp; &nbsp;
            <a href="report/book-print.php?cat=<?= $cat ?>" class="btn btn-info" target="_blank"><i
                    class="fas fa-print"></i>
                ພີມລາຍງານ</a>
        </div>
    </form>

    <p class="d-flex justify-content-end">

    </p>


    <div class="table-wrapper-scroll-y my-custom-scrollbar">
        <table class="table table-hover table-bordered" style="width:100%">
            <thead class="bg-dark text-white" style="text-align: center">
                <tr>
                    <th>ລະຫັດ</th>
                    <th>ຊື່ໜັງສື</th>
                    <th>ລາຄາ</th>
                    <th>ສະຕ໋ອກ</th>
                    <th>ຜູ້ຂຽນ</th>
                    <th>ລາຍລະອຽດ</th>
                    <th>ປະເພດ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                
                    $sql = "SELECT bkid,BkName,price,stock,author,detail,b.catID,catName FROM tbbook b left JOIN tbcategory c ON b.catID=c.catID $where ORDER BY bkid ASC";
                    $result = mysqli_query($con, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                            
                ?>
                <tr>
                    <td style="text-align: center"><?= $row['bkid'] ?></td>
                    <td><?= $row['BkName'] ?></td>
                    <td class="text-right"><?= number_format($row['price'],2) ?> ກີບ</td>
                    <td class="text-center"><?= $row['stock'] ?></td>
                    <td><?= $row['author'] ?></td>
                    <td><?= $row['detail'] ?></td>
                    <td><?= $row['catName'] ?></td>
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