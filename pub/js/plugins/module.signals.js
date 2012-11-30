T.signals = (function(self, $){				  
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
	
	var _callBack = {
		c:'#content',
		signals:function(data){			
			$('#content').html(T.tmpl("#signalsTpl",data.success));
			$('.pagination',this.c).click(function(){				
				return self.start(this.name);				
			});			
			T.paging.keyboardBinds(".summary-log", this.c, function(page){
				return self.start(page);
			});
		}		
	};
	
	self.start = function(page){		
		T.loader.getJSON('/signals/?page='+page, _callBack.signals);
		return false;
	};
	
	self.cutNulls = function(quote){		
		return ("" + quote).replace(/0$/,'');		
	}
	
	$(document).ready(function(){self.start(0);});		
	return self;
})(T.signals || {}, jQuery);


