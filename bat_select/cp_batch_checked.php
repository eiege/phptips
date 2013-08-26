<!--
当勾选框非常多时候，批量勾选。
横排和竖排


-->
<?php
$fix=time();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script type="text/javascript" src="../base_file/jq1.7min.js"></script>
        <script type="text/javascript">
            var fix="<?php echo $fix;?>";
            $(document).ready(
                    function(){
                        $(".cbrs").click(function(){
                            //设置一行的全选
                            var chd=$(this).attr("checked");
                            var chv=Number($(this).val());

                            var count=Number($("#"+fix+"_info_count").val());
                            var colsnum=Number($("#"+fix+"_info_cols").val());

                           // window.alert(chd);
                           // window.alert(fix);
                           // window.alert(chv+"|"+count+"|"+colsnum);

                            if(chd)
                            {
                                var i=chv*colsnum+1;
                                var max=(1+chv)*colsnum;
                              //  window.alert(i+"|"+max);
                                while(i<=max)
                                {
                                   // window.alert(i);
                                    $("#cb_"+i).attr("checked","checked");
                                    i++;
                                }
                            }
                            else
                            {
                                var i=chv*colsnum+1;
                                var max=(chv+1)*colsnum;
                                while(i<=max)
                                {
                                    $("#cb_"+i).removeAttr("checked");
                                    i++;
                                }
                            }
                        });

                        $(".cbcs").click(function(){
                            //设置一列的全选
                            var chd=$(this).attr("checked");
                            var chv=Number($(this).val());

                            var count=Number($("#"+fix+"_info_count").val());
                            var colsnum=Number($("#"+fix+"_info_cols").val());

                            // window.alert(chd);
                            // window.alert(fix);
                            // window.alert(chv+"|"+count+"|"+colsnum);

                            if(chd)
                            {
                                var i=0;
                                //  window.alert(i+"|"+max);
                                var chid=0;
                                while(chid<=count)
                                {
                                    // window.alert(i);
                                    var chid=i+chv+1;
                                    $("#cb_"+chid).attr("checked","checked");
                                    i=i+colsnum;
                                }
                            }
                            else
                            {
                                var i=0;
                                var chid=0
                                while(chid<=count)
                                {
                                    // window.alert(i);
                                    var chid=i+chv+1;
                                    $("#cb_"+chid).removeAttr("checked");
                                    i=i+colsnum;
                                }
                            }

                        });
                        $("#cball").click(function(){
                            //设置一列的全选
                            var chd=$(this).attr("checked");

                            var count=Number($("#"+fix+"_info_count").val());


                            if(chd)
                            {
                                var i=0;
                                while(i<=count)
                                {
                                    var chid=i;
                                    $("#cb_"+chid).attr("checked","checked");
                                    i++;
                                }
                            }
                            else
                            {
                                var i=0;
                                while(i<=count)
                                {
                                    var chid=i;
                                    $("#cb_"+chid).removeAttr("checked");
                                    i++;
                                }
                            }
                        });
                    }
            );
        </script>
    </head>
<body>
<?php
    $sdata=range(1,100);//数据源
    $cname="kongjianming";//控件的名字
    $cols= 7;//设置每行显示的条目数


    echo "<table border=1 style='border-collapse: collapse'><tr>";
    $i=0;
    $n=0;
    echo "<td><input type='checkbox' id='cball' /> </td>";
    while($n<$cols)
    {
        echo "<td><input class='cbcs' id='cbcs_".$n."' type='checkbox' value='".$n."'></td>";
        $n++;
    }
    foreach($sdata as $k => $v)
    {

        if($i%$cols == 0)
        {
            $list=intval($i/$cols);
            echo "</tr><tr><td><input class='cbrs' id='cbrs_".$list."' type='checkbox' value='".$list."'></td>";
        }
        echo "<td><input calss='cb' id='cb_".($k+1)."' type='checkbox' value='".$v."'/><label for='cb_".$v."' >".$v."</label></td>";
        $i++;
    }
    $hid="";
    $hid.="<input type='hidden' id='".$fix."_info_count' value='".count($sdata)."'/>";
    $hid.="<input type='hidden' id='".$fix."_info_cols' value='".$cols."'/>";
    echo "</tr></table>";
    echo $hid;
?>
</body>
</html>