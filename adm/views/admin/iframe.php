<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Chart</title>

    <link class="include" rel="stylesheet" type="text/css" href="http://static.t.uz/widgets/calendar/css/jquery.jqplot.css" />
    <link rel="stylesheet" type="text/css" href="http://static.t.uz/widgets/calendar/css/examples.css" />
    <link type="text/css" rel="stylesheet" href="http://static.t.uz/widgets/calendar/css/shCoreDefault.css" />
    <link type="text/css" rel="stylesheet" href="http://static.t.uz/widgets/calendar/css/shThemejqPlot.css" />
  
  <!--[if lt IE 9]><script language="javascript" type="text/javascript" src="js/excanvas.js"></script><![endif]-->
    <script class="include" type="text/javascript" src="http://static.t.uz/widgets/calendar/js/jquery.min.js"></script>
</head>

<body>

<!-- Example scripts go here -->

<style type="text/css">
.jqplot-target {
    margin: 30px;
}

#customTooltipDiv {
    position: absolute; 
    display: none; 
    color: #333333;
    font-size: 0.8em;
    border: 1px solid #666666; 
    background-color: rgba(160, 160, 160, 0.2);
    padding: 2px;
}
#info {padding-left:50px;}

.params select {padding:2px;}
</style>

<!-- Example scripts go here -->

<div id="chart1" class="code" style="margin:20px;height:300px; width:640px;"></div>
<div id="info"></div>

<form method="get">
<div class="params">
	<div class="symbol"><select id="symbol" name="symbol">
		<option value="EURUSD">EURUSD</option>
	</select></div>
	<div class="period"><select id="period" name="period">
		<option value="60">H1</option>
	</select></div>
	
	<div class="date">
	<select id="day" name="day">
		<?php for($i=1;$i<=31;$i++){?>
		<option value="<?php echo $i;?>"><?php echo $i;?></option>
		<?php } ?>
	</select>
	<select id="month" name="month">
		<?php for($i=1;$i<=12;$i++){?>
		<option value="<?php echo $i;?>"><?php echo $i;?></option>
		<?php } ?>
	</select>
	<select id="year" name="year">
		<?php for($i=2012;$i>=1999;$i--){?>
		<option value="<?php echo $i;?>"><?php echo $i;?></option>
		<?php } ?>
	</select>
	
	</div>
	<div class="show"><input name="submit" type="submit" value="показать" /></div>
</div>
</form>

<script class="common" type="text/javascript">
    
    ohlc = [
	['07/06/2009', 138.7, 139.68, 135.18, 135.4],
    ['06/29/2009', 143.46, 144.66, 139.79, 140.02],
    ['06/22/2009', 140.67, 143.56, 132.88, 142.44],
    ['06/15/2009', 136.01, 139.5, 134.53, 139.48],
    ['06/08/2009', 143.82, 144.56, 136.04, 136.97],
    ['06/01/2009', 136.47, 146.4, 136, 144.67],
    ['05/26/2009', 124.76, 135.9, 124.55, 135.81],
    ['05/18/2009', 123.73, 129.31, 121.57, 122.5],
    ['05/11/2009', 127.37, 130.96, 119.38, 122.42]/*,
    ['05/04/2009', 128.24, 133.5, 126.26, 129.19],
    ['04/27/2009', 122.9, 127.95, 122.66, 127.24],
    ['04/20/2009', 121.73, 127.2, 118.6, 123.9],
    ['04/13/2009', 120.01, 124.25, 115.76, 123.42],
    ['04/06/2009', 114.94, 120, 113.28, 119.57],
    ['03/30/2009', 104.51, 116.13, 102.61, 115.99],
    ['03/23/2009', 102.71, 109.98, 101.75, 106.85],
    ['03/16/2009', 96.53, 103.48, 94.18, 101.59],
    ['03/09/2009', 84.18, 97.2, 82.57, 95.93],
    ['03/02/2009', 88.12, 92.77, 82.33, 85.3],
    ['02/23/2009', 91.65, 92.92, 86.51, 89.31],
    ['02/17/2009', 96.87, 97.04, 89, 91.2],
    ['02/09/2009', 100, 103, 95.77, 99.16],
    ['02/02/2009', 89.1, 100, 88.9, 99.72],
    ['01/26/2009', 88.86, 95, 88.3, 90.13],
    ['01/20/2009', 81.93, 90, 78.2, 88.36],
    ['01/12/2009', 90.46, 90.99, 80.05, 82.33],
    ['01/05/2009', 93.17, 97.17, 90.04, 90.58],
    ['12/29/2008', 86.52, 91.04, 84.72, 90.75],
    ['12/22/2008', 90.02, 90.03, 84.55, 85.81],
    ['12/15/2008', 95.99, 96.48, 88.02, 90],
    ['12/08/2008', 97.28, 103.6, 92.53, 98.27],
    ['12/01/2008', 91.3, 96.23, 86.5, 94],
    ['11/24/2008', 85.21, 95.25, 84.84, 92.67],
    ['11/17/2008', 88.48, 91.58, 79.14, 82.58],    
    ['11/10/2008', 100.17, 100.4, 86.02, 90.24],
    ['11/03/2008', 105.93, 111.79, 95.72, 98.24],
    ['10/27/2008', 95.07, 112.19, 91.86, 107.59],
    ['10/20/2008', 99.78, 101.25, 90.11, 96.38],
    ['10/13/2008', 104.55, 116.4, 85.89, 97.4],
    ['10/06/2008', 91.96, 101.5, 85, 96.8],
    ['09/29/2008', 119.62, 119.68, 94.65, 97.07],
    ['09/22/2008', 139.94, 140.25, 123, 128.24],
    ['09/15/2008', 142.03, 147.69, 120.68, 140.91],
    ['09/08/2008', 164.57, 164.89, 146, 148.94]*/
    ];
    console.log(ohlc);
