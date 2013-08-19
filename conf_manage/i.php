<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<?php
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <script type="text/javascript" src="../base_file/jq1.7min.js"></script>
    <script type="text/javascript">


            function getconf() {
                $("#selmsg").html("Ing...");
                var url = "control_conf.php?ctl=getconf";
                var req_str = $("#mconf").serialize();
                //window.alert(url+"?"+req_str);
;                $.ajax({
                    type: "post",
                    url: url,
                    data: req_str,
                    dataType: "json",
                    success: function (ret) {
                        if (ret.ero == 0) {
                            $("#confdata").val(ret.msg);
                        } else {
                            window.alert("Error:\n\r" + ret.msg);
                        }

                        $("#selmsg").html("Loding Compent");
                    },
                    error: function () {
                        window.alert("通信错误！");

                        $("#selmsg").html("Loding Fail");
                    }


                });

            };
            function addconf(obut) {
                var butv=$(obut).val();
                $(obut).val("Ing...");
                var url="control_conf.php?ctl=addconf";
                var req_str=$("#mconf").serialize();
                $.ajax({
                    type:"post",
                    url:url,
                    data:req_str,
                    dataType:"json",
                    success:function(ret){
                        if(ret.ero == 0)
                        {
                            window.alert("Success:\n\r" + ret.msg);
                            var addconfname=$("#addconfname").val();
                            var addshowname=$("#addshowname").val();
                            $("#addconfname").val("");
                            $("#addshowname").val("");
                            $("#confname").append("<option value='"+addconfname+"' selected='selected' >"+addshowname+"("+addconfname+")</option>");
                            $(obut).val("Add");
                            getconf();
                        }else{
                            window.alert("Error:\n\r"+ret.msg);
                        }
                    },
                    error:function(){
                        window.alert("通信错误！");
                        $(obut).val("Add");

                    }
                });
            };
            function delconf(obut) {
                var confname=$("#confname").val();
                var showname=$("#confname option[value='"+confname+"']").html();
                var isdel=window.confirm("确定删除配置文件'"+showname+"'吗？");
                if(!isdel)
                {
                    return false;
                }
                var butv=$(obut).val();
                $(obut).val("Ing...");
                var url="control_conf.php?ctl=delconf";
                var req_str=$("#mconf").serialize();
                $.ajax({
                    type:"post",
                    url:url,
                    data:req_str,
                    dataType:"json",
                    success:function(ret){
                        if (ret.ero == 0) {
                            window.alert("Success:\n\r" + ret.msg);
                            $("#confname option[value='"+confname+"']").remove();
                        }
                        else {
                            window.alert("Error:\n\r" + ret.msg);
                        }
                        $(obut).val(butv);
                    },
                    error:function(){
                        window.alert("通信错误！");
                        $(obut).val(butv);
                    }
                });

            };
            function setconf(obut) {

                var butv=$(obut).val();
                $(obut).val("Ing...");
                var url = "control_conf.php?ctl=setconf";
                var req_str = $("#mconf").serialize();
                $.ajax({
                    type: "post",
                    url: url,
                    data: req_str,
                    dataType: "json",
                    success: function (ret) {

                        if (ret.ero == 0) {
                           window.alert("Success:\n\r" + ret.msg);
                        }
                        else {
                            window.alert("Error:\n\r" + ret.msg);
                        }
                        $(obut).val(butv);
                    },
                    error: function () {
                        window.alert("通信错误！");

                        $(obut).val(butv);
                    }


                });
            };


            function getbakconf(obut)
            {
                var url = "control_conf.php?ctl=getconf";
                var req_str = $("#mconf").serialize();
                $.ajax({
                type: "post",
                url: url,
                data: req_str,
                dataType: "json",
                success: function (ret) {
                    if (ret.ero == 0) {
                        $("#confdata").val(ret.msg);
                    } else {
                        window.alert("Error:\n\r" + ret.msg);
                    }

                    $("#selmsg").html("Loding Compent");
                },
                error: function () {
                    window.alert("通信错误！");

                    $("#selmsg").html("Loding Fail");
                }
            });
            }


    </script>
    <style type="text/css">
        .fmsg {
            border-radius: 4px;
            border: 1px solid #aaaaaa;
            margin: 5px;
            padding: 5px;
        }
    </style>
    <title></title>
</head>
<?php
require_once("control_conf.php");
$index_list = $margeconf->getindex(true);
?>
<body>

<form id="mconf">
    <div>
        <select id="confname" name="confname" onchange="getconf(this)">
            <option>选择配置</option>
            <?php
            $sel_str = "";
            foreach ($index_list["msg"] as $k => $v)
            {
                $sel_str .= "<option value='" . $k . "'>" . $v. "(".$k.")</option>";
            }
            echo $sel_str;
            ?>
        </select>
        <div id="selmsg">&nbsp;</div>
    </div>
    <div>
        <div>Manger</div>
        <div>
            <input type="text" name="addconfname" id="addconfname"/>:
            <input type="text" name="addshowname" id="addshowname"/>
            <input type="button" value="Add" onclick="addconf(this)"/></div>
        <div><input type="button" name="delconfname" value="Del" onclick="delconf(this)"/></div>
    </div>
    <div><textarea id="confdata" name="confdata" cols="160" rows="20"></textarea></div>
    <div><input type="button" value="Save" onclick="setconf(this)"/></div>
    <div id="bakconfdir" >

    </div>
</form>

</body>
</html>
