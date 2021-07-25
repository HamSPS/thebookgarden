<?php 
    include '../connectdb.php';
    include '../check-login.php';

    $getid = '';
    $where = '';

    if(isset($_GET['cat'])){
        $getid = $_GET['cat'];
        $where = empty($getid) ? " " : "WHERE b.catID = '$getid'";
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
                <h3 style="text-align: center;font-weight:bold;"><u>ລາຍງານຂໍ້ມູນປະເພດໜັງສື</u></h3>
                    <div style="text-align: right;">
                        <p>ວັນທີ: '.date("d/m/Y").' </p>
                        <p>ຜູ້ໃຊ້ງານ: '. $_SESSION['name'] .'</p>
                    </div>
    <table>
        <thead class="table-primary text-center">
            <tr>
                <th>ລະຫັດ</th>
                <th>ຊື່ໜັງສື</th>
                <th>ລາຄາ</th>
                <th>ສະຕ໋ອກ</th>
                <th>ຜູ້ຂຽນ</th>
                <th>ລາຍລະອຽດ</th>
                <th>ປະເພດ</th>
            </tr>
        </thead>
        <tbody>
        '; 
        $sum = 0;
        $sql = "SELECT bkid,BkName,price,stock,author,detail,b.catID,catName FROM tbbook b left JOIN tbcategory c ON b.catID=c.catID $where ORDER BY bkid ASC";
        $query_emp = mysqli_query($con, $sql);
        if(mysqli_num_rows($query_emp) > 0){
        while ($row = mysqli_fetch_array($query_emp)) {
            $sum++;
            $content .='
            <tr>
                <td align="center">'. $row['bkid'] .'</td>
                <td>'. $row['BkName'] .'</td>
                <td align="right">'. number_format($row['price'],2) .' ກີບ</td>
                <td align="center">'. $row['stock'] .'</td>
                <td>'. $row['author'] .'</td>
                <td>'. $row['detail'] .'</td>
                <td>'. $row['catName'] .'</td>
            </tr>';
                            }
                        }else{
                            $content .='
                            <tr class="no_value">
                                <td colspan="7">ບໍ່ມີຂໍ້ມູນ</td>
                            </tr>
                            ';
                        }
        mysqli_free_result($query_emp);
        mysqli_next_result($con);
        $content .='
            <tr class="table-footer">
                <td align="right" colspan="6">ລວມທັງໝົດ:</td>
                <td>'.$sum.' ເຫຼັ້ມ</td>
            </tr>
        </tbody>
    </table>

    </div>
    ';

    // echo $content;
    // $mdpf->WriteHTML(file_get_contents('../css/bootstrap.min.css'), 1);
    $mdpf->WriteHTML($content);
    $mdpf->Output("book_category.pdf","I");
    ?>