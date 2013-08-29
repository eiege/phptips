<?php
/**
 * pdo study blog
 * Created by JetBrains PhpStorm.
 * User: gaocheng
 * Date: 13-8-29
 * Time: 下午3:11
 * To change this template use File | Settings | File Templates.
 */

class dbl
{
    public $pdo; //pdo 对象
    public $dbtype; //数据库类型
    public $host; //数据库的host地址
    public $dbname; //数据库名
    public $user, $upw; //用户名和密码
    public $ret; //返回内容


    public function __construct($pars = array())
    {
        foreach ($pars as $k => $v)
        {
            $this->$k = $v;
        }

        try
        {
            $this->pdo = new PDO($this->dbtype . ":host=" . $this->host . ";dbname=" . $this->dbname, $this->user, $this->upw);
        } catch (PDOexception $e)
        {
            print("Error!:" . $e->getmessage() . "<br />");
            exit();
        }
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $this->pdo;
    }

    public function getpdo()
    {
        return $this->pdo;
    }

    //事务处理
    public function trans($sql_ary = array())
    {
        try
        {
            $this->pdo->beginTransaction();
            foreach ($sql_ary as $k => $v)
            {
                $this->ret[] = $this->pdo->exec($v);
            }
            $this->pdo->commit();
        } catch (Exception $e)
        {
            $this->pdo->rollBack();
            $this->ret = "Failed:" . $e->getMessage();

            return false;

        }

        return true;
    }

    /**
     * 预处理
     * @param array $pars array(array("sql"=>"sql",pars=array(array(p1,p2,p3),array(p1p2p3))))
     */
    public function presql($pars = array())
    {

        foreach ($pars as $k => $par_stu)
        {
            $stmt = $this->pdo->prepare($par_stu['sql']);

            if (empty($par_stu['pars']))
            {
                $stmt->execute();
                $this->ret[] = $stmt->fetchAll();
            }
            else
            {

                foreach ($par_stu['pars'][0] as $k => $v)
                {
                    $stmt->bindParam(":" . $k, $$k);
                }

                foreach ($par_stu['pars'] as $k => $par_emt)
                {
                    foreach ($par_emt as $k => $v)
                    {
                        $$k = $v;
                    }
                    $stmt->execute();
                 //   $this->ret[] = $stmt->fetchAll();
                }

            }

        }
    }

}



