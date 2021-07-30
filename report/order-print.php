<?php 
    include '../connectdb.php';
    include '../check-login.php';

    $start = '';
    $end = '';
    $where = '';

    if(isset($_GET['start']) && isset($_GET['end'])){
        $start = $_GET['start'];
        $end = $_GET['end'];
        $where = empty($start) ? " " : "WHERE pdate >= '$start' AND pdate <= '$end'";
    }
    
    if ($start == '') {
        $sale_start = "ລາຍງານທັງໝົດ";
    }else{
        $sale_start = "ລາຍງານຈາກວັນທີ່: ". $start;
    }

    if ($end == '') {
        $sale_end = "";
    }else{
        $sale_end = "ຫາວັນທີ: ".$end;
    }
    $content = '';
?>

<?php
        require_once '../vendor/autoload.php';

        $mdpf = new \Mpdf\Mpdf([
            'format'    => "A4",
            'mode'      => "utf-8",
            'default_font_size' => 10,
            'margin_top' => 10,
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_bottom' => 10,
            'default_font'  => 'phetsarath_ot',
        ]);

        $content = '
        <style>
            .page{
                width: 100%;
                height: 29.7cm;
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            .title{
                display: block;
                padding: 5px 0;
            }
            .img-back{
                width: 250px;
                height: 75px;
                background: url("../images/icon.png");
                background-repeat: no-repeat;
                background-size: 250px 100%;
            }
            .img-back p{
                padding-left: 100px;
                padding-top: 25px;
            }
            .title .img-title{
                width: 100px;
                height: auto;
                background: #fff;
                margin-left: auto;
                margin-right: auto;
                margin-bottom: 15px;
            }
            table{
                width: 100%;
                border-collapse: collapse;
                vertical-align: top;
            }
            table td, table th{
                border: 1px solid #ddd;
                padding: 8px;
            }
            th{
                width: fit-content;
                background: #04AA6D;
                color: #fff;
                text-align: center;
                padding-top: 12px;
                padding-bottom: 12px;
            }
            .source{
                font-size: 12px;
                position: fixed;
                padding-left: 5px;
            }
            .source p {
                padding: -5 0;
            }
            .table-footer{
                background: #f7f4cd;
                border: 1px solid #ddd;
            }
            .table-footer td{
                border: none;
            }
            .no_value td{
                background: #eb6060;
                color: #fff;
                text-align: center;
            }

            table.no-border tr td{
                border: none;
            }
        </style>
        ';

        $content .= '
            <div class="page">

                <div class="title">
                <div class="img-back">
                <p>ຮ້ານສວນໜັງສື<br/>
                The Book Garden</p>
                </div>
                </div>
                <div class="source">
                <p>ສະຖານທີ່: ບ້ານຫ້ວຍຫົງ ເມື່ອງໄຊທານີ ນະຄອນຫຼວງ</p>
                <p>ເບີໂທຕິດຕໍ່: 020 28 216 900</p>
                <p>Facebook: The Book Garden</p>
                </div>
                <h3 style="text-align: center;font-weight:bold;"><u>ລາຍງານຂໍ້ມູນການສັ່ງຊື້</u></h3>
                    
<table class="no-border">
    <tr>
        <td>ວັນທີພີມ: '.date("d/m/Y").'</td>
        <td align="right">ຜູ້ໃຊ້ງານ: '. $_SESSION['name'] .'</td>
    </tr>
    <tr>
        <td colspan="2">
            '. $sale_start .' '. $sale_end .'
        </td>
    </tr>
</table>
    <table>
        <thead class="table-primary text-center">
            <tr>
                <th>ລຳດັບ</th>
                <th>ລະຫັດການສັ່ງຊື້</th>
                <th>ລາຍການສັ່ງຊື້</th>
                <th>ຈຳນວນທັງໝົດ</th>
                <th>ຜູ້ສະໜອງ</th>
                <th>ພະນັກງານ</th>
                <th>ວັນທີສັ່ງຊື້</th>
                <th>ສະຖານະ</th>
            </tr>
        </thead>
        <tbody>
        '; 
        $sum = 0;
        // $total_price = 0;
        $sql = "SELECT pcid,pdate,p.sup_id,sup_name,p.sts_id,sts_name,FirstName,LastName FROM tbpurchase p inner JOIN tbsuppliers sp on p.sup_id=sp.sup_id inner JOIN tbl_status st on p.sts_id = st.sts_id left JOIN tbstaff s on p.stid=s.stid $where";
        $query_emp = mysqli_query($con, $sql);
        if(mysqli_num_rows($query_emp) > 0){
        while ($row = mysqli_fetch_array($query_emp)) {
            $sum++;
            
            // $total_price += $row['total_price'];
            $content .='
            <tr>
                <td>'. $sum .'</td>
                <td align="center">'. $row['pcid'] .'</td>
                <td>';
                ?>
                <?php 
                        $sql1 = "SELECT pcNO,bid,bkName,qty FROM purchase_detail inner JOIN tbbook on purchase_detail.bid=tbbook.bkid WHERE pcid = '$row[pcid]'";
                        $rst = mysqli_query($con, $sql1);
                        $j = 0;
                        $cnt = 0;
                        while($prd = mysqli_fetch_array($rst)){
                            $j++;
                            $cnt += $prd['qty'];
                            $content .= 'ລາຍການທີ່ '.$j.': '.$prd["bkName"].' <br>';
                            // $content .='ລາຍການ '. $j .': '. $prd[bkName] .'<br/>';
                        }
                    $content .= '
                </td>
                <td align="center">'. $cnt .'</td>
                <td>'. $row["sup_name"] .'</td>
                <td>'. $row['FirstName'] .' '. $row['LastName'] .'</td>
                <td align="center">'. $row["pdate"] .' ກີບ</td>
                <td>'. $row["sts_name"] .'</td>
            </tr>';
                            }
                        }else{
                            $content .='
                            <tr class="no_value">
                                <td colspan="6">ບໍ່ມີຂໍ້ມູນ</td>
                            </tr>
                            ';
                        }
        mysqli_free_result($query_emp);
        mysqli_next_result($con);
        $content .='
            <tr class="table-footer">
                <td colspan="2" align="right">ລວມທັງໝົດ:</td>
                <td>'.$sum.' ຄັ້ງ</td>
                <td colspan="5"></td>
            </tr>
        </tbody>
    </table>

    </div>
    ';

    // echo $content;
    // $mdpf->WriteHTML(file_get_contents('../css/bootstrap.min.css'), 1);
    $mdpf->WriteHTML($content);
    $mdpf->Output("order.pdf","I");
    ?>