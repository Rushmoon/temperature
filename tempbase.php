<?php
//pid 音乐类型

@$conn = mysql_connect('localhost','root','root') or die("数据库连接错误
:".mysql_error().'------'.mysql_error());
mysql_select_db('trdb');


$dataArr = file('1901.txt');
$len = count($dataArr);//计算文件中的总长度
echo  $len."<hr>"  ;
for($i = 0;$i < $len;$i++){
//    sleep(5);
    $num = strpos($dataArr[$i],'99999');
    $dates = substr($dataArr[$i],$num+5,8);
    $year = substr($dates,0,4);
    $month = substr($dates,4,2);
    $day = substr($dates,6,2);
    $num = strpos($dataArr[$i],'N9');
    $temperature = substr($dataArr[$i],$num+2,5);
    $fu = substr($temperature,0,1);
    $temr = (int)substr($temperature,1,4);
    if ($fu == '+'){
        $temperature = $temr;
    }else{
        $temperature = $fu.$temr;
    }
//    echo $year.'-'.$month.'-'.$day.','.$temperature."<br>";
    $sql = "insert into tempt(year,month,day,temperature) values('$year','$month','$day','$temperature')";
    mysql_query($sql,$conn) or die("数据库连接错误:".mysql_error().'------'.mysql_error());
    ob_flush();
}
