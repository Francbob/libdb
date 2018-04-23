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
$sql = "SELECT name FROM card WHERE cno='" . $_GET['d-cno'] . "'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
$user_name = $row['name'];

$sql = "SELECT * FROM borrow WHERE cno='" . $_GET['d-cno'] . "'";
$result = mysqli_query($con, $sql);
$flag = true;
echo "<table class='table'>";
while ($row = mysqli_fetch_array($result)){
    if($row['return_data'] === NULL){
        echo "<tr>";
        echo "<td>" . $row['cno'] . "</td>";
        echo "<td>" . $row['bno'] . "</td>";
        echo "<td>" . $row['borrow_data'] . "</td>";
        echo "<td>" . $row['return_data'] . "</td>";
        echo "</tr>";
        $flag = false;
    }
}
if(!$flag)
    echo '<div class = "alert alert-warning">此用户尚有借出未还</div>';
else
{
    $sql = "DROP USER ".$user_name."@localhost;";
    mysqli_query($con,$sql);
    echo '<div class = "alert alert-success">成功删除！</div>';
}
echo "</table>";

//mysqli_close($con);