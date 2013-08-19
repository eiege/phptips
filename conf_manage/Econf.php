<?php
/**
 * Created by JetBrains PhpStorm.
 * User: gaocheng
 * Date: 13-8-1
 * Time: 上午9:56
 * To change this template use File | Settings | File Templates.
 * 配置文件管理类vdeid
 *
 */

class Econf
{
    public $main_path = "/confs"; //配置文件夹主路径  传入 /opt/wwwroot/sdfsdf 绝对路径
    public $conf_path = ""; //配置文件在配置主文件夹中的路径不能为空。传入122456
    public $debug = false; //是否开启debug模式
    public $iniconf = "conf_file_list"; //初始的配置文件列表的文件名。
    public $conf_ext_name = "txt"; //配置文件的扩展名。
    public $conf_file_path, $conf_dir_path;
    public $back_lang = 10;

    public function __construct($pars = array())
    {
        $this->conf_path = date("ym", time()); //设置默认的配置分组

        $this->main_path = empty($pars['v']['main_path']) ? $this->main_path : $pars['v']['main_path'];
        $this->conf_path = empty($pars['v']['conf_path']) ? $this->conf_path : $pars['v']['conf_path'];
        $this->debug     = empty($pars['d']) ? $this->debug : $pars['d'];

        //检测必要的变量
        if (empty($this->main_path) && is_string($this->main_path))
        {
            echo "main_path error:[16:22:09]";
            exit();
        }

        if (empty($this->conf_path) && is_string($this->conf_path))
        {
            echo "conf_path error:[15:46:50]";
            exit();
        }

        $pars                 = array(
            "v" => array(
                "confname" => $this->iniconf,
                "confdata" => array(),
            ),
        );
        $this->conf_dir_path  = $this->main_path . "/" . $this->conf_path;
        $this->conf_file_path = $this->conf_dir_path . "/" . $this->iniconf . "." . $this->conf_ext_name;

        if (!is_dir($this->conf_dir_path))
        {
            $mkpath_tem = array(
                "v" => array(
                    "path" => $this->conf_dir_path,
                ),
            );
            $this->mkpath($mkpath_tem);
        }

        if (!file_exists($this->conf_file_path))
        {
            $this->set_conf_file($pars);
        }

    }


    /**
     * 添加配置文件
     * @param array $pars confname:配置文件名 showname:配置文件显示名
     * @return array
     */
    public function add_conf_file($pars = array())
    {
        //初始化返回信息
        $ret = array(
            "e" => true,
            "i" => "",
            "d" => array(
                "pars" => $pars,
            ),
        );
        //设置debug模式
        if (!empty($pars['d']))
        {
            $this->debug = true;
        }
        //code...
        $confname =& $pars['v']['confname'];
        $showname =& $pars['v']['showname'];
        if (empty($confname) || empty($showname))
        {
            $ret['i'] = "confname and showname are must[17:18:29]";
        }
        else
        { //文件名和显示名正常
            $pars_tem = array(
                "v" => array(
                    "confname" => $confname,
                ),
            );
            $get_ret  = $this->get_conf_file($pars_tem);
            $this->debug and $ret['d']['get_ret'] = $get_ret;

            if ($get_ret['e'] === false)
            { //获取成功，说明文件已经存在，就之将其加入索引即可。
                $index_ret = $this->index_conf_file($pars);
                $ret['e']  = $index_ret['e'];
                $ret['i']  = $index_ret['i'];
            }
            else
            { //获取失败，就开始设置,

                $tem_pars = array(
                    "v" => array(
                        "confname" => $confname,
                        "confdata" => array(),
                    ),
                );
                $set_ret  = $this->set_conf_file($tem_pars);
                if ($set_ret['e'] === false)
                { //设置成功,准备写入索引
                    $index_ret = $this->index_conf_file($pars);
                    $ret['e']  = $index_ret['e'];
                    $ret['i']  = $index_ret['i'];
                }
                else
                {
                    //设置失败
                    $ret['i'] = "add_file error:[17:53:40]";
                }
            }
        }


        if (empty($pars['d']) && !$this->debug)
        {
            unset($ret['d']);
        }

        return $ret;
    }


