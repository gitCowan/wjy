<?php if (!defined('THINK_PATH')) exit();?>
<!doctype html>
<html lang="zh" style="font-size: 50px;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title>用户充值</title>
    <link href="/Public/css/style.63b80c8ea43c65e0b962.css" rel="stylesheet">
    <script type='text/javascript'>
      function  check(){
          var order_sn = $("#order_sn").val();
          alert(order_sn);
          window.location.href("http://www.lihaijun8888.com/index.php");
         /* $.ajax({
              type:"post",
              url:"/index.php?order_sn="+order_sn,
              success:function(result){
                  alert(result);
                  window.location.href();
              }
          });*/
      }
    </script>
</head>
<body style="overflow: hidden;">
<div>
    <div data-reactroot="">
        <div class="am-modal-mask"></div>
        <div tabindex="-1" class="am-modal-wrap " role="dialog">
            <div role="document" class="am-modal rt-alert-model rt-scan-code-modal"
                 style="width: 100%; height: 100%; background: rgb(255, 255, 255);">
                <div class="am-modal-content">
                    <div class="am-modal-body">
                        <div class="rt-absolute-father rt-vcode">
                            <header>
                                <div class="am-flexbox am-flexbox-align-middle rt-simple-Header">
                                    <div class="am-flexbox am-flexbox-align-middle"><a class="rt-simple-btn" href="javascript:history.go(-1);" style="color: #FFF"><i  class="anticon anticon-left"></i>返回</a>
                                     </div>
                                    <div class="am-flexbox-item rt-simple-title rt-flex5" style="text-align: center">在线充值</div>
                                </div>
                            </header>
                            <div class="rt-scan-box">
                                <div class="rt-message">
                                    <div class="rt-wrapper">
                                        <div><p><em>1</em><!-- react-text: 19 --> 请长按二维码，点击保存到相册 <!-- /react-text -->
                                        </p><p><em>2</em><!-- react-text: 19 --> 使用对应支付方式的扫一扫功能打开该图片<!-- /react-text -->
                                        </p>
                                            <p><em>3</em><!-- react-text: 22 --> 完成支付后，点击我已经支付完成<!-- /react-text --></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="rt-separate-line2"></div>
                                <img alt="scan-code"
                                     src="<?php echo ($img_src); ?>" style="width: 250px;">
                            </div>
                            <div class="rt-confirm-btn" ><a href="http://www.lihaijun8888.com/index.php">我已支付完成</a></div>
                        </div>
                    </div>
                </div>
                <div tabindex="0" style="width: 0px; height: 0px; overflow: hidden;">sentinel</div>
            </div>
        </div>
    </div>
</div>
</body>
</html>