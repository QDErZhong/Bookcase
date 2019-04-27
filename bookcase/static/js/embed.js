layui.use(['layer','element'], function(){
    var layer = layui.layer;
    var element = layui.element;
})
$(document).ready(function(){
	//隐藏.
	$("#id1").remove();
	//如果是首页，隐藏..
	uri = window.location.search;
	if(uri == '') {
		$("#id2").remove();
	}
});

protocol = window.location.protocol;		//获取协议
host = window.location.host;				//获取主机
pageurl = protocol + '//' + host + '/';

//复制按钮
function copy(url){
	url = url.replace("./","");
	//重组url
	protocol = window.location.protocol;		//获取协议
	host = window.location.href;				//获取主机
	url = host + url;

	//获取文件后缀
	var index1=url.lastIndexOf(".");
	var index2=url.length;
	var suffix=url.substring(index1+1,index2);

	switch(suffix){
		case 'js':
			url = "<script src = '" + url + "'></script>";
			break;
		case 'css':
			url = "<link rel='stylesheet' href='" + url + "'>";
		default:
			//如果是图片
			if((suffix == 'jpg') || (suffix == 'jpeg') || (suffix == 'gif') || (suffix == 'bmp') || (suffix == 'png')){
				url = "<img src = '" + url + "' />";
			}
			else{
				url = url;
			}
		break;
	}
	
	
	var copy = new clipBoard(document.getElementById('list'), {
        beforeCopy: function() {
            
        },
        copy: function() {
            return url;
        },
        afterCopy: function() {
			layer.msg('复制成功！');
        }
    });
}

//计算文件hash
function filehash(name,path){
	var file = path;
	
	//alert(file);
	$.post("./functions/hash.php",{file:file},function(data,status){
		var fileinfo = eval('(' + data + ')');
		if(fileinfo.code == 1){
			layer.open({
  				title:name,
  				area: ['400px', 'auto'],
			  	content: '<b>md5: </b>' + fileinfo.md5 + '<br /><b>sha1: </b>' + fileinfo.sha1
			});  
		}
		else{
			layer.msg(fileinfo.msg); 
		}
	});
}
//删除文件
function delfile(id,filename,filepath){
	id = "id" + id;
	layer.prompt({
		formType: 1,
		title: '请输入密码删除 - ' + filename
	}, function(value, index, elem){
		$.post('./functions/delfile.php',{filepath:filepath,password:value},function(data,status){
			var redata = eval('(' + data + ')');
			if(redata.code == 1){
				$("#" + id).remove();
				layer.msg(redata.msg + ' ' + filename);
			}
			else{
				layer.msg(redata.msg);
			}
		});
		layer.close(index);
	});
}