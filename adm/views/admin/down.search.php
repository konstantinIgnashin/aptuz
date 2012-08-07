<div id="errors-form">			
	<div class="h1"><h1>Статистика таймаутов страниц.</h1></div>
	<table>
		<tr>
			<td>Начало:</td>
			<td><input name="start_date" type="text" id="ssd" value="<?php echo $startD; ?>"  />
			<input type="button" value="&nbsp;" id="ssd-b" title="Показать календарь"></td>
			<td>Конец:</td>
			<td><input name="end_date" type="text"  id="sed" value="<?php echo $endD ?>"  />
			<input type="button" value="&nbsp;" id="sed-b" title="Показать календарь">
			</td>
			<td><div id="StatisticFiltrs">	
			<select id="page_filtr" name="page_filtr">
				<option value="0">Все страницы</option>	
			<?php foreach ($pages as $k=>$v){
				$s='';
				if($v['id']==$page){
					$s='selected="selected"';
				}?>
				
				<option value="<?php echo $v['id']  ?>" <?php echo $s ?>><?php echo $v['name']?></option>					
			<?php } ?>
			</select>
	
	</div></td>
			<td><input name="yiuy" type="submit" value="Показать" id="getDown"  /></td>
			<td><input name="CSV" type="submit" value="CSV" id="getDownCSV"  /></td>
		</tr>
	</table>						
</div>

<script type="text/javascript">
    Calendar.setup({
        inputField     :    "ssd",      // id of the input field
        ifFormat       :    "%d.%m.%Y %H:%M",       // format of the input field
        showsTime      :    true,       // will display a time selector
        button         :    "ssd-b",   // trigger for the calendar (button ID)
        singleClick    :    false,    // double-click mode
        step           :    1        // show all years in drop-down boxes (instead of every other year as default)
    });
	Calendar.setup({
        inputField     :    "sed",      // id of the input field
        ifFormat       :    "%d.%m.%Y %H:%M",       // format of the input field
        showsTime      :    true,       // will display a time selector
        button         :    "sed-b",   // trigger for the calendar (button ID)
        singleClick    :    false,    // double-click mode
        step           :    1        // show all years in drop-down boxes (instead of every other year as default)
    });
	
	$("#getDown").click(function(){
		var down= new Down();
		down.getDown();											   
	});
	$("#getDownCSV").click(function(){
		var down= new Down();
		down.getDownCSV();											   
	});
</script>

