<?php
    include 'head.php';

        //test Generate ID
        $sql = "SELECT COUNT(rsID) FROM tbreserv";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);
       //  if (empty($row[0])) {
       //      $lnum = 1;
       //  }else{
       // }
       $lnum = $row[0] + 1;
       //  $lnum = 1000;
       //  echo $lnum;
   
        $fchar = "RS";
        $znum = "";
        if(strlen($lnum) == 1){
            $znum = "00000";
        }else if(strlen($lnum) == 2){
            $znum = "0000";
        }else if(strlen($lnum) == 3){
           $znum = "000";
       }else if(strlen($lnum) == 4){
           $znum = "00";
       }else{
           $znum = "0";
       }

       //check id
       $chk = $fchar.$znum.$lnum;
       $ch_id = "SELECT * FROM tbreserv WHERE rsID = '$chk'";
       $qchk = mysqli_query($con, $ch_id);
       if ($row = mysqli_fetch_array($qchk) > 0) {
           $lnum +=1;
           $znum = "";
            if(strlen($lnum) == 1){
                $znum = "00000";
            }else if(strlen($lnum) == 2){
                $znum = "0000";
            }else if(strlen($lnum) == 3){
            $znum = "000";
            }else if(strlen($lnum) == 4){
                $znum = "00";
            }else{
                $znum = "0";
            }
           $autoID = $fchar.$znum.$lnum;
       }else{
           $autoID = $fchar.$znum.$lnum;
       }
       $date = date("Y-m-d G:i:s");


    @$act = $_GET['act']; //ຮັບຄ່າ action ຈາກເມັດທອດ act
    //  add product
    if (isset($_GET['b_id'])) {

        $b_id =  $_GET['b_id']; //ຮັບຄ່າໄອດີຈາກ method b_id
        //add to cart
            if ($act == 'add' && !empty($b_id)) {
                if(isset($_SESSION['rev'][$b_id])){
                    $_SESSION['rev'][$b_id]++;
                }else{
                    $_SESSION['rev'][$b_id]=1;
                }
            }
            //remove product
            if ($act == 'remove' && !empty($b_id)){
                unset($_SESSION['rev'][$b_id]);
            }
        }
        //update cart
        if ($act == 'update') {
            $amount_array = $_POST['amount'];
            foreach($amount_array as $b_id => $amount){
                $_SESSION['rev'][$b_id]=$amount;
            }
        }
        //clear cart
        if ($act == 'cancel'){
            unset($_SESSION['rev']);
        }

     


    // @$cusID = "";
    // @$cusName = "";
    // $cus = $_GET['act'];
    $cusID = "";
    $cusName = "";
    if ($act == 'acus') {
        $_SESSION['cusID'] = $_GET['cusid'];
        $_SESSION['cusName'] = $_GET['cusName'];
    }

    

    include 'menu.php';
?>

