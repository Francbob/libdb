<?php
/**
 * Created by PhpStorm.
 * User: bob
 * Date: 2018/4/21
 * Time: 19:58
 */
//connect database
function book_ifo($our_result)
{
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
    $row = $our_result;
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
    echo "</table>";
}

$con = mysqli_connect("localhost", "root", "072798xjzDCZ", "libraryadmin");
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}
mysqli_select_db($con, "libraryadmin");

$sql = "SELECT * FROM book WHERE bno='" . $_GET['bno'] . "'";
$iniresult = mysqli_query($con, $sql);
$rowFine = mysqli_fetch_array($iniresult);
book_ifo($rowFine);

//CHECK IF BORROW RECORD 存在
//$sql  = "SELECT * FROM"


{
//cause bno is primary key
    $sql = "UPDATE borrow SET return_data=NOW() WHERE bno='". $_GET['bno'] ."' and cno='". $_GET['cno'] . "'";
    $result = mysqli_query($con, $sql);
    if (!$result) {
        die('Could not insert. ' . mysqli_error($con));
    }

    $stock = $rowFine['stock'];
    $sql = "UPDATE book SET stock=" . (string)($stock + 1) . " where bno='" . $_GET['bno'] . "'";

    mysqli_query($con, $sql);
    $sql = "SELECT * FROM book WHERE bno='" . $_GET['bno'] . "'";
    $result = mysqli_query($con, $sql);
    $rowFine = mysqli_fetch_array($result);
    book_ifo($rowFine);
    $sql = "SELECT * FROM borrow WHERE cno='" . $_GET['cno'] . "'";
    $result = mysqli_query($con, $sql);
    echo "<table border='1' class='table'>
<tr>
<th>借书证号</th>
<th>书号</th>
<th>借书日期</th>
<th>还书日期</th>
</tr>";
//
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo "<td>" . $row['cno'] . "</td>";
        echo "<td>" . $row['bno'] . "</td>";
        echo "<td>" . $row['borrow_data'] . "</td>";
        echo "<td>" . $row['return_data'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
mysqli_close($con);