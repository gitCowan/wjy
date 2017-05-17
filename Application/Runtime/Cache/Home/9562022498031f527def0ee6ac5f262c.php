<?php if (!defined('THINK_PATH')) exit();?><script>
	var interval = '<?php echo ($_GET["interval"]); ?>';

	var chart_type = '<?php echo ($_GET["type"]); ?>';

	var rows = '45';
	var code = '<?php echo ($_GET["code"]); ?>';
	//var code = 'conc';
	var width='100%';
	var height='auto';
	var host = 'http://'+document.domain+'/';
	var socket_url = host+'index.php/Home/Jiekou/ajaxKchart';
	var url_h      = host+'index.php/Home/Jiekou/ajaxKchart';
	var url_d 	   = host+'index.php/Home/Jiekou/ajaxKchart';
	var hour = "<?php echo date('H'); ?>";
	var day  = "<?php echo date('w'); ?>";
	var chart_model = 1;
	var tpl = "<?php echo ($tpl); ?>";
	if(tpl == 2){
		var beijing = '#202020';
		var xian    = "#fff";
	}else{
		var beijing = '#fff';
		var xian    = "#2B2B2B";
	}

</script>
<script language="javascript" type="text/javascript" src="/Public/jsp/jquery-2.1.1.min.js"></script>
<script src="/Public/jsp/highstock.src.js"></script>
<script src="/Public/jsp/highstock.theme.js"></script>
<script src="/Public/jsp/socket.io.js"></script>
<script type="text/javascript" src="/Public/jsp/init.js"></script>
<body style=" margin:0px;">

<div id="container" ></div>

</body>
</html>