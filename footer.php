</div>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
    </div>
</aside>
<!-- /.control-sidebar -->
<!-- Main Footer -->
<footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
        Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2021</strong> ລະບົບຈັດການຂໍ້ມູນຮ້ານສວນໜັງສື
</footer>
</div>
<!-- ./wrapper -->


<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!-- <script src="js/bootstrap.bundle.min.js"></script> -->
<script src="js/adminlte.min.js"></script>
<!-- <script src="js/dataTables.bootstrap4.min.js"></script> -->
<script src="js/dataTables.min.js"></script>
<script src="js/jquery.priceformat.min.js" type="text/javascript"></script>
<script>
$('[data-widget="pushmenu"]').PushMenu('toggle')

$(document).ready(function() {
    $("table.display").DataTable({
        "scrollY": "70vh",
        "scrollCollapse": true,
        "language": {
            "lengthMenu": "ສະແດງ _MENU_ ແຖວ",
            "zeroRecords": "ບໍ່ມີຂໍ້ມູນ",
            "info": "ສະແດງໜ້າທີ _PAGE_ ຂອງໜ້າທີ _PAGES_ ",
            "infoEmpty": "ບໍ່ມີຂໍ້ມູນສະແດງ",
            "search": "ຄົ້ນຫາ: ",
            "paginate": {
                "previous": "ກ່ອນໜ້າ",
                "next": "ຖັດໄປ"
            }
        }
    });
});
</script>


</body>

</html>