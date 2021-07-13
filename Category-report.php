<?php 
    
    include 'head.php';
    include 'menu.php';
?>

<div class="container-fluid" style="margin-top: 15px">
    <div class="alert alert-success alert-dismissible" style="text-align: center">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>ລາຍງານຂໍ້ມູນປະເພດໜັງສື</strong>
    </div>

    <p class="d-flex justify-content-end">
        <a href="report/category-print.php" class="btn btn-info" target="_blank"><i class="fas fa-print"></i>
            ພີມລາຍງານ</a>
    </p>

    <div class="table-wrapper-scroll-y my-custom-scrollbar">
        <table class="table table-hover table-bordered" style="width:100%">
            <thead class="bg-dark text-white" style="text-align: center">
                <tr>
                    <th>ລະຫັດປະເພດ</th>
                    <th>ຊື່ປະເພດໜັງສື</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                        $sql = "SELECT * FROM tbcategory";
                        $result = mysqli_query($con, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            
                            ?>
                <tr>
                    <td style="text-align: center"><?= $row['catID'] ?></td>
                    <td><?= $row['catName'] ?></td>
                    <td class="text-center" style="width: 250px"><a
                            href="report/cat-book-print.php?cat=<?= $row['catID'] ?>" class="btn btn-outline-success"
                            target="_blank"><i class="fas fa-print"></i> ພີມຕາມປະເພດ</a>
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
<?php 
    include 'footer.php';
?>


</body>

</html>