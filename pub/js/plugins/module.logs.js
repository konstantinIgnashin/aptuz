interface.logs = (function(self, $){				  
	var _callBack = {
		c:'#content',
		logs:function(){
			$('.pagination','.summary-log').click(function(){				
				return self.loadLogs(this.name);				
			});
			interface.paging.keyboardBinds(".summary-log", this.c, self.loadLogs);			
		}
	}; 
	
	self.loadLogs = function(page){
		interface.loader.getJSON('/admin/summary_logs/?page='+page, function(data){				
			$('.summary-log',"#content").html(interface.tmpl("#logsTpl",data.success));					
			_callBack.logs();			
		});	
		return false;
	}
	self.start = function(){
		$('#content').html(interface.tmpl("#logsIndexTpl",{}));
		self.loadLogs(0);
	}	
	$(document).ready(function(){
		self.start();			   
	});		
	return self;
})(interface.logs || {}, jQuery);

