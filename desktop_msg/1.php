<?php
/**
 * 桌面通知
 * Created by JetBrains PhpStorm.
 * User: gaocheng
 * Date: 13-8-6
 * Time: 下午1:13
 * To change this template use File | Settings | File Templates.
 */
?>


<!DOCTYPE html>
<html>
<head>
    <title>Google 桌面通知</title>
    <meta name="generator" content="editplus" />
    <meta name="author" content="" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta http-equiv='content-type' content='text/html; charset=utf-8' />
</head>
<body>

<button id='btn'>显示桌面通知</button>

<script type='text/javascript'>
    document.querySelector("#btn").addEventListener('click', notify, false);

    function notify() {
        if (window.webkitNotifications) {
            if (window.webkitNotifications.checkPermission() == 0) {
                var notification_test = window.webkitNotifications.createNotification("http://images.cnblogs.com/cnblogs_com/flyingzl/268702/r_1.jpg", '标题', '内容'+new Date().getTime());
                notification_test.display = function() {}
                notification_test.onerror = function() {}
                notification_test.onclose = function() {}
                notification_test.onclick = function() {this.cancel();}

                notification_test.replaceId = 'Meteoric';

                notification_test.show();

                var tempPopup = window.webkitNotifications.createHTMLNotification(["http://www.baidu.com/", "http://www.soso.com"][Math.random() >= 0.5 ? 0 : 1]);
                tempPopup.replaceId = "Meteoric_cry";
                tempPopup.show();
            } else {
                window.webkitNotifications.requestPermission(notify);
            }
        }
    }
</script>
</body>
</html>
