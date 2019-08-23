<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:42:"./application/admin/view/user/pubtask.html";i:1566447001;s:66:"/www/wwwroot/proyuewanji/application/admin/view/public/layout.html";i:1540260090;}*/ ?>
<!doctype html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<!-- Apple devices fullscreen -->
<meta name="apple-mobile-web-app-capable" content="yes">
<!-- Apple devices fullscreen -->
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<link href="/public/static/css/main.css" rel="stylesheet" type="text/css">
<link href="/public/static/css/page.css" rel="stylesheet" type="text/css">
<link href="/public/static/font/css/font-awesome.min.css" rel="stylesheet" />
<!--[if IE 7]>
  <link rel="stylesheet" href="/public/static/font/css/font-awesome-ie7.min.css">
<![endif]-->
<link href="/public/static/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
<link href="/public/static/js/perfect-scrollbar.min.css" rel="stylesheet" type="text/css"/>
<style type="text/css">html, body { overflow: visible;}</style>
<script type="text/javascript" src="/public/static/js/jquery.js"></script>
<script type="text/javascript" src="/public/static/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="/public/static/js/layer/layer.js"></script><!-- 弹窗js 参考文档 http://layer.layui.com/-->
<script type="text/javascript" src="/public/static/js/admin.js"></script>
<script type="text/javascript" src="/public/static/js/jquery.validation.min.js"></script>
<script type="text/javascript" src="/public/static/js/common.js"></script>
<script type="text/javascript" src="/public/static/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="/public/static/js/jquery.mousewheel.js"></script>
<script src="/public/js/myFormValidate.js"></script>
<script src="/public/js/myAjax2.js"></script>
<script src="/public/js/global.js"></script>
    <script type="text/javascript">
    function delfunc(obj){
    	layer.confirm('确认删除？', {
    		  btn: ['确定','取消'] //按钮
    		}, function(){
    		    // 确定
   				$.ajax({
   					type : 'post',
   					url : $(obj).attr('data-url'),
   					data : {act:'del',del_id:$(obj).attr('data-id')},
   					dataType : 'json',
   					success : function(data){
						layer.closeAll();
   						if(data.status==1){
                            layer.msg(data.msg, {icon: 1, time: 2000},function(){
                                location.href = '';
//                                $(obj).parent().parent().parent().remove();
                            });
   						}else{
   							layer.msg(data, {icon: 2,time: 2000});
   						}
   					}
   				})
    		}, function(index){
    			layer.close(index);
    			return false;// 取消
    		}
    	);
    }

    function selectAll(name,obj){
    	$('input[name*='+name+']').prop('checked', $(obj).checked);
    }

    function get_help(obj){

		window.open("http://www.tp-shop.cn/");
		return false;

        layer.open({
            type: 2,
            title: '帮助手册',
            shadeClose: true,
            shade: 0.3,
            area: ['70%', '80%'],
            content: $(obj).attr('data-url'),
        });
    }

    function delAll(obj,name){
    	var a = [];
    	$('input[name*='+name+']').each(function(i,o){
    		if($(o).is(':checked')){
    			a.push($(o).val());
    		}
    	})
    	if(a.length == 0){
    		layer.alert('请选择删除项', {icon: 2});
    		return;
    	}
    	layer.confirm('确认删除？', {btn: ['确定','取消'] }, function(){
    			$.ajax({
    				type : 'get',
    				url : $(obj).attr('data-url'),
    				data : {act:'del',del_id:a},
    				dataType : 'json',
    				success : function(data){
						layer.closeAll();
    					if(data == 1){
    						layer.msg('操作成功', {icon: 1});
    						$('input[name*='+name+']').each(function(i,o){
    							if($(o).is(':checked')){
    								$(o).parent().parent().remove();
    							}
    						})
    					}else{
    						layer.msg(data, {icon: 2,time: 2000});
    					}
    				}
    			})
    		}, function(index){
    			layer.close(index);
    			return false;// 取消
    		}
    	);
    }

    /**
     * 全选
     * @param obj
     */
    function checkAllSign(obj){
        $(obj).toggleClass('trSelected');
        if($(obj).hasClass('trSelected')){
            $('#flexigrid > table>tbody >tr').addClass('trSelected');
        }else{
            $('#flexigrid > table>tbody >tr').removeClass('trSelected');
        }
    }
    /**
     * 批量公共操作（删，改）
     * @returns {boolean}
     */
    function publicHandleAll(type){
        var ids = '';
        $('#flexigrid .trSelected').each(function(i,o){
//            ids.push($(o).data('id'));
            ids += $(o).data('id')+',';
        });
        if(ids == ''){
            layer.msg('至少选择一项', {icon: 2, time: 2000});
            return false;
        }
        publicHandle(ids,type); //调用删除函数
    }
    /**
     * 公共操作（删，改）
     * @param type
     * @returns {boolean}
     */
    function publicHandle(ids,handle_type){
        layer.confirm('确认当前操作？', {
                    btn: ['确定', '取消'] //按钮
                }, function () {
                    // 确定
                    $.ajax({
                        url: $('#flexigrid').data('url'),
                        type:'post',
                        data:{ids:ids,type:handle_type},
                        dataType:'JSON',
                        success: function (data) {
                            layer.closeAll();
                            if (data.status == 1){
                                layer.msg(data.msg, {icon: 1, time: 2000},function(){
                                    location.href = data.url;
                                });
                            }else{
                                layer.msg(data.msg, {icon: 2, time: 2000});
                            }
                        }
                    });
                }, function (index) {
                    layer.close(index);
                }
        );
    }
