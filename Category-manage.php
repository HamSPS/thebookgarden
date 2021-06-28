<?php
    include 'head.php';

    if (isset($_POST['btnAdd'])) {
        $catID = $_POST['catID'];
        $catName = $_POST['catName'];

        $sql = "SELECT catID FROM tbCategory WHERE catID = '$catID'";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result) > 0) {
            echo '<script type="text/javascript"> swal("ແຈ້ງເຕືອນ", "ລະຫັດຖືກນໍາໃຊ້ແລ້ວ", "warning") </script>';
        } else {

            $sql = "INSERT INTO tbCategory VALUES('$catID', '$catName')";
            $result = mysqli_query($con, $sql);
            if ($result) {
                echo '<script type="text/javascript"> swal("ສໍາເລັດ", "ຂໍ້ມູນຖືກບັນທຶກລົງຖານຂໍ້ມູນແລ້ວ", "success") </script>';
                $catID = $catName = "";
                header("refresh:2; url=category-manage.php");
            } else {
                echo mysqli_error($con);
            }
        }
    }
    if (isset($_POST['btnUpdate'])) {
        $catID = $_POST['catID_update'];
        $catName = $_POST['catName_update'];

        if (empty($catName)) {
            echo '<script type="text/javascript"> swal("ແຈ້ງເຕືອນ", "ກະລຸນາປ້ອນຂໍ້ມູນໃຫ້ຖືກຕ້ອງ", "warning") </script>';
        }else{
            $sql = "UPDATE tbcategory set catName = '$catName' WHERE catID = '$catID'";
            if (mysqli_query($con, $sql)) {
            echo '<script type="text/javascript"> swal("ແຈ້ງເຕືອນ", "ປັງປຸງຂໍ້ມູນສຳເລັດ", "success") </script>';
                header("refresh:2; url=category-manage.php");
            }else{
                echo mysqli_error($con);
            }
        }
    }
    include 'menu.php';
?>
<div class="content">
    <div class="container-fluid" style="margin-top: 15px">
        <div class="alert alert-success alert-dismissible" style="text-align: center">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>ຈັດການຂໍ້ມູນປະເພດໜັງສື</strong>
        </div>
        <p class="d-flex justify-content-end">
            <a href="Cat-add-form.php" class="btn btn-info" data-toggle="modal" data-target="#modalInsert"><i
                    class="fas fa-plus-circle"></i> ເພີ່ມຂໍ້ມູນ</a>
        </p>

        <div class="table-responsive">
            <table id="example" class="table table-hover table-bordered" style="width:100%">
                <thead style="background-color: beige; text-align: center">
                    <tr>
                        <th>ລຳດັບ</th>
                        <th>ລະຫັດປະເພດ</th>
                        <th>ຊື່ປະເພດ</th>
                        <th>ທຳງານ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT * FROM tbCategory";
                        $result = mysqli_query($con, $sql);
                        $i=0;
                        while ($row = mysqli_fetch_assoc($result)) {
                            $i++;
                            ?>
                    <tr>
                        <td width="75px"><?= $i ?>.</td>
                        <td style="text-align: center"><?= $row['catID'] ?></td>
                        <td><?= $row['catName'] ?></td>
                        <td style="width: 80px;white-space: nowrap; text-align: center">
                            <a href="#" class="btn_update" data-toggle="modal" title="ແກ້ໄຂ"
                                data-target="#modalUpdate"><i class="fas fa-edit" style="color: green"></i></a> |
                            <a href="#" onclick="deletedata(<?php echo "'" . $row['catID'] . "'"; ?>)"
                                data-toggle="tooltip" data-placement="left" title="ລືບ"><i class="fas fa-trash-alt"
                                    style="color: red"></i> ລົບ</a>
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

    <div class="modal fade" id="Add">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">ເພີ່ມຂໍ້ມູນປະເພດໜັງສື</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body" id="add-form">

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">

                    <button type="button" class="btn btn-danger" data-dismiss="modal">ປິດ</button>
                </div>

            </div>
        </div>
    </div>


    <form action="" method="post">
        <div class="modal fade" id="modalInsert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header alert alert-primary">
                        <h5 class="modal-title" id="exampleModalLabel">ເພີ່ມຂໍ້ມູນປະເພດໜັງສື</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="catID">ລະຫັດປະເພດໜັງສື</label>
                                <input class="form-control" type="text" id="catID" name="catID" value="<?= @$catID ?>"
                                    placeholder="ກະລຸນາປ້ອນລະຫັດ" required="">
                            </div>
                            <div class="col-md-12">
                                <label for="catName">ຊື່ປະເພດ</label>
                                <input class="form-control" type="text" id="catName" name="catName"
                                    value="<?= @$catName ?>" placeholder="ກະລຸນາປ້ອນຊື່ປະເພດໜັງສື" required="">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">ປິດ</button>
                        <button type="submit" name="btnAdd" class="btn btn-outline-primary">ເພີ່ມ</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form action="" method="post">
        <div class="modal fade" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header alert alert-success">
                        <h5 class="modal-title" id="exampleModalLabel">ແກ້ໄຂຂໍ້ມູນປະເພດໜັງສື</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="catID_update">ລະຫັດປະເພດໜັງສື</label>
                                <input class="form-control" type="text" id="catID_update" name="catID_update"
                                    value="<?= @$catID ?>" placeholder="ກະລຸນາປ້ອນລະຫັດ" disabled>
                            </div>
                            <div class="col-md-12">
                                <label for="catName_update">ຊື່ປະເພດ</label>
                                <input class="form-control" type="text" id="catName_update" name="catName_update"
                                    value="<?= @$catName ?>" placeholder="ກະລຸນາປ້ອນຊື່ປະເພດໜັງສື" required="">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">ປິດ</button>
                        <button type="submit" name="btnUpdate" class="btn btn-outline-success">ແກ້ໄຂ</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php 
    include 'footer.php';
    // require 'manage/cat-add-form.php';
?>

    <script>
    $(document).ready(function() {
        $('#example').DataTable();
        $('[data-toggle="tooltip"]').tooltip();
    });

    //ເພີ່ມຂໍ້ມູນດ້ວຍ ajax
    //    $('.addFrm').on('submit', function(e) {
    //         e.preventDefault()
    //         $.ajax({
    //             url: 'manage/Cat-add-form.php',
    //             type: 'POST',
    //             data: {catName: $('#catName').val()},
    //             success: function(msg) {
    //                 if (msg == 'success') {
    //                     swal('success', 'insert data success', 'success')
    //                 }  else {
    //                     swal('warning', 'Please input', 'warning')
    //                 }
    //             }
    //         })

    //     })



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
                        url: "manage/cat-del.php",
                        method: "post",
                        data: {
                            catID: id
                        },
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


    $('.btn_update').on('click', function() {
        $('#modalUpdate').modal('show');
        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();

        console.log(data);

        $('#catID_update').val(data[1]);
        $('#catName_update').val(data[2]);
    });
    </script>

    </body>

    </html>