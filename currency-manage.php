<?php
    include 'head.php';

      
    if (isset($_POST['btnSave'])) {
        $cur_name = $_POST['cur_name'];
        $curren = $_POST['currency'];
        $dis = $_POST['dis'];

        $sql = "SELECT * FROM tbcurrency WHERE cry_name = '$cur_name'";
        $result = mysqli_query($con, $sql) or die("Error in sql: $sql");
        if (mysqli_num_rows($result) > 0) {
            echo '<script type="text/javascript"> swal("ແຈ້ງເຕືອນ", "ອັດຕາແລກປ່ຽນຖືກນຳໃຊ້ແລ້ວ", "warning") </script>';
        }else{
            $sql = "INSERT INTO tbcurrency VALUES(null,'$cur_name','$curren','$dis')";
            $result = mysqli_query($con, $sql);
            $cur_name = $curren = $dis = "";
            echo '<script type="text/javascript"> swal("ແຈ້ງເຕືອນ", "ບັນທຶກຂໍ້ມູນສຳເລັດ", "success") </script>';
        }
    }


    if (isset($_POST['btnUpdate'])) {
        $cur_id = $_POST['cur_id'];
        $cur_name = $_POST['cur_name_update'];
        $curren = $_POST['currency_update'];
        $dis = $_POST['dis_update'];

            $sql = "UPDATE tbcurrency SET cry_name = '$cur_name',cry_num = '$curren', cry_disc = '$dis' WHERE cry_id = '$cur_id'";
            if (mysqli_query($con, $sql)) {
                echo '<script type="text/javascript"> swal("ແຈ້ງເຕືອນ", "ແກ້ໄຂຂໍ້ມູນສຳເລັດ", "success") </script>';
            }
        
    }
    include 'menu.php';
?>




<div class="content">
    <div class="container-fluid">
        <div class="alert alert-success alert-dismissible text-center">
            <strong>ຈັດການຂໍ້ມູນອັດຕາແລກປ່ຽນ</strong>
        </div>
        <div class="m-3">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAdd"><i
                    class="fas fa-plus-circle"></i> ເພີ່ມຂໍ້ມູນ</button>
        </div>
        <div class="table-responsive">
            <table id="example" class="table table-bordered table-hover">
                <thead class="table-success">
                    <tr>
                        <th>ລຳດັບ</th>
                        <th>ສະກຸນເງິນ</th>
                        <th>ອັດຕາແລກປ່ຽນ</th>
                        <th>ພາສາລາວ</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i=0;
                        $fetch_cur = mysqli_query($con, "SELECT * FROM tbcurrency");
                        
                        while($row = mysqli_fetch_array($fetch_cur)){
                            $i++;
                    ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td style="display:none;"><?= $row[0] ?></td>
                        <td><?= $row[1] ?></td>
                        <td style="display:none;"><?= $row[2] ?></td>
                        <td align="right"><?= number_format($row[2],2) ?></td>
                        <td><?= $row[3] ?></td>
                        <td align="center" width="200px">
                            <a href="#" data-toggle="modal" data-target="#modalUpdate"
                                class="btn btn-outline-success btn_update"><i class="fas fa-edit"></i></a>
                            |
                            <a href="#" onclick="deletedata('<?= $row[0] ?>')" data-toggle="tooltip"
                                data-placement="left" title="ລືບ" class="btn btn-outline-danger"><i
                                    class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<form action="currency-manage.php" method="post" class="needs-validation">
    <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header alert alert-primary">
                    <h5 class="modal-title" id="modalAddLabel">ເພີ່ມຂໍ້ມູນອັດຕາແລກປ່ຽນ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 mb-3">
                        <label for="cur_name">ສະກຸນເງິນ</label>
                        <input type="text" class="form-control" name="cur_name" id="cur_name" placeholder="ສະກຸນເງິນ"
                            required>
                        <div class="invalid-feedback">
                            ກະລຸນາປ້ອມຂໍ້ມູນ
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="currency">ອັດຕາແລກປ່ຽນ</label>
                        <input type="text" class="form-control" name="currency" id="currency" placeholder="ອັດຕາແລກປ່ຽນ"
                            required>
                        <div class="invalid-feedback">
                            ກະລຸນາປ້ອມຂໍ້ມູນ
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="dis">ຊື່ພາສາລາວ</label>
                        <input type="text" class="form-control" name="dis" id="dis" placeholder="ຊື່ພາສາລາວ" required>
                        <div class="invalid-feedback">
                            ກະລຸນາປ້ອມຂໍ້ມູນ
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ປິດ</button>
                    <button type="submit" name="btnSave" id="btnSave" class="btn btn-primary">ບັນທຶກ</button>
                </div>
            </div>
        </div>
    </div>
</form>

<form action="currency-manage.php" method="post" id="formUpdate" class="needs-validation">
    <div class="modal fade" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="modalUpdateLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header alert alert-success">
                    <h5 class="modal-title" id="modalUpdateLabel">ແກ້ໄຂຂໍ້ມູນອັດຕາແລກປ່ຽນ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="cur_id" id="cur_id">
                    <div class="col-md-12 mb-3">
                        <label for="cur_name_update">ສະກຸນເງິນ</label>
                        <input type="text" class="form-control" name="cur_name_update" id="cur_name_update"
                            placeholder="ສະກຸນເງິນ" required>
                        <div class="invalid-feedback">
                            ກະລຸນາປ້ອມຂໍ້ມູນ
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="currency_update">ອັດຕາແລກປ່ຽນ</label>
                        <input type="text" class="form-control" name="currency_update" id="currency_update"
                            placeholder="ອັດຕາແລກປ່ຽນ" required>
                        <div class="invalid-feedback">
                            ກະລຸນາປ້ອມຂໍ້ມູນ
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="dis_update">ຊື່ພາສາລາວ</label>
                        <input type="text" class="form-control" name="dis_update" id="dis_update"
                            placeholder="ຊື່ພາສາລາວ" required>
                        <div class="invalid-feedback">
                            ກະລຸນາປ້ອມຂໍ້ມູນ
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ປິດ</button>
                    <button type="submit" name="btnUpdate" id="btnUpdate" class="btn btn-primary">ແກ້ໄຂ</button>
                </div>
            </div>
        </div>
    </div>
</form>

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
                    url: "manage/currency-del.php",
                    method: "post",
                    data: {
                        cur_id: id
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
    console.log(id);
}

$('.btn_update').on('click', function() {
    $('#modalUpdate').modal('show');
    $tr = $(this).closest('tr');
    var data = $tr.children("td").map(function() {
        return $(this).text();
    }).get();

    console.log(data);

    $('#cur_id').val(data[1]);
    $('#cur_name_update').val(data[2]);
    $('#currency_update').val(data[3]);
    $('#dis_update').val(data[5]);
});
</script>

<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
    'use strict';
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();
</script>
</body>

</html>