    /**
     * 配置修改还原
     * @param array $pars rev_name 要恢复的配置文件名 rev_id 要恢复的配置索引
     * @return array
     */
    public function rev_conf_file($pars = array())
    {
        $ret = array(
            "e" => true,
            "i" => "",
            "d" => array(),
        );
        if (!empty($pars['d']))
        {
            $this->debug = true;
        }
        $this->debug and $ret['d']['pars'] = $pars;

        $rev_id       =& $pars['v']['rev_id']; //恢复的编号。
        $rev_confname =& $pars['v']['rev_name']; //恢复的配置名。
        if ($rev_id == null)
        {
            $ret["i"] = "error:rev_id is null [09:27:36]";

            return $ret;
        }
        if ($rev_confname == null)
        {
            $ret['i'] = "error:rev_confname is null [09:28:13]";

            return $ret;
        }

        $get_bak_pars = array(
            "v" => array(
                "confname" => $rev_confname . ".bak",
            ),
        );
        $get_bak_ret  = $this->get_conf_file($get_bak_pars);
        $this->debug and $ret['d']['get_bak_ret'] = $get_bak_ret;
        if ($get_bak_ret['e'] == true)
        {
            $ret['i'] = $get_bak_ret['i'];

            return $ret;
        }

        $rev_cent =& $get_bak_ret['i'][$rev_id];
        $this->debug and $ret['d']['rev_cent'] = $rev_cent;
        if (empty($rev_cent))
        {
            $ret['i'] = "error:recovery is empty[09:36:19]";

            return $ret;
        }

        $set_conf_pars = array(
            "v" => array(
                "confname" => $rev_confname,
                "confdata" => $rev_cent,
                "nobackup" => true,
            ),
        );
        $this->debug and $ret['i']['set_conf_pars'] = $set_conf_pars;
        $set_ret = $this->set_conf_file($set_conf_pars);
        if ($set_ret['e'] == true)
        {
            $ret['i'] = $set_ret['i'];

            return $ret;
        }
        else
        {
            $ret['e'] = false;
            $ret['i'] = true;
        }

        return $ret;
    }

    //向配置文件中写入数据
    public function set_conf_file($pars = array())
    {
        //初始化返回信息
        $ret = array(
            "e" => true,
            "i" => "",
            "d" => array(
                "pars" => $pars,
            ),
        );
        //设置debug模式
        if (!empty($pars['d']))
        {
            $this->debug = true;
        }
        //code...
        $confname =& $pars['v']['confname'];
        $confdata =& $pars['v']['confdata'];
        $nobackup =& $pars['v']['nobackup'];
        if (empty($confname))
        { //如果要创建的配置文件名为空
            $e['i'] = "confname is not null[16:48:36]";
        }
        elseif (!is_string($confname))
        { //如果不是字符串
            $e['i'] = "confname must is string[16:51:22]";
        }
        elseif (strpos($confname, "./"))
        { //如果包含非法字符
            $e['i'] = "confname is illegitimate[16:53:59]";
        }
        else
        { //文件名正常

            //备份
            if (!$nobackup)
            {
                $bak_pars = array(
                    "v" => array(
                        "confname" => $confname,
                    ),

                );
                $this->back_conf_file($bak_pars);
            }

            // $conf_file_path = $this->main_path . "/" . $this->conf_path . "/" . $confname . "." . $this->conf_ext_name;
            $conf_file_path = $this->conf_dir_path . "/" . $confname . "." . $this->conf_ext_name;
            $this->debug and $ret['d']['conf_path'] = $conf_file_path;


            $confdata_ser = serialize($confdata);
            $put_ret      = file_put_contents($conf_file_path, $confdata_ser, LOCK_EX);

            if ($put_ret === false)
            { //设置失败
                $ret['i'] = "set conf_file failed:[16:39:43]";
            }
            else
            { //设置成功
                $ret['e'] = false;
                $ret['i'] = true;

            }


        }
        if (empty($pars['d']) && !$this->debug)
        {
            unset($ret['d']);
        }

        return $ret;
    }