</script>

<script class="code" type="text/javascript">
$(document).ready(function(){  
   $('form').submit(function(){
    $.ajax({
		url:  '/api/candles', 
		type: 'GET',
		dataType: 'json',	
		data: {symbol:'', period:'', day:$('#day').val(), month:$('#month').val(), year:$('#year').val()},
		success: function (data) {
			var ohlc = data.a.split(',x');
			for (a in ohlc )ohlc[a] = eval(ohlc[a]);					
			startApp(ohlc);
		},
		error:function (xhr, ajaxOptions, thrownError){
			alert(ajaxOptions.url + "\n" + thrownError );               		
	   }			
	});
	return false;
	});	
	
	function startApp(ohlc){
		$.jqplot.config.enablePlugins = true;     
		$.jqplot.eventListenerHooks.push(['jqplotClick', handleClick]);
		//var s1 = [[1, 1.4310], [2, 1.4330], [3, 1.4340], [4, 1.4450], [9, 1.4420], [37, 1.4390]];    
		$('#chart1').empty();
		plot = $.jqplot('chart1',[ohlc],{
		  title: 'Trader.UZ Calendar',
		  axesDefaults:{},
		  axes: {
			  xaxis: {
				  renderer:$.jqplot.CategoryAxisRenderer,
				 // tickOptions:{formatString:'%m-%d'}			  
			  },
			  yaxis: {
				  tickOptions:{ prefix: '$' }
			  }
		  },
		  series: [{
			renderer:$.jqplot.OHLCRenderer, 
			rendererOptions:{
				candleStick:true, 
				highlightMouseDown: true   
			}			
		  }/*,
		  {renderer:$.jqplot.BlockRenderer,
		  rendererOptions: {
               css:{background:'#ff0000'}
           }
		  }*/
		  
		  
		  ],      
		  cursor:{          
			  tooltipOffset: 10,
			  tooltipLocation: 'nw'
		  },
		  highlighter: {
          showMarker:false,
          tooltipAxes: 'xy',
          yvalues: 4,
          formatString:'<table class="jqplot-highlighter"> \
          <tr><td>date:</td><td>%s</td></tr> \
          <tr><td>open:</td><td>%s</td></tr> \
          <tr><td>hi:</td><td>%s</td></tr> \
          <tr><td>low:</td><td>%s</td></tr> \
          <tr><td>close:</td><td>%s</td></tr></table>'
      }
		});
		
		///////////
		console.log(plot);
		 
 
 
	
	}
	
	function handleClick(ev, gridpos, datapos, neighbor, plot) {
        if (neighbor) {
            var ins = [neighbor.seriesIndex, neighbor.pointIndex, neighbor.data];
            var evt = jQuery.Event('showCandleInfo');
	    	evt.which = ev.which;
            evt.pageX = ev.pageX;
            evt.pageY = ev.pageY;
            plot.target.trigger(evt, ins); 
        }
    }
	
	
	
   $('#chart1').bind('showCandleInfo', 
		function (ev, seriesIndex, pointIndex, data) {              
			alert('series: '+seriesIndex+', point: '+pointIndex+', data: '+data+ ', pageX: '+ev.pageX+', pageY: '+ev.pageY);
			$('#info').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data+ ', pageX: '+ev.pageX+', pageY: '+ev.pageY);
   });	
});</script>

<!-- End example scripts -->

<!-- Don't touch this! -->


    <script class="include" type="text/javascript" src="http://static.t.uz/widgets/calendar/js/jquery.jqplot.min.js"></script>
    <script type="text/javascript" src="http://static.t.uz/widgets/calendar/syntaxhighlighter/scripts/shCore.min.js"></script>
    <script type="text/javascript" src="http://static.t.uz/widgets/calendar/syntaxhighlighter/scripts/shBrushJScript.min.js"></script>
    <script type="text/javascript" src="http://static.t.uz/widgets/calendar/syntaxhighlighter/scripts/shBrushXml.min.js"></script>
<!-- End Don't touch this! -->

<!-- Additional plugins go here -->

    <script class="include" type="text/javascript" src="http://static.t.uz/widgets/calendar/plugins/jqplot.dateAxisRenderer.min.js"></script>
    <script class="include" type="text/javascript" src="http://static.t.uz/widgets/calendar/plugins/jqplot.categoryAxisRenderer.min.js"></script>
    <script class="include" type="text/javascript" src="http://static.t.uz/widgets/calendar/plugins/jqplot.ohlcRenderer.js"></script>
    <script class="include" type="text/javascript" src="http://static.t.uz/widgets/calendar/plugins/jqplot.highlighter.min.js"></script>
    <script class="include" type="text/javascript" src="http://static.t.uz/widgets/calendar/plugins/jqplot.cursor.min.js"></script>

<!-- End additional plugins -->

</body>
</html>
