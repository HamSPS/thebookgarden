<?php 
    include 'connectdb.php';
    include 'head.php';
    include 'menu.php';
?>

<div class="container-fluid" style="margin-top: 15px">
    <div class="alert alert-success alert-dismissible" style="text-align: center">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>ລາຍງານຂໍ້ມູນລູກຄ້າ</strong>
    </div>

    <p class="d-flex justify-content-end">
        <a href="report/cus-report-print.php" class="btn btn-info" target="_blank"><i class="fas fa-print"></i>
            ພີມລາຍງານ</a>
    </p>

    <div class="table-wrapper-scroll-y my-custom-scrollbar">
        <table class="table table-hover table-bordered" style="width:100%">
            <thead class="bg-dark text-white" style="text-align: center">
                <tr>
                    <th>ລະຫັດ</th>
                    <th>ຊື່ ແລະ ນາມສະກຸນ</th>
                    <th>ເພດ</th>
                    <th>ວັນເດືອນປີເກີດ</th>
                    <th>ອາຍຸ</th>
                    <th>ເບີໂທ</th>
                    <th>ອີເມວ</th>
                    <th>ພິມບັດສະມາຊິກ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                        $sql = "SELECT cusID, cusName,gender,dateOfBirth,year(curdate())-year(dateOfBirth) AS age,address,img,tel,email FROM tbCustomer";
                        $result = mysqli_query($con, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            
                            ?>
                <tr>
                    <td style="text-align: center"><?= $row['cusID'] ?></td>
                    <td><?= $row['cusName'] ?></td>
                    <td style="text-align: center"><?= $row['gender'] ?></td>
                    <td><?= $row['dateOfBirth'] ?></td>
                    <td style="text-align: right"><?= $row['age'] ?></td>
                    <td><?= $row['tel'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td style="text-align: center;"><a href="#" onclick="viewcard()" class="btn btn-success"
                            data-toggle="tooltip" data-placement="bottom" title="ແກ້ໄຂ"><i class="fas fa-print"></i>
                            ສະແດງ</a></td>
                </tr>
                <?php
                        }
                        ?>
            </tbody>
        </table>
    </div>
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
<script>
$(document).ready(function() {
    $('#example').DataTable();
    $('[data-toggle="tooltip"]').tooltip();
});

function viewcard(id) {
    $.ajax({
        url: "report/cus-membership.php",
        method: "post",
        data: {
            cusID: id
        },
        success: function(data) {

            $('#show_detail').html(data);
            $('#myModal').modal("show");
        }
    });
}
</script>


</body>

</html>