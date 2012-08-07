<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Вход</title>
<link href="/pub/css/admin.css" rel="stylesheet" type="text/css">	
</head>
<body>

<div id="login-form">
<form action="/admin/login" method="post">
<table cellpadding="0" cellspacing="0" border="0">
	<tr>
		<th colspan="2">Вход в админпанель</th>
		
	</tr>
	<tr>
		<td>Логин:</td>
		<td><input name="login" type="text" size="20" maxlength="256" /></td>
	</tr>
	<tr>
		<td>Пароль:</td>
		<td><input name="password" type="text" size="20" maxlength="256" /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
		<!--<input name="sfd" type="submit" value="Войти" />-->
		<a href="#" onclick="document.forms[0].submit(); return false;" class="btn_small gray "><span>Войти</span></a></td>
	</tr>
	<?php if($error!=''){?>
	<tr>
		<td>&nbsp;</td>
		<td><div id="login-error"><?php echo $error;?></div></td>
	</tr>
	<?php } ?>

</table>
</form>
</div>

</body>
</html>




