dateDown,dateUp,pageName,pageUrl,time
<?php	
	$c='';
	foreach ($down as $k=>$v){
		$c.=date('d-m-Y H:i',$v['startTime']).','.date('d-m-Y H:i',$v['endTime']).','.$v['pageName'].','.$v['pageUrl'].','.intval(($v['endTime']-$v['startTime'])/60).' min.'."\n";		
	} 
	echo $c;
?>





