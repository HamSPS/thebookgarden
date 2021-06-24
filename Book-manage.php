<?php
    include 'head.php';
    include 'menu.php';
?>
<div class="content">
<div class="container-fluid" style="margin-top: 15px">
            <div class="alert alert-success alert-dismissible" style="text-align: center">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>ຈັດການຂໍ້ມູນປຶ້ມ</strong>
            </div>
            <p class="d-flex justify-content-end">
                <a href="Book-add.php" class="btn btn-info"><i class="fas fa-plus-circle"></i> ເພີ່ມຂໍ້ມູນ</a>
            </p>

            <div class="table-responsive">
            <table id="example" class="table table-hover table-bordered" style="width:100%">
                    <thead style="background-color: beige; text-align: center">
                        <tr>
                            <th>ລະຫັດ</th>
                            <th>ຊື່ໜັງສື</th>
                            <th>ລາຄາ</th>
                            <th>ຈຳນວນ</th>
                            <th>ຜູ້ຂຽນ</th>
                            <th>ປະເພດ</th>
                            <th>ຮູບ</th>
                            <th>ອ໋ອບຊັນ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM vw_book";
                        $result = mysqli_query($con, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td style="text-align: center"><?= $row['Bkid']; ?></td>
                                <td><?= $row['BkName']; ?></td>
                                <td><?= number_format($row['price']); ?></td>
                                <td style="text-align: center"><?= $row['stock']; ?></td>
                                <td><?= $row['author']; ?></td>
                                <td><?= $row['catName']; ?></td>
                                <td><img src="<?= $row['img']; ?>" width="100px" alt="ຮູບໜັງສື"></td>
                                <td style="width: 80px;white-space: nowrap; text-align: center">
                                    <a href="book-edit.php?Bkid=<?= $row['Bkid'] ?>" data-toggle="tooltip" data-placement="bottom" title="ແກ້ໄຂ"><i class="fas fa-edit" style="color: green"></i> ແກ້ໄຂ</a> | 
                                    <a href="#" onclick="deletedata(<?php echo "'" . $row['Bkid'] . "'"; ?>)" data-toggle="tooltip" data-placement="left" title="ລືບ"><i class="fas fa-trash-alt" style="color: red"></i> ລົບ</a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
<?php 
    include 'footer.php';
?>
 
<script>
    $(document).ready(function() {
        $('#example').DataTable();
        $('[data-toggle="tooltip"]').tooltip();
    });

    //ສ້າງຟັງຊັນແຈ້ງເຕືອນລືບຂໍ້ມູນ
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
                            url: "manage/book-del.php",
                            method: "post",
                            data: {Bkid: id},
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