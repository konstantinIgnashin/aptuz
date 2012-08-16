


T.start = (function(self, $){
	var _popularyData;
	var _callBack = {
		c:'#content',
		summaryLog:function(){			
			$('.pagination','.summary-log').click(function(){				
				return self.loadLogs(this.name);				
			});			
			T.paging.keyboardBinds(".summary-log", this.c, self.loadLogs);
		},
		summaryErrors:function(){
			$('.pagination','.summary-errors').click(function(){		
				return self.loadErrors(this.name);				
			});			
			T.paging.keyboardBinds(".summary-errors", this.c, self.loadErrors);
		},
		populary:function(){
			$('.title','.summary-log').click(function(){		
				return self.loadPageQueries(this.title, this.innerHTML);				
			});
			$('.get-html-link','.summary-log').click(function(){				
				$('.onoff_box').each(this.click);				
				return false;
			});
			$('.onoff_box').click(function(){
				$(this).toggleClass('active');				
       			var checkbox = $(this).find(':checkbox');
       			checkbox.attr('checked', !checkbox.is(':checked'));			
			});
			$('.getlink').click(function(){
				var checked  = {};
				$('.onoff_box').each(function(){					
					var checkbox = $(this).find(':checkbox');
					if(checkbox.is(':checked')){						
						checked[checkbox.val()]=self.findKeyData(self._popularyData.log,'id',checkbox.val());
					}
				});				
				T.dialog(interface.tmpl("#indexGetLinksTpl",{checked:checked}));
				return false;
			});
		}
		
	};	
	
	var self = {
		_popularyData:'',		
		findKeyData:function(obj,keyName,keyValue){
			for (var p in obj) {
				if (obj.hasOwnProperty(p) && obj[p][keyName]==keyValue) {
					return obj[p];
				}
			}
		},
		loadLogs:function(page){
			T.loader.getJSON('/admin/summary_logs/?page='+page, function(data){				
				$(".summary-log",'#content').html(T.tmpl("#indexSummaryLogTpl",data.success));
				_callBack.summaryLog();
			});
			return false;
		},
		loadPageQueries:function(page,text){
			T.loader.getJSON('/admin/populary/?page='+page, function(data){
				self._popularyData = data.success;															 
				$(".summary-queries",'#content').html(T.tmpl("#indexPopularyQueriesTpl",data.success));					
			});
		},
		loadStartPage:function(){
			if(window.location.hash){
				$('.'+window.location.hash.toString().replace('\#','')).click();				
			}
			else{				
				$('a.item:first','#left-menu').click();
			}			
		}

		
	}
	
	
	
	var binds = function (){
		var highlightMenu = function(my){
			$('.fs-side-menu li>a').removeClass('on');
			$(my).addClass('on');	
		}
		$('.menu-summary').click(function(){
			highlightMenu(this);
			T.loader.getJSON(this.href, function(data){				
				$("#content").html($( "#commentsTableTpl").tmpl(data.success).html());
				_callBack.summaryLog();
				_callBack.summaryErrors();
			});
			return false;
		});
		
		$('#menu-populary').click(function(){
			highlightMenu(this);			
			T.loader.getJSON(this.href, function(data){		
				self._popularyData = data.success;	
				$("#content").html($("#indexPopularyTpl").tmpl(data.success).html());
				_callBack.populary();
			});
			//T.loadModule('logs',{'scripts':['/pub/js/plugins/module.logs.js'],'tpls':['/pub/js/views/logs.html']});
			return false;
		});
		$('#menu-comments').click(function(){
			highlightMenu(this);				
			T.loadModule('comments',{'scripts':['/pub/js/plugins/module.comments.js']});
			return false;
		});
		$('#menu-calendar-stat').click(function(){
			highlightMenu(this);			
			T.calendarStat.start(0);
			return false;
		});
		$('#menu-recomendations').click(function(){
			highlightMenu(this);			
			T.loadModule('recomendations',{'scripts':['/pub/js/plugins/module.recomendations.js'],'tpls':['/pub/js/views/recomendations.html']});			
			return false;
		});
		
		
	}

	$(document).ready(function(){		
		binds();
		self.loadStartPage();		
	});
	return self;
})(T.start || {}, jQuery);


