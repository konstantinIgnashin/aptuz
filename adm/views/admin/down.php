
<?php echo $search; ?>
<div id="statistic-result">
<table>
	<tr>
		<th>Дата down</th>
		<th>Дата up</th>	
		<th>URL</th>
		<th>Длительность</th>					
	</tr>
	<?php
	$a=1;
	 foreach ($down as $k=>$v){
		$s='';
		if($a==2){
			$s='class="odd"';
			$a=0;
		}
		$a++;
	?>
	<tr <?php echo $s;?>>
		<td><?php echo date('d-m-Y H:i',$v['startTime']) ;?></td>	
		<td><?php echo date('d-m-Y H:i',$v['endTime']) ;?></td>	
		<td><a href="<?php echo $v['pageUrl'];?>" target="_blank"><?php echo $v['pageName'];?></a></td>
		<td><?php echo intval(($v['endTime']-$v['startTime'])/60);?> мин. </td>				
	</tr>
	<?php } ?>
</table>
</div>





