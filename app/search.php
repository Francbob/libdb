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

//cause bno is primary key
$sql = "SELECT * FROM card WHERE cno='" . $_GET['cno'] . "'";

$result = mysqli_query($con, $sql);

echo "<table border='1' class='table'>
<tr>
<th>借书证号</th>
<th>姓名</th>
<th>所在系</th>
<th>身份</th>
</tr>";
//
while ($row = mysqli_fetch_array($result)){
    echo "<tr>";
    echo "<td>" . $row['cno'] . "</td>";
    echo "<td>" . $row['name'] . "</td>";
    echo "<td>" . $row['department'] . "</td>";
    echo "<td>" . $row['type'] . "</td>";
    echo "</tr>";
}
echo "</table>";

//mysqli_close($con);