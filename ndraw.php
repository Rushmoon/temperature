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
        #table tr td:nth-child(4){
            background-color: hotpink;
        }
        canvas{
            border: 1px solid rebeccapurple;
        }
    </style>
</head>
<body>
<form action="ndraw.php" method="post" id="form">
    <div>开始日期：<input type="date" name="dateS" value="<?php echo $_POST['dateS']?$_POST['dateS']:'' ?>"></div>
    <div>结束日期: <input type="date" name="dateE" value="<?php echo $_POST['dateE']?$_POST['dateE']:'' ?>"></div>
    <input type="submit" name="sub" value="提交" id="subMe">
    <select name="order" id="order">
        <option value="0">----请选择------</option>
        <option value="1" <?php echo $_POST['order'] == 1?'selected' : '' ?>>升序</option>
        <option value="2" <?php echo $_POST['order'] == 2?'selected' : '' ?>>降序</option>
    </select>
</form>
<table id="table" border="1" style="display: none">
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
        else{
            $sql = "select * from tempt where year<=$dateE[0] and year >=$dateS[0] and month <=$dateE[1] and month >= $dateS[1]
            and day <=$dateE[2] and day>=$dateS[2] ";
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
<canvas width="1000px" height="1000px"></canvas>
<script>
    var oSel = document.getElementById('order');
    var oForm = document.getElementById('form');
    var subMe = document.getElementById('subMe');
    var temp = document.querySelectorAll('#table tr td:nth-child(4)');
    var line = [];
    oSel.onchange = function () {
        oForm.submit();
    }
        for (var i=0; i<temp.length-1;i++){
            line[i] = temp[i+1].innerHTML;
        }
    console.log(line);

    var ocanVas =document.querySelector("canvas");
    var ctx = ocanVas.getContext("2d");
    ctx.lineStyle = "rgb(105,0,103)";

    var  padding = {
        left:20+0.5,
        right:20+0.5,
        top:20+0.5,
        bottom:20+0.5
    };

    var tranth = {
        h:16,
        w:20
    }

    var positionX = {
        x:ocanVas.width - padding.right,
        y:ocanVas.height/2 - padding.bottom
    };
    var  positionY ={
        x : padding.left,
        y : padding.top
    };
    var orgin = {
        x : positionY.x,
        y : positionX.y
    };

    ctx.beginPath();
    ctx.moveTo(orgin.x,orgin.y);
    ctx.lineTo(positionY.x,positionY.y);

    ctx.moveTo(orgin.x,orgin.y);
    ctx.lineTo(positionX.x,positionX.y);
    ctx.stroke();

    ctx.beginPath();
    ctx.moveTo(positionY.x,positionY.y);
    ctx.lineTo(positionY.x-tranth.w/2,positionY.y+tranth.h);
    //    ctx.moveTo(positionY.x,positionY.y);
    ctx.lineTo(positionY.x,positionY.y+tranth.h/2);
    ctx.lineTo(positionY.x+tranth.w/2,positionY.y+tranth.h);
    //
    //
    ctx.moveTo(positionX.x,positionX.y);
    ctx.lineTo(positionX.x-tranth.h,positionX.y-tranth.w/2);
    //    ctx.moveTo(positionX.x,positionX.y);
    ctx.lineTo(positionX.x-tranth.h/2,positionX.y);
    ctx.lineTo(positionX.x-tranth.h,positionX.y+tranth.w/2);
    //    ctx.stroke();
    ctx.fill();



//    line=[10,40,60,20,30,20,10,30,50];

    //    console.log(Math.max(line));
    var spaceX = Math.floor((ocanVas.width-padding.right)/line.length);
    var max = Math.abs(line[0]);
    for(var i=0; i<line.length;i++ ){
        if (Math.abs(line[i])>max){
            max = Math.abs(line[i]);
        }
    }
    console.log(max);
    var spaceY = Math.floor((ocanVas.height/2-padding.top*2-tranth.h)/max);
    line.forEach(function (val , i) {
        ctx.fillRect(orgin.x+spaceX*i-2,orgin.y-val*spaceY-2,4,4);
    });
    ctx.beginPath();
    ctx.moveTo(orgin.x,orgin.y);
    line.forEach(function (val,i) {
        ctx.lineTo(orgin.x + spaceX*i,orgin.y - val*spaceY);
    });
    ctx.stroke();
</script>
</body>
</html>