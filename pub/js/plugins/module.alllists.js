T.alllists = (function(self, $){				  
	
	var _callBack = {
		c:'#content',
		logs:function(){
			$('.pagination','.summary-log').click(function(){				
				return self.loadLogs(this.name);				
			});
			T.paging.keyboardBinds(".summary-log", this.c, self.loadLogs);			
		},
		tabs:function(){
			$('a','.tab-box').removeClass('on');
			$(this).addClass('on');
			self.load(this,0);
			return false;
		}
	}; 
	
	self.load = function(el,page){
		T.loader.getJSON(el.href+'?page='+page, function(data){				
			$('.tab-body',"#content").html(T.tmpl("#roomUsersTpl",data.success));			
			//_callBack.logs();			
		});	
		return false;
	}
	self.start = function(){
		$('#content').html(T.tmpl("#alllistsTpl"));
		$('a','.tab-box').click(_callBack.tabs);
		$('a:first','.tab-box').click();		
	}
	/*-Actions-*/
	self.actions = function(id){
		var top = {}, hide = {};
		top.edit = {text:'Edit',click:self.menu.edit.click};
		top.or = {text:'All',click:self.menu.or.click};
		hide.statistic = {text:'View statistic',click:self.menu.statistic.click};
		hide.del = {text:'Delete item',click:self.menu.del.click};		
		return T.tmpl("#alllistsActionsTpl",{top:top, hide:hide, id:id});
	}
	self.menu = {edit:{click:''},
				 or:{click:function(id){
					 $('#hide-menu-'+id).toggleClass('show');
					 return false;
				}},
				del:{click:''},
				statistic:{click:''}
				};
	
	$(document).ready(self.start);		
	return self;
})(T.alllists || {}, jQuery);



