T.alllists = (function(self, $){				  
	
	var _callBack = {
		c:'#content',
		paging:function(){
			$('.pagination',this.c).click(function(){				
				return self.load(this.name, $('a.on','.tab-box')[0]);				
			});			
			T.paging.keyboardBinds(".summary-log", this.c, function(page){
				return self.load(page, $('a.on','.tab-box')[0]);
			});
			$(".summary-log", this.c).focus();	
			return this;
		},
		tabs:function(){
			$('a','.tab-box').removeClass('on');
			$(this).addClass('on');
			return self.load(0,this);			
		}
	}; 
	
	self.load = function(page,el){
		T.loader.getJSON(el.href+'?page='+page, self.handlers[el.name]);	
		return false;
	}
	self.handlers={
		room:function(data){
			$('.tab-body').html(T.tmpl("#roomUsersTpl",data.success));			
			_callBack.paging();
		},
		downloads:function(data){
			$('.tab-body').html(T.tmpl("#downloadUsersTpl",data.success));
			_callBack.paging();
		},
		buys:function(data){ 
			$('.tab-body').html(T.tmpl("#apiUsersTpl",data.success));
			_callBack.paging();
		}
		
	};
	
	
	
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



