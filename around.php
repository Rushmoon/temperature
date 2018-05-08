<?php
@$conn = mysql_connect('localhost','root','root') or die("数据库连接错误
:".mysql_error().'------'.mysql_error());
mysql_select_db('trdb');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style>
        #form{
            width: 60%;
            margin: 10px auto 10px;
            border: 1px solid slateblue;
            border-radius: 5px;
            text-align: center;
        }
        #form div{
            width: 90%;
            height: 30px;
            font-size: 20px;
            font-family: SimSun-ExtB;
            line-height: 30px;
            text-align: center;
            color: #4f3c42;
            margin-bottom: 10px;
            margin-top: 5px;
        }
        #form div input{
            width: 60%;
            height: 25px;
            border-radius: 5px;

        }
        #form>input{
            width: 50%;
            height: 50px;
            background-color: aqua;
            color: blanchedalmond;
            font-family: SimSun-ExtB;
            font-size: 30px;
            margin-top: 10px;
        }
        #form>select{
            margin-top: 10px;
            margin-bottom: 20px;
            width: 60%;
            height: 30px;
            font-size: 25px;
        }
        #table{
            border: 0;
            width: 60%;
            margin: 10px auto 10px;
            text-align: center;
        }
    </style>
</head>
<body>
<form action="around.php" method="post" id="form">
    <div>开始日期：<input type="date" name="dateS" value="<?php echo $_POST['dateS']?$_POST['dateS']:'' ?>"></div>
    <div>结束日期: <input type="date" name="dateE" value="<?php echo $_POST['dateE']?$_POST['dateE']:'' ?>"></div>
   <div>阈值a：<input type="number" name="a" id="a" value="<?php echo $_POST['a']?$_POST['a']:'' ?>"></div>
   <div>阈值b: <input type="number" name="b" id="b" value="<?php echo $_POST['b']?$_POST['b']:'' ?>"></div>
    <input type="submit" name="sub" value="提交">
    <select name="order" id="order">
        <option value="0">----请选择------</option>
        <option value="1" <?php echo $_POST['order'] == 1?'selected' : '' ?>>升序</option>
        <option value="2" <?php echo $_POST['order'] == 2?'selected' : '' ?>>降序</option>
    </select>
</form>
<table id="table" border="1">
    <tr>
        <td>年</td>
        <td>月</td>
        <td>日</td>
        <td>温度</td>
    </tr>
    <?php
    if($_POST)
    {
        $dateS = explode('-',$_POST['dateS']);
        $dateE = explode('-',$_POST['dateE']);
        if ($_POST['order'] == 2) {
            $sql = "select * from tempt where year<=$dateE[0] and year >=$dateS[0] and month <=$dateE[1] and month >= $dateS[1]
            and day <=$dateE[2] and day>=$dateS[2] order by temperature desc";
        }
        else if($_POST['order'] == 1){
            $sql = "select * from tempt where year<=$dateE[0] and year >=$dateS[0] and month <=$dateE[1] and month >= $dateS[1]
            and day <=$dateE[2] and day>=$dateS[2] order by temperature";
        }
        else{
            $sql = "select * from tempt where year<=$dateE[0] and year >=$dateS[0] and month <=$dateE[1] and month >= $dateS[1]
            and day <=$dateE[2] and day>=$dateS[2]";
        }
        $res = mysql_query($sql,$conn) or die("数据库连接错误:".mysql_error().'------'.mysql_error());
        //        $arr = mysql_fetch_assoc($res);//处理一条数据，指针向下移
        while($row = mysql_fetch_assoc($res)) {
            ?>
            <tr>
                <td><?= $row['year'] ?></td>
                <td><?= $row['month'] ?></td>
                <td><?= $row['day'] ?></td>
                <td><?= $row['temperature'] ?></td>
            </tr>
            <?php
        }
    }
    ?>
</table>
<script>
    var oSel = document.getElementById('order');
    var oForm = document.getElementById('form');
    var a = document.querySelector('#form div:nth-child(3) input');
    var b = document.querySelector('#form div:nth-child(4) input');
    var temp = document.querySelectorAll('#table tr td:nth-child(4)');
    var line = [];
    var temp1 = a.value;
    var temp2 = b.value;
//    console.log(temp1);
//    console.log(temp2);
    oSel.onchange = function () {
        oForm.submit();
    }
    for (var i=0; i<temp.length-1;i++){
        line[i] = parseInt(temp[i+1].innerHTML);
    }

    for (var j=0;j<line.length;j++){
        if(line[j]>temp1 &&line[j]<temp2){
            temp[j+1].style.background='crimson';
        }
    }

</script>
</body>
</html>