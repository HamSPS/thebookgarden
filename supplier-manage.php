<?php
    include 'head.php';
    include 'menu.php';
?>
<div class="content">
<div class="container-fluid" style="margin-top: 15px">
            <div class="alert alert-success alert-dismissible" style="text-align: center">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>ຈັດການຂໍ້ມູນຜູ້ສະໜອງ</strong>
            </div>
            <p class="d-flex justify-content-end">
                <a href="supplier-add.php" class="btn btn-info"><i class="fas fa-plus-circle"></i> ເພີ່ມຂໍ້ມູນ</a>
            </p>

            <div class="table-responsive">
            <table id="example" class="table table-hover table-bordered" style="width:100%">
                    <thead style="background-color: beige; text-align: center">
                        <tr>
                            <th>ລະຫັດ</th>
                            <th>ຊື່ຜູ້ສະໜອງ</th>
                            <th>ຜູ້ຕິດຕໍ່</th>
                            <th>ເບີໂທ</th>
                            <th>ອີເມວ</th>
                            <th>ທີ່ຢູ່</th>
                            <th>ອ໋ອບຊັນ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM tbsuppliers";
                        $result = mysqli_query($con, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td width="10%" style="text-align: center"><?= $row['sup_id'] ?></td>
                                <td width="25%"><?= $row['sup_Name'] ?></td>
                                <td style="text-align: center"><?= $row['contactName'] ?></td>
                                <td width="10%"><?= $row['sup_tel'] ?></td>
                                <td><?= $row['sup_email'] ?></td>
                                <td><?= $row['sup_address'] ?></td>
                                <td style="width: 80px;white-space: nowrap; text-align: center">
                                    <a href="supplier-edit.php?sup_id=<?= $row['sup_id'] ?>" data-toggle="tooltip" data-placement="bottom" title="ແກ້ໄຂ"><i class="fas fa-edit" style="color: green"></i> ແກ້ໄຂ</a> |
                                    <a href="#" onclick="deletedata(<?php echo "'" . $row['sup_id'] . "'"; ?>)" data-toggle="tooltip" data-placement="left" title="ລືບ"><i class="fas fa-trash-alt" style="color: red"></i> ລົບ</a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>

              
       <!-- The Modal -->
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
            
                <button type="button" class="btn btn-danger" data-dismiss="modal">ປິດ</button>
            </div>

        </div>
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

    /*ສະແດງລາຍລະອຽດ ກົດທີ່ class="view_data"*/
    function viewdata(id) {
        $.ajax({
            url: "manage/cus-view.php",
            method: "post",
            data: {cusID: id},
            success: function(data) {

                $('#show_detail').html(data);
                $('#myModal').modal("show");
            }
        });
    }
    /*ສິ້ນສຸດສະແດງລາຍລະອຽດ*/

    //ສ້າງຟັງຊັນແຈ້ງເຕືອນລືບຂໍ້ມູນ
    function deletedata(id) {
        swal({
            title: "ເຈົ້າຕ້ອງການລືບແທ້ ຫຼື ບໍ?",
            text: "ຂໍ້ມູນລະຫັດ " + id + ", ເມື່ອລືບຈະບໍ່ສາມາດກູ້ຂໍ້ມູນຄືນໄດ້!",
            icon: "warning",
            buttons: true,
            dangerMode: true
        })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "manage/supplier-del.php",
                            method: "post",
                            data: {sup_id: id},
                            success: function(data) {
                                swal("ຂໍ້ມູນຖືກລືບສໍາເລັດແລ້ວ!", {
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