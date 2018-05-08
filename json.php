<?php
/**
 * Created by PhpStorm.
 * User: siwei
 * Date: 2018/4/17
 * Time: 21:24
 */
if($_POST)
{
    $dateS = explode('-',$_POST['dateS']);
    $dateE = explode('-',$_POST['dateE']);
    if ($_POST['order'] == 2) {
        $sql = "select * from tempt where year<=$dateE[0] and year >=$dateS[0] and month <=$dateE[1] and month >= $dateS[1]
            and day <=$dateE[2] and day>=$dateS[2] order by temperature desc";
    }
    else{
        $sql = "select * from tempt where year<=$dateE[0] and year >=$dateS[0] and month <=$dateE[1] and month >= $dateS[1]
            and day <=$dateE[2] and day>=$dateS[2] order by temperature";
    }
    $res = mysql_query($sql,$conn) or die("数据库连接错误:".mysql_error().'------'.mysql_error());
    //        $arr = mysql_fetch_assoc($res);//处理一条数据，指针向下移
    $i=0;
    $Arr = array();
    while($row = mysql_fetch_assoc($res)) {

        $Arr[$i] = $row['temperature'];
        $i = $i+1;
    }
    echo json_encode($Arr);
}
