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

//set query
function addQuery(&$sql, &$flag, $qString, $qVal)
{
    if (!empty($qVal)) {
        if (!$flag) {
            $sql .= "WHERE";
            $flag = true;
        } else
            $sql .= ' and';
        $sql .= " ";
        $sql .= ($qString . "=" . "'" . $qVal . "'");
    }
}

//cause bno is primary key
$sql = "SELECT total, stock FROM book WHERE bno='" . $_GET['bno'] . "'";
//echo $sql;
$curStock = mysqli_query($con, $sql);
$curResult = mysqli_fetch_array($curStock);

//judge, insert or update
if (empty($curResult['total'])) {
    $sql = 'INSERT INTO book VALUES("' . $_GET['bno'] . '","' . $_GET['category'] . '","'
        . $_GET['title'] . '","' . $_GET['press'] . '","' . $_GET['year'] . '","' . $_GET['author']
        . '","' . $_GET['price'] . '","1","1")';

} else {
    $total = $curResult['total'];
    $stock = $curResult['stock'];
    $sql = "UPDATE book SET total='" . (string)($total + 1) . "',stock='" . (string)($stock + 1) . "' where bno='" . $_GET['bno'] . "'";
}

$result = mysqli_query($con, $sql);

$sql = "SELECT * FROM book WHERE bno='" . $_GET['bno'] . "'";
$result = mysqli_query($con, $sql);

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
//
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
echo "</table>";

//mysqli_close($con);
?>