<div class="content">
    <div class="container-fluid">
        <form action="?act=update" method="post">
            <h5 class="alert alert-success text-center">ເພີ່ນຂໍ້ມູນການຈອງ</h5>
            <div class="row">
                <div class="col-md-7">
                    <h1 class="text-center mb-3"><u>ລາຍການ</u></h1>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-row">
                                <div class="col">
                                    <label for="revid">ລະຫັດການຈອງ</label>
                                    <input type="text" name="revid" id="revid" placeholder="ປ້ອນລະຫັດການຈອງ" value="<?= $autoID ?>" class="form-control" required disabled>
                                </div>
                                <div class="col">
                                    <label for="rdate">ວັນທີຈອງ</label>
                                    <input type="datetime" name="rdate" id="rdate" class="form-control" value="<?= $date ?>" required disabled>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <label for="stName">ພະນັກງານ</label>
                                    <input type="text" name="stName" id="stName" class="form-control" value="<?= @$_SESSION['name'] ?>" required disabled>
                                    <input type="hidden" name="stid" value="<?= $_SESSION['empID'] ?>">
                                </div>
                                <div class="col">
                                    <label for="cName">ລູກຄ້າ</label>
                                    <div class="d-flex">
                                        <input type="text" name="cName" id="cName" class="form-control" value="<?= @$_SESSION['cusName'] ?>" require disabled>
                                        <input type="hidden" name="cid" value="<?= $_SESSION['cusID'] ?>">
                                        <!-- <a href="#" class="btn btn-primary ml-2">ເລືອກ</a> -->
                                        <button type="button" class="btn btn-primary ml-2" data-toggle="modal" data-target=".bd-example-modal-lg">ເລືອກ</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-5">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead align="center" style="background: #EAEAEA;">
                                    <tr>
                                        <th><strong>No.</strong></th>
                                        <th><strong>ສິນຄ້າ</strong></th>
                                        <th><strong>ລາຄາ</strong></th>
                                        <th><strong>ຈຳນວນ</strong></th>
                                        <th><strong>ລວມ</strong></th>
                                        <th><strong>ລົບ</strong></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $total = 0;
                                            $i = 0;
                                            if(!empty($_SESSION['rev'])){
                                                foreach($_SESSION['rev'] as $b_id => $qty){
                                                    $i++;
                                                    $sql = "SELECT * FROM tbbook WHERE Bkid = '$b_id'";
                                                    $query = mysqli_query($con, $sql);
                                                    $row = mysqli_fetch_array($query);
                                                    $sum = $row['price'] * $qty; //ເອົາລາຄາສິນຄ້າມາຄູນຈຳນວນສິນຄ້າ
                                                    $total += $sum; //ລວມລາຄາສິນຄ້າ
                                               
                                        ?>
                                        <tr>
                                            <td><?= $i ?>.</td>
                                            <td><?= $row['BkName'] ?></td>
                                            <td><?= number_format($row['price'], 2) ?> ກີບ</td>
                                            <td align="center"><?php echo "<input type='number' name='amount[$b_id]' value='$qty' min='1' style='width:50px;'/>" ?></td>
                                            <td><?= number_format($sum,2) ?> ກີບ</td>
                                            <td align="center"><a href="Reserv_add.php?b_id=<?= $b_id ?>&act=remove" class="btn btn-danger"><i class="fas fa-trash"></i> ລົບ</a></td>
                                        </tr>
                                        <?php
                                         }
                                        ?>
                                        <tr style="background:#e0d0d0;">
                                            <td colspan="5" align="right">ລາຄາລວມ:</td>
                                            <td align="right"><?= number_format($total, 2) ?> ກີບ</td>
                                        </tr>
                                        <?php 
                                        }else{
                                            echo '<tr style="background: #e0d0d0;">';
                                            echo '<td colspan="7" align="center" style="font-size:16px;">ກະລຸນາເລືອກລາຍການສັ່ງຊື້</td>';
                                            echo '</tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <input type="button" name="btnCancel" value="ຍົກເລີກລາຍການສັ່ງຊື້" onclick="window.location='Reserv_add.php?act=cancel'" class="btn btn-warning">
                            <input type="submit" name="editCart" id="editCart" value="ຄຳນວນລາຄາໃໝ່" class="btn btn-info">
                            <!-- <a href="rev_confirm.php" class="btn btn-primary"><i class="fas fa-shopping-cart"></i> ຢືນຍັນ</a> -->
                            <!-- <input type="submit" class="btn btn-primary" name="rev" id="rev" value="ຢຶນຢັນ"> -->
                            <a href="rev-confirm.php" class="btn btn-primary">ຢືນຢັນ</a>
                            <a href="Reserv-manage.php" class="btn btn-danger">ກັບຄືນ</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-5" style="background: #d2d9d6;">
                <h5 class="mt-2">ເລືອກລາຍການ</h5>
                    <div style="height: 450px; overflow: scroll;">
                        <table class="table table-bordered display bg-white" id="example" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>ລຳດັບ</th>
                                    <th>ຊື່ໜັງສື</th>
                                    <th>ລາຄາ</th>
                                    <th>ເພີ່ມ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $sql = "SELECT * FROM tbbook";
                                $result = mysqli_query($con, $sql);
                                $index = 0;
                                while($row = mysqli_fetch_array($result)){
                                    $index++;
                                ?>
                                <tr>
                                    <td>
                                        <?= $index ?>.
                                        <input type="hidden" name="bkid" value="<?= $row['bkid'] ?>">
                                    </td>
                                    <td><?= $row['BkName'] ?></td>
                                    <td class="text-right"><?= number_format($row['price'],2) ?> ກີບ</td>
                                    <td>
                                    <a href="Reserv_add.php?b_id=<?= $row["Bkid"] ?>&act=add" class="btn btn-success">ເພີ່ມ</a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- model form customer -->
<div class="modal fade bd-example-modal-lg" id="MyModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <form action="" method="get">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ເລືອກຂໍ້ມູນລູກຄ້າ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-striped" id="cuShow">
            <thead class="table-info">
                <tr>
                    <th>ລະຫັດ</th>
                    <th>ຊື່ ແລະ ນາມສະກຸນ</th>
                    <th>ເພດ</th>
                    <th>ທີ່ຢູ່</th>
                    <th>ເບີໂທ</th>
                    <th>ອີເມວ</th>
                    <th>ເລືອກ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT * FROM tbCustomer";
                    $result = mysqli_query($con, $sql);

                    while($row = mysqli_fetch_array($result)){
                    ?>
                        <tr>
                            <td><?= $row['cusID'] ?></td>
                            <td><?= $row['cusName'] ?></td>
                            <td><?= $row['gender'] ?></td>
                            <td><?= $row['address'] ?></td>
                            <td><?= $row['tel'] ?></td>
                            <td><?= $row['email'] ?></td>
                            <td><a href="reserv_add.php?act=acus&cusid=<?= $row['cusID'] ?>&cusName=<?= $row['cusName'] ?>" class="btn btn-success">ເພີ່ມ</a></td>
                        </tr>
                    <?php
                    }
                ?>
            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        <button type="button" class="btn btn-danger" data-dismiss="modal">ຍົກເລີກ</button>
      </div>
    </div>
    </form>
  </div>
</div>

<?php
    include 'footer.php';
?>
    <script>
        $(document).ready(function() {
        $('#cuShow').DataTable();
        } );

        $(document).ready(function(){
            $('#MyModal a').click(function(){
                $("#myModal").modal('hide');
            })
        })
    </script>
</body>

</html>