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
        canvas{
            border: 1px solid rebeccapurple;
        }
    </style>
</head>
<body>
<form>
    <div>开始日期：<input type="date" name="dateS" id="ds"></div>
    <div>结束日期: <input type="date" name="dateE" id="de"></div>
    <input type="submit" name="sub" id="subMe" value="提交">
</form>

<canvas width="500px" height="500px"></canvas>
<script>
    var submit = document.getElementById('subMe');
    var dS = document.getElementById('ds');
    var dE = document.getElementById('de');
    submit.onclick = function () {
        var xhr = new XMLHttpRequest();
        var dateS ='dateS' + dS.valueOf();
        var dateE ='dateE' + dE.valueOf();
        xhr.open('post','json.php');
        xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xhr.send();

        xhr.onreadystatechange = function () {
            if (xhr.readyState ===4 && xhr.status ===200){
                var str = xhr.responseText;
                var obj = JSON.parse(str);
                console.log(obj);
            }
        }




    }

</script>

</body>
</html>>