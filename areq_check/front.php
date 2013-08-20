<?php
/**
 * Created by JetBrains PhpStorm.
 * User: gaocheng
 * Date: 13-8-12
 * Time: 下午3:30
 * To change this template use File | Settings | File Templates.
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <script charset="utf-8" src="../base_file/jq1.7min.js"></script>
    <script charset="utf-8" src="myjs.js"></script>
    <script type="text/javascript">
        var c="alert";
        window.c("test alert");
    </script>
    <title></title>
</head>
<body>
<form action="after.php" method="post" id="123_f">
    <div>UNAME</div>
    <div><label>ck_name</label><input type="text" name="uname" class="ck_name" value="textvalue" /></div>
    <div><label>ck_num ck_name</label><input type='text' name="num1" class="ck_num ck_name" value="abc" /></div>
    <div><label>ck_num</label><input type="text" name="num2" class="ck_num otherclass" value="123" /></div>
    <div><label>ck_email</label><input type="text" name="email" class="ck_email" value="gaoc@kingnet.com" /></div>
    <div><label>ck_name</label><input type="text" name="name" class="ck_name" value="myname" /></div>
    <div><label>ck_pw</label><input type="text" name="name" class="ck_pw" value="myupw" /></div>
    <div><label>ck_pw_again</label><input type="text" name="name" class="ck_pw_again" value="myupw" /></div>

    <div>
        <div><img src="vctest.php?gimg=getimg"></div>
        <div><label>ck_vc</label><input type="text" name="vc" class="ck_vc" value="vc" /></div>
    </div>
    <div></div>
    <div></div>
    <div><input type="submit" /></div>
</form>
<div id="123_fmsg">

</div>
</body>
</html>