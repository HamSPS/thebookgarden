<?php 
    include '../connectdb.php';
    include '../check-login.php';

    $getID = $_GET['revID'];
    $sql = "SELECT rsID,revDate,tbreserv.stid AS empID,firstname, lastName,tbreserv.cusid,cusName FROM tbreserv inner JOIN tbstaff on tbreserv.stID=tbstaff.stid inner JOIN tbcustomer on tbreserv.cusid = tbcustomer.cusID WHERE rsID = '$getID'";
    $result = mysqli_query($con, $sql);

    while($row = mysqli_fetch_array($result)){
        $rsid = $row['rsID'];
        $revDate = $row['revDate'];
        $emp = $row['firstname'] ." ". $row['lastName'];
        $cus = $row['cusName'];
    }

    

        
    $content = '';
?>

<?php
        require_once '../vendor/autoload.php';

        $mdpf = new \Mpdf\Mpdf([
            'format'    => "A5",
            'mode'      => "utf-8",
            'default_font_size' => 10,
            'margin_top' => 5,
            'margin_left' => 5,
            'margin_right' => 5,
            'margin_bottom' => 5,
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
                text-align: center;
            }
            .img-back{
                width: 250px;
                height: 75px;
                background: url("../images/icon.png");
                background-repeat: no-repeat;
                background-size: 250px 100%;
            }
            .img-back p{
                margin: 0;
                padding: 0;
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
                margin-top: -25px;
                margin-bottom: -25px;
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
                vertical-align: top;
            }
        </style>
        ';

        $content .= '
            <div class="page">

                <div class="title">
                <img src="../images/icon.png" width="100px" />
                <p>ຮ້ານສວນໜັງສື<br/>
                The Book Garden</p>
                </div>
                <div class="source">
                <p>ສະຖານທີ່: ບ້ານຫ້ວຍຫົງ ເມື່ອງໄຊທານີ ນະຄອນຫຼວງ</p>
                <p>ເບີໂທຕິດຕໍ່: 020 28 216 900</p>
                <p>Facebook: The Book Garden</p>
                </div>
                <h3 style="text-align: center;font-weight:bold;"><u>ໃບບິນຈອງສິນຄ້າ</u></h3>
                    
<table class="no-border">
    <tr>
        <td>
            ລະຫັດໃບບິນ: '.$rsid.' <br/>
            ຜູ້ໃຊ້ງານ: '. $_SESSION['name'] .' <br/>
            ລູກຄ້າ:​ '.$cus.'
        </td>
        <td align="right">
        
        ວັນທີພີມ: '.date("d/m/Y").' <br/>
        ວັນທີຈອງ: '.$revDate.'
        </td>
    </tr>
</table>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>ສິນຄ້າ</th>
                <th>ລາຄາ</th>
                <th>ຈຳນວນ</th>
                <th>ລາຄາລວມ</th>
            </tr>
        </thead>
        <tbody>';
        ?>
<?php
            $revDetail = "SELECT rsNO,bid,bkName,tbbook.price AS b_price,qty,reserv_detail.price as t_price FROM reserv_detail inner JOIN tbbook on reserv_detail.bid=tbbook.Bkid WHERE rsID = '$rsid'";
            $detail = mysqli_query($con, $revDetail) or die ("Error in query: $revDetail". mysqli_error($revDetail));
            $total = 0;
            $i = 0;
            $sum = 0;
            while ($row = mysqli_fetch_array($detail)) {
                $sum += $row['qty'];
                $total += $row['t_price'];
                $i++;
                
                ?>
<?php
                $content .='
        <tr>
            <td>'. $i .'.</td>
<td>'. $row['bkName'] .'</td>
<td align="right">'. number_format($row['b_price'],2) .' ກີບ</td>
<td align="center">'. $row['qty'].'</td>
    <td align="right">'. number_format($row['t_price'],2) .' ກີບ</td>
    </tr>';
?>

<?php 
    }
    ?>

<?php
$content .='
        <tr bgColor="#343a40">
            <td style="color:#fff;font-weight:bold;" colspan="2" align="right">ລວມ:</td>
            <td style="color:#fff;font-weight:bold;" align="right">'. number_format($total, 2) .' ກີບ</td>
            <td style="color:#fff;font-weight:bold;" align="center">'. $sum .'</td>
            <td></td>
        </tr>

</tbody>
</table>

<table class="no-border">
    <tr>
        <td>';
        $cur = mysqli_query($con, "SELECT * FROM tbcurrency LIMIT 2");
        $count = 0;
        $dis_cur = array("ບາດ","ໂດລາ");
        $i = 0;
        while ($c = mysqli_fetch_array($cur)) {

            $count = $total/$c['cry_num'];
            $content .= '<p>ເປັນ'.$c[cry_disc].': '.number_format($count,2).' '.$dis_cur[$i].'</p>';
            $i++;
        }

        $content .='
        </td>
        <td align="right">
        ອັດຕາແລກປ່ຽນ <br/>';
        $i=0;
        $cur = mysqli_query($con, "SELECT * FROM tbcurrency LIMIT 2");
        while ($cc = mysqli_fetch_array($cur)) {
            
            $content .='<p>ເງິນ'.$dis_cur[$i].': '.number_format($cc['cry_num'],2).' ກີບ</p>';
            $i++;
        }
        $content .= '
        </td>
    </tr>
</table>

</div>
';

// echo $content;
// $mdpf->WriteHTML(file_get_contents('../css/bootstrap.min.css'), 1);
$mdpf->WriteHTML($content);
$mdpf->Output("revenue.pdf","I");
?>