    //获取配置文件内容
    public function get_conf_file($pars = array())
    {
        //初始化返回信息
        $ret = array(
            "e" => true,
            "i" => "",
            "d" => array(
                "pars" => $pars,
            ),
        );
        //设置debug模式
        if (!empty($pars['d']))
        {
            $this->debug = true;
        }
        //code...
        $confname =& $pars['v']['confname'];

        if (empty($confname))
        { //如果配置文件名为空
            $e['i'] = "confname is not null[16:48:37]";
        }
        elseif (!is_string($confname))
        { //如果不是字符串
            $e['i'] = "confname must is string[16:51:23]";
        }
        elseif (strpos($confname, "./"))
        { //如果包含非法字符
            $e['i'] = "confname is illegitimate[16:53:60]";
        }
        else
        {
            $conf_file_path = $this->conf_dir_path . "/" . $confname . "." . $this->conf_ext_name;
            $this->debug and $ret['d']['conf_file_path'] = $conf_file_path;

            if (file_exists($conf_file_path))
            {
                $file_str = file_get_contents($conf_file_path);
                if ($file_str === false)
                { //获取失败
                    $ret['i'] = "get_conf_file failed[17:39:28]";
                }
                else
                { //获取成功
                    $ret['e'] = false;
                    $ret['i'] = unserialize($file_str);
                }

            }
            else
            {
                $ret['i'] = "don't find file[11:59:47]";
            }
        }


        if (empty($pars['d']) && !$this->debug)
        {
            unset($ret['d']);
        }

        return $ret;
    }

    //php创建多级目录
    public function mkpath($pars = array())
    {
        //初始化返回信息
        $ret = array(
            "e" => true,
            "i" => "",
            "d" => array(
                "pars" => $pars,
            ),
        );
        //设置debug模式
        if (!empty($pars['d']))
        {
            $this->debug = true;
        }
        //code...
        $path_str =& $pars['v']['path'];
        $path_ary = explode("/", $path_str);
        $path_tem = "";
        foreach ($path_ary as $k => $v)
        {
            $path_tem .= $v . "/";
            is_dir($path_tem) or mkdir($path_tem);
        }

        if (is_dir($path_str))
        { //创建成功
            $ret['e'] = false;
            $ret['i'] = true;
        }
        else
        { //创建失败
            $ret['i'] = "create path failed[11:20:20]";
        }


        if (empty($pars['d']) && !$this->debug)
        {
            unset($ret['d']);
        }

        return $ret;
    }

    /**
     * 删除配置索引
     * @param array $pars
     */
    public function del_conf_file($pars = array())
    {
        $ret = array(
            "e" => true,
            "i" => "",
            "d" => array(),
        );
        if (!empty($pars['d']))
        {
            $this->debug = true;
        }
        $this->debug and $ret['d']['pars'] = $pars;

        $confname =& $pars['v']['confname'];
        if ($confname === null)
        {
            $ret['i'] = "error:confname is must[13:52:10]";

            return $ret;
        }
        $index_conf_pars = array(
            "v" => array(
                "confname" => $this->iniconf,
            ),
        );
        $index_conf      = $this->get_conf_file($index_conf_pars);
        if ($index_conf['e'] === true)
        {
            $ret['i'] = "get index config error [13:59:55]";

            return $ret;
        }
        $index_conf = $index_conf['i'];
        if (array_key_exists($confname, $index_conf))
        {
            unset($index_conf[$confname]);
        }
        $set_index_conf = array(
            "v" => array(
                "confname" => $this->iniconf,
                "confdata" => $index_conf,
            ),
        );
        $set_ret        = $this->set_conf_file($set_index_conf);

        if ($set_ret['e'] === true)
        {
            $ret['i'] = $set_ret['i'];

            return $ret;
        }
        $ret['e'] = false;
        $ret['i'] = true;

        return $ret;

    }

