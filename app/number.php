<?php
/**
 * Created by PhpStorm.
 * User: bob
 * Date: 2018/4/21
 * Time: 19:58
 */
//connect database
$con = mysqli_connect("localhost", "root", "072798xjzDCZ", "libraryadmin");
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}
mysqli_select_db($con, "libraryadmin");

echo "<table border='1' class='table'>
<tr>
<th>书号</th>
<th>类别</th>
<th>书名</th>
<th>出版社</th>
<th>出版年份</th>
<th>作者</th>
<th>价格</th>
<th>总量</th>
<th>库存</th>
</tr>";

$myfile = fopen("../upload/books.txt","r") or die("Unable to open file!");
// 输出单行直到 end-of-file
error_reporting(E_ALL ^ E_NOTICE);
while(!feof($myfile)) {
    $book_info = fgets($myfile);
    $get = new SplFixedArray(7);
    $get = explode(",",$book_info);
    $GET = array('bno'=>'','category'=>'','title'=>'',
        'press'=>'', 'year'=>'','author'=>'','price'=>'');
    $GET['bno'] = $get[0];
    $GET['category'] = $get[1];
    $GET['title'] = $get[2];
    $GET['press'] = $get[3];
    $GET['year'] = $get[4];
    $GET['author'] = $get[5];
    $GET['price'] = $get[6];
    insert($GET,$con);
}
fclose($myfile);

function insert($GET,$con)
{
//cause bno is primary key
    $sql = "SELECT total, stock FROM book WHERE bno='" . $GET['bno'] . "'";
//echo $sql;
    $curStock = mysqli_query($con, $sql);
    $curResult = mysqli_fetch_array($curStock);

//judge, insert or update
    if (empty($curResult['total'])) {
        $sql = 'INSERT INTO book VALUES("' . $GET['bno'] . '","' . $GET['category'] . '","'
            . $GET['title'] . '","' . $GET['press'] . '","' . $GET['year'] . '","' . $GET['author']
            . '","' . $GET['price'] . '","1","1")';

    } else {
        $total = $curResult['total'];
        $stock = $curResult['stock'];
        $sql = "UPDATE book SET total='" . (string)($total + 1) . "',stock='" . (string)($stock + 1) . "' where bno='" . $GET['bno'] . "'";
    }

    $result = mysqli_query($con, $sql);

    $sql = "SELECT * FROM book WHERE bno='" . $GET['bno'] . "'";
    $result = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($result)){
        echo "<tr>";
        echo "<td>" . $row['bno'] . "</td>";
        echo "<td>" . $row['category'] . "</td>";
        echo "<td>" . $row['title'] . "</td>";
        echo "<td>" . $row['press'] . "</td>";
        echo "<td>" . $row['year'] . "</td>";
        echo "<td>" . $row['author'] . "</td>";
        echo "<td>" . $row['price'] . "</td>";
        echo "<td>" . $row['total'] . "</td>";
        echo "<td>" . $row['stock'] . "</td>";
        echo "</tr>";
    }
}

echo "</table>";

//mysqli_close($con);
?>