</script>  

</head>
<script type="text/javascript" src="/public/plugins/Ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="/public/plugins/Ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/public/plugins/Ueditor/lang/zh-cn/zh-cn.js"></script>
<script src="/public/static/js/layer/laydate/laydate.js"></script>

<style type="text/css">
html, body {overflow: visible;}
</style>  
<body style="background-color: #FFF; overflow: auto;">
<div id="toolTipLayer" style="position: absolute; z-index: 9999; display: none; visibility: visible; left: 95px; top: 573px;"></div>
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title"><a class="back" href="javascript:history.back();" title="返回列表"><i class="fa fa-arrow-circle-o-left"></i></a>
      <div class="subject">
        <h3>发布任务</h3>
        <h5>发布任务与管理</h5>
      </div>
    </div>
  </div>
  <form class="form-horizontal" action="<?php echo U('User/pubtask'); ?>" id="add_post" method="post">    
    <div class="ncap-form-default">
       <dl class="row">
        <dt class="tit">
          <label><em>*</em>标题</label>
        </dt>
        <dd class="opt">
          <input type="text" value="<?php echo $info['desc']; ?>" name="title" class="input-txt">
          <span class="err" id="err_title"></span>
          <p class="notic"></p>
        </dd>
        
      </dl>
      
      <dl class="row">
        <dt class="tit">任务文案</dt>
        <dd class="opt">
	      <textarea class="input-txt" id="post_description" name="description" title=""><?php echo $info['description']; ?></textarea>
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
    <dl class="row">
        <dt class="tit">任务评论</dt>
        <dd class="opt">
	      <textarea class="input-txt" id="" name="content" title=""><?php echo $info['content']; ?></textarea>
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl> 
      
     <!--  <dl class="row">
        <dt class="tit">
          <label><em>*</em>任务步骤</label>
        </dt>
        <dd class="opt">          
            <textarea class="span12 ckeditor" id="post_content" name="content" title="">
                <?php echo $info['content']; ?>
            </textarea>          
            <span class="err"  id="err_content"></span>
            <p class="notic"></p>
        </dd>
      </dl>
       -->
      
      <dl class="row">
        <dt class="tit">
          <label><em>*</em>价格</label>
        </dt>
        <dd class="opt">
          <input type="text" value="<?php echo $info['price']; ?>" name="adv_price" class="input-txt">
          <span class="err" id="err_price"></span>
          <p class="notic"></p>
        </dd>
        
      </dl>
      
       <dl class="row">
	        <dt class="tit">
	          <label><em>*</em>总条数</label>
	        </dt>
	        <dd class="opt">
	          <input type="text" value="<?php echo $info['total_num']; ?>" name="total_num" class="input-txt">
	          <span class="err" id="err_total_num"></span>
	          <p class="notic"></p>
	        </dd>
      </dl>
      
      <dl class="row">
        <dt class="tit">
          <label for="articleForm">链接</label>
        </dt>
        <dd class="opt">
          <input type="text" name="link"  value="<?php echo $info['link']; ?>" class="input-txt">
          <span class="err" id="err_link"></span>
          <p class="notic">当填写"链接"后点击文章标题将直接跳转至链接地址，不显示文章内容。链接格式请以http://开头</p>
        </dd>
      </dl>
	  <dl class="row">
        <dt class="tit">
          <label for="articleForm">浏览时长</label>
        </dt>
        <dd class="opt">
            <input type="text" class="input-txt" id="time_len" name="time_len"  value="<?php echo $info['time_len']; ?>">        
          <span class="err"></span>
        </dd>
      </dl>       
      <dl class="row">
        <dt class="tit">
          <label>显示</label>
        </dt>
        <dd class="opt">
          <div class="onoff">
            <label for="article_show1" class="cb-enable <?php if($info[is_open] == 1): ?>selected<?php endif; ?>">是</label>
            <label for="article_show0" class="cb-disable <?php if($info[is_open] == 0): ?>selected<?php endif; ?>">否</label>
            <input id="article_show1" name="is_open" value="1" type="radio" <?php if($info[is_open] == 1): ?> checked="checked"<?php endif; ?>>
            <input id="article_show0" name="is_open" value="0" type="radio" <?php if($info[is_open] == 0): ?> checked="checked"<?php endif; ?>>
          </div>
          <p class="notic"></p>
        </dd>
      </dl>
      
   
