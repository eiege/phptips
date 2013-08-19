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
    <div><input type="text" name="uname" class="ck_uname" value="textvalue" /></div>
    <div><input type='text' name="num1" class="ck_num otherclass" value="abc" /></div>
    <div><input type="text" name="num2" class="ck_num otherclass" value="123" /></div>
    <div><input type="text" name="email" class="ck_email" value="gaoc@kingnet.com" /></div>
    <div><input type="text" name="name" class="ck_name" value="myname" /></div>
    <div><input type="text" name="name" class="ck_pw" value="myupw" /></div>
    <div><input type="text" name="name" class="ck_pw_again" value="myupw" /></div>
    <div><input type="text" name="name" class="ck_vc" value="vc" /></div>
    <div></div>
    <div></div>
    <div><input type="submit" /></div>
</form>
<div id="123_fmsg">

</div>
</body>
</html>