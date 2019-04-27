<?php
	error_reporting(E_ALL^E_NOTICE^E_WARNING^E_DEPRECATED);
	//载入配置文件
	include_once("./config.php");
	//载入zdir类
	include_once("./functions/zdir.class.php");
	//获取当前目录
	$thedir = __DIR__;
	$i = 0;
	

	//获取目录
	$dir = $_GET['dir'];

	//对目录进行过滤
	if((stripos($dir,'./') === 0) || (stripos($dir,'../')) || (stripos($dir,'../') === 0) || (stripos($dir,'..') === 0) || (stripos($dir,'..'))){
		echo '非法请求！';
		exit;
	}
	//分割字符串
	$navigation = explode("/",$dir);

	if(($dir == '') || (!isset($dir))) {
		$listdir = scandir($thedir);
	}
	else{
		$listdir = scandir($thedir."/".$dir);
	}
	//计算上级目录
	function updir($dir){
		//分割目录
		$dirarr = explode("/",$dir);
		$dirnum = count($dirarr);
		
		#var_dump($dirarr);
		if($dirnum == 2) {
			$updir = 'index.php';
		}
		else{
			$updir = '';
			for ( $i=1; $i < ($dirnum - 1); $i++ )
			{ 
				$next = $i + 1;
				$updir = $updir.'/'.$dirarr[$i];
				
			}
			$updir = 'index.php?dir='.$updir;
		}
		return $updir;
	}
	#echo updir($dir);
	$updir = updir($dir);

?>
<?php
	//载入页头
	include_once("./template/header.php")
?>
    <!--面包屑导航-->
	<div id="navigation" class = "layui-hide-xs">
		<div class="layui-container">
			<div class="layui-row">
				<div class="layui-col-lg12">
					<p>
						当前位置：<a href="./">首页</a> 
						<!--遍历导航-->
						<?php foreach( $navigation as $menu )
						{
							$remenu = $remenu.'/'.$menu;
							
							if($remenu == '/'){
								$remenu = $menu;
							}
						?>
						<a href="./index.php?dir=<?php echo $remenu; ?>"><?php echo $menu; ?></a> / 
						<?php } ?>
					</p>
				</div>
			</div>
		</div>
	</div>
    <!--面包屑导航END-->
	<!--遍历目录-->
	<div id="list">
		<div class="layui-container">
		  	<div class="layui-row">
		    	<div class="layui-col-lg12">
			    	<table class="layui-table" lay-skin="line">
					  	<colgroup>
					    <col width="400">
					    <col width="200">
					    <col width="200">
					    <col width="180">
					    <col>
					  </colgroup>
					  <thead>
					    <tr>
					      <th>文件名</th>
					      <th class = "layui-hide-xs"></th>
					      <th class = "layui-hide-xs">修改时间</th>
					      <th>文件大小</th>
					      <th class = "layui-hide-xs">操作</th>
					    </tr> 
					  </thead>
					  <tbody>
					    <?php foreach( $listdir as $showdir ) {
						    //防止中文乱码
						    //$showdir = iconv('gb2312' , 'utf-8' , $showdir );
						    $fullpath = $thedir.'/'.$dir.'/'.$showdir;
						    $fullpath = str_replace("\\","\/",$fullpath);
						    $fullpath = str_replace("//","/",$fullpath);
						    
						    //获取文件修改时间
						    $ctime = filemtime($fullpath);
						    $ctime = date("Y-m-d H:i",$ctime);

						    
						    //搜索忽略的目录
						    if(array_search($showdir,$ignore)) {
							    continue;
						    }
						    
						    //如果是文件
						    if(is_file($fullpath)){
							    //获取文件后缀
						    	$suffix = explode(".",$showdir);
						    	$suffix = end($suffix);
						    	
							    $url = '.'.$dir.'/'.$showdir;

							    //根据不同后缀显示不同图标
							    $ico = $zdir->ico($suffix);
							    

							    //获取文件大小
							    $fsize = filesize($fullpath);
							    $fsize = ceil ($fsize / 1024);
							    if($fsize >= 1024) {
								    $fsize = $fsize / 1024;
								    $fsize = round($fsize,2).'MB';
							    }
							    else{
								    $fsize = $fsize.'KB';
							    }
							    $type = 'file';
						    }
						    $i++;
						?>
					    <tr id = "id<?php echo $i; ?>">
						    <td>
							    <a href="../?epub=bookcase/<?php echo $url; ?>" id = "url<?php echo $i; ?>"><i class="<?php echo $ico; ?>"></i> <?php echo $showdir; ?></a>
						    </td>
						    <td id = "info" class = "layui-hide-xs">
							    <!--如果是文件-->
							    <?php if($type == 'file'){ ?>
									<a href="javascript:;" title = "查看文件hash" onclick = "filehash('<?php echo $showdir; ?>','<?php echo $fullpath; ?>')"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
							    <?php } ?>
						    </td>
						    <td class = "layui-hide-xs"><?php echo $ctime; ?></td>
						    <td><?php echo $fsize; ?></td>
						    <td class = "layui-hide-xs">
									<a href="javascript:;" class = "layui-btn layui-btn-xs layui-btn-danger" onclick = "delfile(<?php echo $i; ?>,'<?php echo $showdir; ?>','<?php echo $fullpath; ?>')">删除</a>
						    </td>
					    </tr>
					    <?php } ?>
					  </tbody>
					</table>
		    	</div>
		  	</div>
		</div> 
	</div>
	
<?php
	//载入页脚
	include_once("./template/footer.php")
?>