<!--       <dl class="row">
        <dt class="tit">
          <label><em>*</em>任务步骤</label>
        </dt>
        <dd class="opt">          
            <textarea class="span12 ckeditor" id="post_content" name="content" title="">
                <?php echo $info['content']; ?>
            </textarea>          
            <span class="err"  id="err_content"></span>
            <p class="notic"></p>
        </dd>
      </dl> -->
      
      	
      
      
         <dl class="row">
            <dt class="tit">
                <label>图片上传</label>
            </dt>
            <dd class="opt">
                <div class="input-file-show">
                        <span class="show">
                            <a id="img_a" target="_blank" class="nyroModal" rel="gal" href="<?php echo $info['thumb']; ?>">
                                <i id="img_i" class="fa fa-picture-o" onmouseover="layer.tips('<img src=<?php echo $info['thumb_img']; ?>>',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();"></i>
                            </a>
                        </span>
           	            <span class="type-file-box">
                            <input type="text" id="thumb" name="thumb" value="<?php echo $info['thumb_img']; ?>" class="type-file-text">
                            <input type="button" name="button" id="button1" value="选择上传..." class="type-file-button">
                            <input class="type-file-file" onClick="GetUploadify(1,'','article','img_call_back')" size="30" title="点击前方预览图可查看大图，点击按钮选择文件并提交表单后上传生效">
                        </span>
                </div>
                <span class="err"></span>
                <p class="notic">请上传图片格式文件 </p>
            </dd>
        </dl>
        
          <dl class="row">
                <dt class="tit">
                    <label>视频上传</label>
                </dt>
                <dd class="opt">
                    <div class="input-file-show">
                        <span class="type-file-box">
                            <input type="text" id="videotext" name="video" value="<?php echo $info['thumb_img']; ?>" class="type-file-text">
                            <span id="video_button">
                                <?php if($info['thumb_img']): ?>
                                    <input type="button" onclick="delupload()" value="删除视频" class="type-file-button">
                                    <?php else: ?>
                                    <input type="button" name="button" id="videobutton1" value="选择上传..." class="type-file-button">
                                    <input class="type-file-file" onClick="GetUploadify(1,'','goods','video_call_back','Flash')"
                                           size="30" title="点击按钮选择文件并提交表单后上传生效">
                                <?php endif; ?>
                            </span>
                        </span>
                    </div>
                    <span class="err"></span>
                    <p class="notic">请上传视频格式文件   注意：默认以图片为主，如果是视频就不要上传图片</p>
                </dd>
            </dl>
   <!--      <dl class="row">
            <dt class="tit">
                <label>图片上传</label>
            </dt>
            <dd class="opt">
                <div class="input-file-show">
                        <span class="show">
                            <a id="img_a" target="_blank" class="nyroModal" rel="gal" href="<?php echo $info['thumb']; ?>">
                                <i id="img_i" class="fa fa-picture-o" onmouseover="layer.tips('<img src=<?php echo $info['thumb']; ?>>',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();"></i>
                            </a>
                        </span>
           	            <span class="type-file-box">
                            <input type="text" id="thumb" name="thumb" value="<?php echo $info['thumb']; ?>" class="type-file-text">
                            <input type="button" name="button" id="button1" value="选择上传..." class="type-file-button">
                            <input class="type-file-file" onClick="GetUploadify(1,'','article','img_call_back')" size="30" title="点击前方预览图可查看大图，点击按钮选择文件并提交表单后上传生效">
                        </span>
                </div>
                <span class="err"></span>
                <p class="notic">请上传图片格式文件</p>
            </dd>
        </dl> -->
      <div class="bot"><a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green" id="submitBtn">确认提交</a></div>
    </div>
        <input type="hidden" name="act" value="<?php echo $act; ?>">
        <input type="hidden" name="task_id" value="<?php echo $info['id']; ?>">
         <input type="hidden" name="type" value="<?php echo (isset($info['type']) && ($info['type'] !== '')?$info['type']:$type); ?>>
         <input type="hidden" name="file_name" id="file_name" value=""/>
  </form>
