<?php 
    include '../connectdb.php';
    include '../check-login.php';

        $get = "";
        $sql = "";
        $title = "";
        if (isset($_GET['date'])) {
            $get = $_GET['date'];
            if ($get == "date") {
                $sql = "SELECT DATE_FORMAT(imp_date, '%d/%M/%Y') AS imdate,sum(price) as total,sum(qty) as qty from tbimport im left JOIN import_detail id ON im.impid=id.impid GROUP BY DATE_FORMAT(imp_date, '%Y-%m-%d') LIMIT 30";     
                $title = "ພີມລາຍງານລາຍຈ່າຍຕາມວັນ";
            }
            if ($get == "month") {
                $sql = "SELECT DATE_FORMAT(imp_date, '%M/%Y') AS imdate,sum(price) as total,sum(qty) as qty from tbimport im left JOIN import_detail id ON im.impid=id.impid GROUP BY DATE_FORMAT(imp_date, '%Y-%m') LIMIT 30";
                $title = "ພີມລາຍງານລາຍຈ່າຍຕາມເດືອນ";
            }
            if ($get == "year") {
                $sql = "SELECT DATE_FORMAT(imp_date, '%Y') AS imdate,sum(price) as total,sum(qty) as qty from tbimport im left JOIN import_detail id ON im.impid=id.impid GROUP BY DATE_FORMAT(imp_date, '%Y') LIMIT 30";
                $title = "ພີມລາຍງານລາຍຈ່າຍຕາມປີ";
            }
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
                <h3 style="text-align: center;font-weight:bold;"><u>'.$title.'</u></h3>
                    
<table class="no-border">
    <tr>
        <td>ວັນທີພີມ: '.date("d/m/Y").'</td>
        <td align="right">ຜູ້ໃຊ້ງານ: '. $_SESSION['name'] .'</td>
    </tr>
</table>
    <table>
        <thead>
            <tr>
                <th>ລຳດັບ</th>
                <th>ວັນທີ</th>
                <th>ລາຍຮັບ</th>
                <th>ຈຳນວນ</th>
            </tr>
        </thead>
        <tbody>';
        ?>
<?php
            
            $result = mysqli_query($con, $sql) or die ("Error in query: $sql". mysqli_error($sql));
            $total = 0;
            $i = 0;
            $sum = 0;
            while ($row = mysqli_fetch_array($result)) {
                $total += $row[1] ;
                $sum += $row[2];
                $i++;
                
                ?>
<?php
                $content .='
        <tr>
            <td>'. $i .'.</td>
<td>'. $row['imdate'] .'</td>
<td align="right">'. number_format($row['total'],2) .'
    ກີບ</td>
    <td align="center">'.$row["qty"].'</td>
</tr>';
?>

<?php 
    }
    ?>

<?php
$content .='
        <tr bgColor="#343a40">
            <td style="color: #fff; font-weight: bold;" colspan="2" align="right">ລວມ</td>
            <td style="color: #fff; font-weight: bold;" align="right">'. number_format($total, 2) .' ກີບ</td>
            <td style="color: #fff; font-weight: bold;" align="center">'.$sum.'</td>
        </tr>

</tbody>
</table>

</div>
';

// echo $content;
// $mdpf->WriteHTML(file_get_contents('../css/bootstrap.min.css'), 1);
$mdpf->WriteHTML($content);
$mdpf->Output("revenue.pdf","I");
?>