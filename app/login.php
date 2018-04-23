<?php
/**
 * Created by PhpStorm.
 * User: bob
 * Date: 2018/4/24
 * Time: 1:46
 */

$con = mysqli_connect("localhost", $_POST['name'], $_POST['password'], "libraryadmin");
if (!$con) {
    echo "<div class = \"alert alert-warning\">用户不存在或密码错误</div>";
    //die('Could not connect: ' . mysqli_error($con));
}else{
    if($_POST['name'] == 'root') {
        echo "root";
        setcookie("user","root",time()+3600);
    }
    else {
        echo "student";
        setcookie("user","student",time()+3600);
    }
}