</div>
<script type="text/javascript">
   
    $(function () {
        $('#publish_time').layDate(); 
    });
    
    var url="<?php echo url('Ueditor/index',array('savePath'=>'article')); ?>";
    var ue = UE.getEditor('post_content',{
        serverUrl :url,
        zIndex: 999,
        initialFrameWidth: "80%", //初化宽度
        initialFrameHeight: 300, //初化高度            
        focus: false, //初始化时，是否让编辑器获得焦点true或false
        maximumWords: 99999, removeFormatAttributes: 'class,style,lang,width,height,align,hspace,valign',//允许的最大字符数 'fullscreen',
        pasteplain:false, //是否默认为纯文本粘贴。false为不使用纯文本粘贴，true为使用纯文本粘贴
        autoHeightEnabled: true
    });

    $(document).on("click", '#submitBtn', function () {
        verifyForm();
    });
    function verifyForm(){
        $('span.err').hide();
        $.ajax({
            type: "POST",
            url: "<?php echo U('User/pubtaskHandle'); ?>",
            data: $('#add_post').serialize(),
            dataType: "json",
            error: function () {
                layer.alert("服务器繁忙, 请联系管理员!");
            },
            success: function (data) {
                if (data.status === 1) {
                    layer.msg(data.msg, {icon: 1,time: 1000}, function() {
                        location.href = "<?php echo U('Admin/User/tasklist'); ?>";
                    });
                } else if(data.status === 0) {
                    layer.msg(data.msg, {icon: 2,time: 1000});
                    $.each(data.result, function(index, item) {
                        $('#err_' + index).text(item).show();
                    });
                } else {
                    layer.msg(data.msg, {icon: 2,time: 1000});
                }
            }
        });
    }


    function img_call_back(fileurl_tmp)
    {
        $("#thumb").val(fileurl_tmp);
        $("#img_a").attr('href', fileurl_tmp);
        $("#img_i").attr('onmouseover', "layer.tips('<img src="+fileurl_tmp+">',this,{tips: [1, '#fff']});");
    }
    //上传视频回调事件
    function video_call_back(fileurl_tmp) {
        $("#videotext").val(fileurl_tmp);
        $("#video_a").attr('href', fileurl_tmp);
        $("#video_i").attr('onmouseover', "layer.tips('<img src=" + fileurl_tmp + ">',this,{tips: [1, '#fff']});");
        if (typeof(fileurl_tmp) != 'undefined') {
            $('#video_button').html('<input type="button" onclick="delupload()" value="删除视频" class="type-file-button" >');
        }
    }
    
    
</script>
</body>
</html>