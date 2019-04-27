<?php
    class Zdir{
        //文件图标
        function ico($suffix){
            //根据不同后缀显示不同图标
            switch ( $suffix )
            {
                default:
                    $ico = "fa fa-book";
                    break;
            }
            return $ico;
        }
        //验证文件是否是当前目录
        function checkfile($filepath){
            //获取当前路径
            $thedir = __DIR__;
            $thedir = str_replace("\\","/",$thedir);
            $thedir = str_replace("/functions","",$thedir);
            #$thedir = str_replace("");

            //如果文件不存在
            if(!is_file($filepath)) {
                $filehash = array(
                "code"	=>	0,
                "msg"	=>	"文件不存在！"
                );
                $filehash = json_encode($filehash);
                echo $filehash;
                exit;
            }
            //如果文件不是项目路径
            if(!strstr($filepath,$thedir)){
                $filehash = array(
                "code"	=>	0,
                "msg"	=>	"目录不正确！"
                );
                
                $filehash = json_encode($filehash);
                echo $filehash;
                exit;
            }
            return $filepath;
        }
        //获取文件后缀
        function suffix($filepath){
            //获取文件后缀
            $suffix = explode(".",$filepath);
            $suffix = end($suffix);
            $suffix = strtolower($suffix);

            return $suffix;
        }
    }
    $zdir = new Zdir;
?>