    //将配置文件加入索引
    public function index_conf_file($pars = array())
    {
        //初始化返回信息
        $ret = array(
            "e" => true,
            "i" => "",
            "d" => array(
                "pars" => $pars,
            ),
        );
        //设置debug模式
        if (!empty($pars['d']))
        {
            $this->debug = true;
        }
        //code...


        $confname =& $pars['v']['confname'];
        $showname =& $pars['v']['showname'];
        if (empty($confname) || empty($showname))
        {
            $ret['i'] = "confname and showname are must[17:18:29]";
        }
        else
        {
            $tem_pars = array(
                "v" => array(
                    "confname" => $this->iniconf,
                ),
            );
            $get_ret  = $this->get_conf_file($tem_pars);
            if ($get_ret['e'] === false)
            { //获取配置索引成功
                $tem_ary = $get_ret['i'];
                if (is_array($tem_ary))
                {
                    if (!empty($tem_ary[$confname]))
                    {
                        $ret['i'] = "confname is exist[09:18:13]";

                    }
                    else
                    {
                        $tem_ary[$confname]  = $showname;
                        $tem_pars            = array(
                            "v" => array(
                                "confname" => $this->iniconf,
                                "confdata" => $tem_ary,
                            ),
                        );
                        $set_ret             = $this->set_conf_file($tem_pars);
                        $ret['i']['set_ret'] = $set_ret;
                        if ($set_ret['e'] === false)
                        { //设置成功
                            $ret['e'] = false;
                            $ret['i'] = array(
                                "confname" => $confname,
                                "showname" => $showname,
                            );
                        }
                        else
                        { //设置失败
                            $ret['i'] = $set_ret['i'];
                        }
                    }

                }
                else
                {
                    $ret['i'] = "conf list form error[09:16:27]";
                }
            }
            else
            {
                //获取配置索引失败
                $ret['i'] = "get conf list failed[17:57:30]";
            }
        }

        if (empty($pars['d']) && !$this->debug)
        {
            unset($ret['d']);
        }

        return $ret;
    }

    //备份配置文件
    public function back_conf_file($pars = array())
    {
        //初始化返回信息
        $ret = array(
            "e" => true,
            "i" => "",
            "d" => array(
                "pars" => $pars,
            ),
        );
        //设置debug模式
        if (!empty($pars['d']))
        {
            $this->debug = true;
        }
        //code...
        $confname =& $pars['v']['confname'];
        if (empty($confname))
        {
            $ret['i'] = "confname is must[15:28:47]";
        }
        else
        {
            $get_file_pars = array(
                "v" => array(
                    "confname" => $confname,
                ),
            );
            $get_file_ret  = $this->get_conf_file($get_file_pars); //获取文件内容

            $get_bak_pars = array(
                "v" => array(
                    "confname" => $confname . ".bak",
                ),
            );
            $get_bak_ret  = $this->get_conf_file($get_bak_pars);


            if ($get_file_ret['e'] === false)
            { //获取文件内容成功
                if ($get_bak_ret['e'] === false)
                { //获取备份文件内容成功

                    if (count($get_bak_ret['i']) >= $this->back_lang)
                    {
                        $get_bak_ret['i'] = array_slice($get_bak_ret['i'], -($this->back_lang - 1));
                    }


                    $get_bak_ret['i'][] = $get_file_ret['i'];
                    $set_bak_pars       = array(
                        "v" => array(
                            "confname" => $confname . ".bak",
                            "confdata" => $get_bak_ret['i'],
                            "nobackup" => true,
                        ),
                    );

                }
                else
                { //获取备份文件内容失败
                    $set_bak_pars = array(
                        "v" => array(

                            "confname" => $confname . ".bak",
                            "confdata" => array($get_file_ret['i']),
                            "nobackup" => true,
                        ),
                    );
                }
                $set_bak_ret = $this->set_conf_file($set_bak_pars);
                $this->debug and $ret['d']['set_bak_ret'] = $set_bak_ret;

                if ($set_bak_ret['e'] === false)
                { //备份成功
                    $ret['e'] = false;
                    $ret['i'] = true;
                }
                else
                { //备份失败
                    $ret['i'] = "backup file failed[16:15:19]";
                }


            }
            else
            { //获取失败
                $ret['i'] = "get file or file_bak failed[16:03:55]";
            }
        }


        if (empty($pars['d']) && !$this->debug)
        {
            unset($ret['d']);
        }

        return $ret;
    }


    public function mod($pars = array())
    {
        //初始化返回信息
        $ret = array(
            "e" => true,
            "i" => "",
            "d" => array(
                "pars" => $pars,
            ),
        );
        //设置debug模式
        if (!empty($pars['d']))
        {
            $this->debug = true;
        }
        //code...


        if (empty($pars['d']) && !$this->debug)
        {
            unset($ret['d']);
        }

        return $ret;
    }


}