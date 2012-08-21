T.recomendations = (function(self, $){				  
	var _callBack = {
		c:'#content',
		recomendations:function(){
			
		}
		
	};
	
	self.start = function(page){
		var add='';
		T.loader.getJSON('/recomendations/?page='+page, function(data){			
			$('#content').html(T.tmpl("#recMainTpl",data.success));
			_callBack.recomendations();
		});
		return false;
	};
	
	self.cutNulls = function(quote){		
		return ("" + quote).replace(/0$/,'');		
	}
	
	$(document).ready(function(){self.start(0);});		
	return self;
})(T.recomendations || {}, jQuery);


