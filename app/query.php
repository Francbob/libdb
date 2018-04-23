<?php

$year_b = $_GET['year_begin'];
$year_e = $_GET['year_end'];
$price_b = $_GET['price_begin'];
$price_e = $_GET['price_end'];
//connect database
$con = mysqli_connect("localhost","root","072798xjzDCZ","libraryadmin");
if(!$con){
    die('Could not connect: ' . mysqli_error($con));
}
mysqli_select_db($con,"libraryadmin");

//set query
function addQuery(&$sql, &$flag, $qString, $qVal){
    if(!empty($qVal)){
        if(!$flag){
            $sql .= "WHERE";
            $flag = true;
        }else
            $sql .= ' and';
        $sql .= " ";
        $sql .= ($qString."="."'".$qVal."'");
    }
}
function rangeQuery(&$sql, &$flag, $qString, $begin, $end){
    if(!empty($begin) && !empty($end)){
        if(!$flag){
            $sql .= "WHERE";
            $flag = true;
        }else
            $sql .= ' and';
        $sql .= ' ';
        $sql .= ($qString.">=".$begin.' and '.$qString.'<='.$end);
    }
}
$flag = false;
$sql = "SELECT * FROM book ";
foreach ($_GET as $item => $value){
    if($item != 'year_begin' && $item != 'year_end'
        && $item != 'price_begin' && $item != 'price_end'){
        addQuery($sql, $flag, $item, $value);
    }
}
rangeQuery($sql,$flag,"year", $year_b,$year_e);
rangeQuery($sql,$flag,"price", $price_b,$price_e);

//address query result
$result = mysqli_query($con,$sql);

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