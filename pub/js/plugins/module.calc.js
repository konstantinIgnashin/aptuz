interface.calc = (function(self, $){				  
	var _callBack = {
		c:'#content',
		logs:function(data){
			$("#content").html($("#calcTpl").tmpl(data.success).html());
			$('.calc-apply').click(function(){
				var oneLot = Number($('#calc-price').val())* 100000/Number($('.calc-leverage').val());
				$('.res-lot').text(oneLot+"$");				
				var onePercent = Number($('#calc-deposit').val())/100;				
				var allPercents = onePercent*$('#calc-percents').val();
				$('.res-percent').text(onePercent + "$");	
				$('.res-percents').text(allPercents + "$");
				var riskLot = ( allPercents/(10*$('#calc-points').val())).toPrecision(1);				
				$('.res-risklots').text(riskLot);
				var minMargin = (riskLot*oneLot).toPrecision(2);
				$('.res-margin').text(minMargin + "$");
				return false;
			});
			$('.summary-log').focus(function(){
				$(this).addClass('focus');									 
			});
		}
	}; 
	
	self.start = function(){
		interface.loader.getJSON('/admin/calculator', _callBack.logs);
	};	
	
	$(document).ready(self.start);		
	return self;
})(interface.calc || {}, jQuery);

