<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script type="text/javascript" src="../base_file/jq1.7min.js"></script>
        <script type="text/javascript">
        $(document).ready(function(){
            $("#inp").keydown(function(){
                $.stop();
            })
            $("#inp").keyup(function(){
                var inpv=$("#inp").val();
                $("#inp_show").html(inpv);
                var sel_show=""
                var re=new RegExp(".*"+inpv+'.*');
                $("#sel option").each(function(){
                    var opt_v=$(this).val();
                    var ret=re.exec(opt_v);
                    if(!ret)
                        {
                            $(this).css({"display":"none"});
                        }else{
                            $(this).css({"display":""});
                            $(this).attr("selected","selected");
                    }
                });
            });
        });
        </script>
        <title></title>
    </head>
    <body>
        
        <input id="inp" type="text" />
        <div id="inp_show"></div>
        <br/>
        <select id="sel">
            <option>--</option>
            <option>中国</option>
            <option>社保</option>
            <option>手机</option>
            <option>什么</option>
            <option>钱财</option>
            <option>测试</option>
            <option>中文</option>
        </select>
        <div id="sel_show"></div>
        <?php
        // put your code here
        ?>
    </body>
</html>
