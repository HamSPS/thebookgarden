<?php 
    include '../connectdb.php';
    include '../check-login.php';

    $start = '';
    $end = '';
    $where = '';

    if(isset($_GET['start']) && isset($_GET['end'])){
        $start = $_GET['start'];
        $end = $_GET['end'];
        $where = empty($start) ? " " : "WHERE sl_date >= '$start' AND sl_date <= '$end'";
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
                <h3 style="text-align: center;font-weight:bold;"><u>ລາຍງານຂໍ້ມູນການຂາຍ</u></h3>
                    
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
                <th>ລະຫັດ</th>
                <th>ວັນທີຂາຍ</th>
                <th>ຊື່ພະນັກງານ</th>
                <th>ຈຳນວນ</th>
                <th>ລາຄາລວມ</th>
                <th>ຈຳນວນທີ່ຈ່າຍ</th>
            </tr>
        </thead>
        <tbody>
        '; 
        $sum = 0;
        $total_price = 0;
        $sql = "SELECT slID,sl_date,FirstName,lastName,total_price,sl_pay FROM tbsale sl LEFT JOIN tbstaff st ON sl.stID=st.stid $where ORDER BY slID";
        $query_emp = mysqli_query($con, $sql);
        if(mysqli_num_rows($query_emp) > 0){
        while ($row = mysqli_fetch_array($query_emp)) {
            $sum++;
            $total_price += $row['total_price'];
            $content .='
            <tr>
                <td align="center">'. $row['slID'] .'</td>
                <td align="center">'. $row['sl_date'] .'</td>
                <td>'. $row['FirstName'] .' '. $row['lastName'] .'</td>
                <td align="center">';
                ?>
<?php
                    $detail = mysqli_query($con, "SELECT * FROM sale_detail WHERE slid = '$row[slID]'");
                    $d = mysqli_num_rows($detail);
                $content .=' '. $d .'
                </td>
                <td align="right">'. number_format($row['total_price'],2) .' ກີບ</td>
                <td style="text-align: right">';
                ?>
<?php
                    if ($row['sl_pay'] == "") {
                        $pay = "";
                    }else{
                        $pay = $row['sl_pay'] .' ກີບ';
                    }
                    $content .=' '. $pay .'
                </td>
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
                <td colspan="2"></td>
                <td align="right">ລວມທັງໝົດ:</td>
                <td>'.$sum.' ຄັ້ງ</td>
                <td>ຍອດຂາຍລວມ:</td>
                <td>'.number_format($total_price,2).' ກີບ</td>
            </tr>
        </tbody>
    </table>

    </div>
    ';

    // echo $content;
    // $mdpf->WriteHTML(file_get_contents('../css/bootstrap.min.css'), 1);
    $mdpf->WriteHTML($content);
    $mdpf->Output("sale.pdf","I");
    ?>