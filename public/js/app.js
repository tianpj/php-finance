(function($) {
  'use strict';

  $(function() {
    var $fullText = $('.admin-fullText');
    $('#admin-fullscreen').on('click', function() {
      $.AMUI.fullscreen.toggle();
    });

    $(document).on($.AMUI.fullscreen.raw.fullscreenchange, function() {
      $fullText.text($.AMUI.fullscreen.isFullscreen ? '退出全屏' : '开启全屏');
    });
  });
})(jQuery);
function formatDate(now) {
	var year = now.getYear() + 1900;
	var month = now.getMonth() + 1;
	var date = now.getDate();
	var hour = now.getHours();
	var minute = now.getMinutes();
	var second = now.getSeconds();
	if(minute < 10) {
		minute = '0' + minute;
	}
	if(second < 10) {
		second = '0' + second;
	}
	if(month < 10) {
		month = '0' + month;
	}
	return year + "-" + month + "-" + date + " " + hour + ":" + minute + ":" + second;
}
var d = new Date();
$('#zdy').val(formatDate(d));
//enter键进入
function keyLogin(event) {
	var e = event || window.event || arguments.callee.caller.arguments[0];
	if(e && e.keyCode == 13) { // enter 键
		$('#submitbtn').click();
	}

}
//管理员登录
function checkFrom(){
	var username = $("input[name='username']").val().trim();
	var password = $("input[name='password']").val().trim();
	if(!username || !password){
		document.getElementById("errorMsg").innerHTML = "帐号或密码不能为空！";
		return false;
	}else{
		document.getElementById("errorMsg").innerHTML = "";
	}
	$.ajax({
    url: "index.php?action=login&mod=dologin",
    type: "POST",
    data: $("#myform").serialize(),
    dataType: "json",
    success: function(res){
	    if(res.status == "ok"){
        document.getElementById("errorMsg").innerHTML =res.msg;
        window.location = "index.php";
        }else{
          document.getElementById("errorMsg").innerHTML =res.msg;
        }
	    }
	});
}
//增加来源
function add_source(){
	var source = $("input[name='source']").val().trim();
	if(!source){
		document.getElementById("errorMsg").innerHTML = "不能为空！";
		return false;
	}else{
		document.getElementById("errorMsg").innerHTML = "";
	}
	$.ajax({
    url: "index.php?action=config&mod=add_source",
    type: "POST",
    data: $("#form_addSource").serialize(),
    dataType: "json",
    success: function(res){
	    if(res.status == "ok"){
        document.getElementById("errorMsg").innerHTML =res.msg;
        window.location = "index.php?action=config";
        }else{
          document.getElementById("errorMsg").innerHTML =res.msg;
        }
	    }
	});
}
//增加用途
function add_purpose(){
		var purpose = $("input[name='purpose']").val().trim();

		if(!purpose){

			document.getElementById("errorMsg").innerHTML = "不能为空！";
			return false;
		}else{
			document.getElementById("errorMsg").innerHTML = "";
		}
		$.ajax({
        url: "index.php?action=config&mod=add_purpose",
		    type: "POST",
		    data: $("#form_addPurpose").serialize(),
		    dataType: "json",
		    success: function(res){
		        if(res.status == "ok"){
		            document.getElementById("errorMsg").innerHTML =res.msg;
		            window.location = "index.php?action=config";
		            }else{
		              document.getElementById("errorMsg").innerHTML =res.msg;
		            }
		        }
    });

}


//修改来源
function edit_source(id,source){

		var source = $("input[name='"+source+"']").val().trim();
		//alert(id);return false;
		if(!source){
			document.getElementById("errorMsg").innerHTML = "不能为空！";
			return false;
		}else{
			document.getElementById("errorMsg").innerHTML = "";
		}

		$.ajax({
        url: "index.php?action=config&mod=edit_source",
		    type: "POST",
		    data:{"id":id,"source":source},
		    dataType: "json",
		    success: function(res){
		        if(res.status == "ok"){
		            document.getElementById("errorMsg").innerHTML =res.msg;
		            window.location = "index.php?action=config";
		            }else{
		              document.getElementById("errorMsg").innerHTML =res.msg;
		            }
		        }
    });

}

//修改用途

function edit_purpose(id,purpose){

		var purpose = $("input[name='"+purpose+"']").val().trim();
		//alert(purpose);return false;
		if(!purpose){
			document.getElementById("errorMsg").innerHTML = "不能为空！";
			return false;
		}else{
			document.getElementById("errorMsg").innerHTML = "";
		}

		$.ajax({
        url: "index.php?action=config&mod=edit_purpose",
		    type: "POST",
		    data:{"id":id,"purpose":purpose},
		    dataType: "json",
		    success: function(res){
		        if(res.status == "ok"){
		            document.getElementById("errorMsg").innerHTML =res.msg;
		            window.location = "index.php?action=config";
		            }else{
		              document.getElementById("errorMsg").innerHTML =res.msg;
		            }
		        }
    });

}
//修改详细用途

function edit_pur(id,pur_name){
	var pur_name = $("input[name='"+pur_name+"']").val().trim();
	if(!pur_name){
		document.getElementById("errorMsg").innerHTML = "不能为空！";
		return false;
	}else{
		document.getElementById("errorMsg").innerHTML = "";
	}
	$.ajax({
    url: "index.php?action=config&mod=edit_pur",
	    type: "POST",
	    data:{"id":id,"pur_name":pur_name},
	    dataType: "json",
	    success: function(res){
	        if(res.status == "ok"){
	            document.getElementById("errorMsg").innerHTML =res.msg;
	            window.location = "index.php?action=config";
	            }else{
	              document.getElementById("errorMsg").innerHTML =res.msg;
	            }
	        }
});
}
$('#doc-form-file').on('change', function() {
      var fileNames = '';
      $.each(this.files, function() {
        fileNames += '<span class="am-badge">' + this.name + '</span> ';
      });
      $('#file-list').html(fileNames);
});


//导入信息
function imports(){
	var options = {
		url:"index.php?action=import&mod=doExcel",
		type:"post",
		data:$("#file_form").serialize(),
		dataType:"json",
		success:function(res){
			if(res.status=="success"){
				document.getElementById("errorMsg").innerHTML =res.msg;
				window.location = "index.php?action=import";
			}else{
				document.getElementById("errorMsg").innerHTML =res.msg;
			}
		}
	};

	$("#file_form").ajaxSubmit(options);
	return false;
}
//查询信息  导入时间

function sel_time(){

	 var analysis = $("input[name='analysis']:checked").val().trim();
	 window.location = "index.php?action=analysis&mod=sel_time&analysis="+analysis;
	 return false;

}





