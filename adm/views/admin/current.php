<div id="errors-form">			
	<div class="h1"><h1>Статистика текущих статусов страниц ( последнее сканирование ).</h1></div>
</div>
<?php //echo $search; ?>
<div id="statistic-result">
<table>
	<tr>
		<th>#</th>			
		<th>URL</th>
		<th>Auth</th>
		<th>Текущий статус</th>
		<th>Дополнительно</th>						
	</tr>
	<?php
	$a=1;
	 foreach ($current as $k=>$v){
		$s='';
		$status_down;
		$status_additional='';
		if($a==2){
			$s='class="odd"';
			$a=0;
		}
		$a++;
		
		if($v['status_down']==0){
			$status_down='Активна';
			if($v['date_status_up']>$v['date_status_down']){
				$status_additional='Последний таймаут: с 
				'.date('d-m-Y H:i',$v['date_status_down']).' по '.date('d-m-Y H:i',$v['date_status_up']).'  
				('.intval(($v['date_status_up']-$v['date_status_down'])/60).' мин.)';
			}
		}
		if($v['status_down']==2){
			$status_down='<div class="red">Недоступна</div>';
			$status_additional='Была активна до: '.date('d-m-Y H:i',$v['date_status_down']); ;
		}
	?>
	<tr <?php echo $s;?>>
		<td><?php echo $v['id'];?></td>			
		<td><a href="<?php echo $v['pageUrl'];?>" target="_blank"><?php echo $v['pageName'];?></a></td>
		<td><?php echo $v['auth'];?></td>	
		<td align="right"><?php echo $status_down;?> </td>		
		<td><?php echo $status_additional;?> </td>				
	</tr>
	<?php } ?>
</table>
</div>





