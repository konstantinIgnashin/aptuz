<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Adm</title>
	<link href="/pub/css/admin.css" rel="stylesheet" type="text/css">	
	<script type='text/javascript' src="/pub/js/jquery/jquery-1.6.min.js"></script>
	<script type='text/javascript' src="/pub/js/kernel.js"></script>
	
	<script type="text/javascript" src="/pub/js/plugins/markitup/jquery.markitup.js"></script>
	<script type="text/javascript" src="/pub/js/plugins/markitup/sets/default/set.js"></script>
	<link rel="stylesheet" type="text/css" href="/pub/js/plugins/markitup/sets/default/style.css" />
	<link rel="stylesheet" type="text/css" href="/pub/js/plugins/markitup/skins/markitup/style.css" />
	
	<?php /*		
	<link rel="stylesheet" type="text/css" href="/pub/jscalendar-1.0/calendar-win2k-cold-1_.css" />
	<script src="/pub/jscalendar-1.0/calendar.js" type="text/javascript" ></script>
	<script src="/pub/jscalendar-1.0/lang/calendar-en.js" type="text/javascript" ></script>
	<script src="/pub/jscalendar-1.0/calendar-setup.js" type="text/javascript" ></script> 
	
	*/ ?>

	
</head>

<body>	
	<div id="header">		
		<div class="border">
		<div class="app-title"><img src="/pub/images/icons/application_home.png">Система контроля сайта</div>
		<div class="app-loader"></div>
		<div class="app-uinfo">
			<span><?php echo $user[0]['first_name'];?> <?php echo $user[0]['last_name'];?></span><a href="/admin/logout">Выйти</a></div>
			<div class="clear"></div>
		</div>		
	</div>
	
	<div id="body-area">
		<div id="left-menu" class="fs-content-box new">					
			<ul class="fs-side-menu">			
				<!--<li><a id="menu-summary"  class="menu-summary on" href="/admin/summary">Статистика запросов</a></li>
				<li><a id="menu-populary" class="menu-populary" href="/admin/populary">Популярные страницы</a></li>-->
				<li><a id="menu-comments" class="menu-comments" href="/admin/comments">Комментарии</a></li>
				<!--<li><a id="menu-calc"    class="menu-calc"   href="/admin/calculator">Калькулятор</a></li>				
				<li><a id="menu-history" class="menu-history" href="/admin/log">История сделок</a></li>
				<li><a id="menu-config"  class="menu-config"  href="/admin/log">Конфигурация робота</a></li>-->
			</ul> 		
		</div>
		<div id="content"></div>		
		<div class="clear"></div>
	</div>
	
	<div id="footer">
		<div class="border">
			<div class="site-info">Copyrights <a href="http://trader.uz">trader.uz</a> 2007 - 2012 </div>
		</div>
	</div>
	<div id="modalbox" class="reveal-modal">
		<div class="head"><h1>Reveal Modal Goodness</h1><a class="close-reveal-modal">&#215;</a></div>	
		<div class="body">	
			<p>This is a default modal in all its glory, 
			but any of the styles here can easily be changed in the CSS.</p>
		</div>	
	</div>
</body>
</html>
