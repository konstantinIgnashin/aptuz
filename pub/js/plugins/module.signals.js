T.signals = (function(self, $){				  
	self.data = {};
	self.set = function getQueryVariables() {
            //полачаем строку запроса (?a=123&b=qwe) и удаляем знак ?
            var query = window.location.search.substring(1);
            //получаем массив значений из строки запроса вида vars[0] = ‘a=123’;
            var vars = query.split("&");
            var arr = {};
            //переводим массив vars в обычный ассоциативный массив
            for (var i=0;i<vars.length;i++) {
                var pair = vars[i].split("=");
                if (pair[0] == null || pair[0] == "") continue;
                arr[pair[0]] = pair[1];
            }
            return arr;
    }
	
	self.round = function(x, n) { //x - число, n - количество знаков  
	  if(isNaN(x) || isNaN(n)) return false; 
	  var m = Math.pow(10,n); 
	  return Math.round( x*m )/m; 
	}
	
	self.periodToStr = function(period){
		periods = {x1440:'D1',x240:'H4',x60:'H1',x30:'M30',x15:'M15', x5:'M5', x1:'M1'};		
		return periods["x"+period];		
	}
	
	self.shadow = function(period, pair){
		if(period==self.data.period && pair==self.data.pair){			
			return 'focus';
		}
		return '';
	}
	
	self.loadStatistic = function(period, pair, el){
		$('#ip-list-period').val(period);
		$('#ip-list-pair').val(pair);			
		return self.start(0);
	}
	
	var _callBack = {
		c:'#content',
		signals:function(data){				
			self.data= data.success;			
			$('#content').html(T.tmpl("#signalsTpl",data.success));
			$('.pagination',this.c).click(function(){				
				return self.start(this.name);				
			});			
			T.paging.keyboardBinds(".summary-log", this.c, function(page){
				return self.start(page);
			});
			$('.s_btn','.ip-list').click(function(){
				return self.start(0);								  
			});
			$('.create-slice').click(function(){
				T.loader.getJSON('/signals/slice?pair='+$(this).text(), _callBack.dataSlice);				
			});
		},
		dataSlice:function(data){
			var tpl = '<div class="head"><div class="text">'+data.success.pair+' profit data slice</div><a class="ppp-close">×</a></div><div class="body">'+T.tmpl("#sliceDataTpl",data.success)+'</div>';		
			new Popup(tpl);			
		}
	};
	
	self.start = function(page){		
		var pair = $('#ip-list-pair').val() || 0;
		var period = $('#ip-list-period').val() || 0;
		T.loader.getJSON('/signals/?page='+page+'&pair='+ pair + '&period='+period, _callBack.signals);
		return false;
	};
	
	self.cutNulls = function(quote){		
		return ("" + quote).replace(/0$/,'');		
	}
	
	$(document).ready(function(){self.start(0);});		
	return self;
})(T.signals || {}, jQuery);


