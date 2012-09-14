T.alllists = (function(self, $){				  
	
	var _callBack = {
		c:'#content',
		logs:function(){
			$('.pagination','.summary-log').click(function(){				
				return self.load($('a.on','.tab-box')[0],this.name);				
			});
			//T.paging.keyboardBinds(".summary-log", this.c, self.load);			
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
			_callBack.logs();			
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
		var obj = {};
		obj.top = {edit:'Edit',or:'All'};
		obj.hide = {statistic:'View statistic',del:'Delete item'};			
		obj.id = id;
		return T.tmpl("#alllistsActionsTpl",obj);
	}
	self.menu = {edit:false,
				 or:function(id){
					 $('#hide-menu-'+id).toggleClass('show');
					 return false;
				},
				del:false,
				statistic:false
				};
	
	$(document).ready(self.start);		
	return self;
})(T.alllists || {}, jQuery);



