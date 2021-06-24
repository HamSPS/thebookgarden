<?php 
    include 'connectdb.php';
    @$term = "";
    @$cat = "";
    // @$act = $_GET['act'];
    if (isset($_GET['submit'])) {
        $term = $_GET['term'];
    }

    if (isset($_GET['cat'])) {
        $cat = $_GET['cat'];
    }
    echo $term;
    echo $cat;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test</title>
</head>
<body>
    <form action="" method="get">
            <input type="text" name="term" id="term" placeholder="ຄົ້ນຫາຂໍ້ມູນ" value="<?= @$term ?>" onchange="form.submit()">
            <input type="submit" name="submit" value="ຄົ້ນຫາ">
    </form>
    <form method="get" class="form-inline">
                        <label id="cat" class="my-1 mr-2">ເລືອກປະເພດ</label>
                        <select style="width: 150px;" id="cat" name="cat" onchange="form.submit()">
                            <option value="">ເລືອກປະເພດ</option>
                            <?php
                            $sql = "SELECT * FROM tbcategory";
                            $result = mysqli_query($con, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <option value="<?= $row['catID'] ?>" <?php if ($row['catID'] == @$cat) echo "selected"; ?>><?= $row['catName'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        
                </form>
    <form action="test.php" method="post">
        <table>
            <tr>
                <th>ລຳດັບ</th>
                <th>ຊື່ໜັງສື</th>
                <th>ລາຄາ</th>
            </tr>
            
            <?php
            if (!empty($term)) {
                $sql = "SELECT * FROM tbbook WHERE BkName like '%$term%'";
                $result = mysqli_query($con, $sql) or die("Error in query: $sql". mysqli_error($sql));
                $i = 1;
                while($row = mysqli_fetch_array($result)){
                    echo '<tr>';
                    echo '<td>'. $i . '</td>';
                    echo '<td>'. $row["BkName"] . '</td>';
                    echo '<td>'. number_format($row["price"], 2) . '</td>';
                    echo '</tr>';
                }
            }elseif(!empty($cat)){
                $sql = "SELECT * FROM tbbook WHERE catID like '%$cat%'";
                $result = mysqli_query($con, $sql) or die("Error in query: $sql". mysqli_error($sql));
                $i = 1;
                while($row = mysqli_fetch_array($result)){
                    echo '<tr>';
                    echo '<td>'. $i . '</td>';
                    echo '<td>'. $row["BkName"] . '</td>';
                    echo '<td>'. number_format($row["price"], 2) . '</td>';
                    echo '</tr>';
                }
            }else{
                $sql = "SELECT * FROM tbbook";
                $result = mysqli_query($con, $sql) or die("Error in query: $sql". mysqli_error($sql));
                $i = 1;
                while($row = mysqli_fetch_array($result)){
                    echo '<tr>';
                    echo '<td>'. $i . '</td>';
                    echo '<td>'. $row["BkName"] . '</td>';
                    echo '<td>'. number_format($row["price"], 2) . '</td>';
                    echo '</tr>';
                }
            }
            ?>
        </table>
    </form>
</body>
</html>