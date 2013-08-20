


$(document).ready(
    function () {
        $("form").live("submit", function () {
            var act = $(this).attr("action");
            var fid=$(this).attr("id");
            //绑定的数据验证
            chk.vc_url="vctest.php";
            var chkret=chk.cf(fid);
           // window.alert("result:"+chkret);
            if(!chkret)
            {
                return false;
            }
            //ajax请求发送
            var req_str=$(this).serialize();
            ajm.pajax(act,req_str,fid+"msg");

            return false;
        });
    }
);


var ajm={
    msgid:"",
    pajax:function(url,req_str,msgid){
        this.msgid=msgid;
        $.ajax({
            type: "post",
            url: url,
            data:req_str,
            success: function (d) {
                ajm.cajax(d);
            },
            error:function(){
                ajm.cajax(false);
            }

        });
    },
    cajax:function(d){
        if(d === false)
        {
            window.alert("请求错误");
        }else{
            $("#"+this.msgid).html(d);
        }
    }
};

var chk={
    /**
     * 检查表单。
     * @param fid
     */
    fid:"",
    vc_url:"",//验证码请求url地址
    o:{},//当前处理的表单元素对象。
    ckret:true,
    cf:function(fid){
        this.fid=fid;
        var ckitems=[
            "ck_num",//检查是否为数字
            "ck_email",//检查邮箱
            "ck_name",//检查可用名
            "ck_pw",//检查密码
            "ck_vc"
        ];
        return this.ck_fcall(ckitems);

    },
    //方法调用。
    ck_fcall:function(fn){

        chk.ckret=true;//这里在每次调用方法之前重置ckret为true，因为是直接使用的chk的方法对象，因此，如果第一次错误，在下一次调用之前没有重置为true，那么chk.ckret的值还是false。
        for(var i in fn)
        {
            if(this.fid)
            {
                var fitems=$("#"+this.fid+" ."+fn[i]);
                fitems.each(function(){
                    var chk_ret=chk[fn[i]](this);
                    if(chk_ret == false)
                    {
                        chk.ckret=false;
                    }
                   // window.alert(chk.ckret);
                });
            }
            else{
                window.alert("fid not defined");
                chk.ckret=false;
            }
        }

        return chk.ckret;

    },

    ck_email:function(o){


        var iv=$(o).val();
        var re=/^[0-9a-zA-Z]+[\w\.-]+[@]{1}[0-9a-zA-Z\.-]+[\.]+[a-zA-Z]+$/gi;
        if(re.test(iv))
        {//yes
            return this.setpass(o);
        }else{//no
            return this.setban(o);
        }

    },


    ck_name:function(o){

        var minlen=4;
        var maxlen=20;

        var iv=$(o).val();
        iv= $.trim(iv);
        var re=/^[\u2E80-\u9FFF\w]+$/gi;
        var len=iv.length;
        if(len<=maxlen && len>=minlen && re.test(iv))
        {
            return this.setpass(o);
        }else{
            return this.setban(o);
        }

    },
    ck_pw:function(o){

        var minlen=6;
        var maxlen=20;


        var iv=$(o).val();
        var iv_len=iv.length;
        var o_again=$(".ck_pw_again");
        var iv_again=$(o_again).val();
        if(iv == iv_again && iv_len>=minlen && iv_len<=maxlen)
        {
            this.setpass(o);
            this.setpass(o_again);
            return true;
        }else{
            this.setban(o);
            this.setban(o_again);
            return false;
        }

    },

    ck_vc:function(o){

        this.o=o;
        var vclen=4;
        var iv=$(o).val();

        if(iv.length !=vclen)
        {
            chk.setban(chk.o);
           return false;
        }
        else{
            chk.setpass(chk.o);
            return true;
        }

        //ajax本来就是异步调用，调用ck_vc的地方，不会等待这里的ajax执行，验证码的验证，本来就是后端权限的验证，不需要再次多加一次请求。
//        $.ajax({
//            type: "post",
//            url: chk.vc_url,
//            data: "vc=" + iv,
//            success: function (d) {
//                //window.alert(d);
//                if (d == 1) {
//                    return chk.setpass(chk.o);
//                } else {
//                    return chk.setban(chk.o);
//                }
//            },
//            error: function () {
//                return chk.setban(chk.o);
//            }
//        });
    },

    ck_num:function(o){
        var iv= $(o).val();
        var re=/\d*/i;
        var reg_ret=iv.match(re);
        if(reg_ret == iv)
        {//yes
            return this.setpass(o);
        }else{//no
            return this.setban(o);
        }
    },
    setpass:function(o){
        $(o).css({color:"green","background-color":"#DFF0D8"});
        return true;
    },
    setban:function(o){
        $(o).css({color:"red","background-color":"#E3A5A2"});
        return false;
    },
    checktest:function(){

    }
};

