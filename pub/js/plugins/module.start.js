interface.tmpl = function(el, data){
	return $(el).tmpl(data).html();
}

interface.dialog = function(content, callback){
	$('.body', '#modalbox').html(content);
	$('#modalbox').reveal({revealId:'modalbox'});
	if($.isFunction(callback)){
		callback();
	}
}
interface.loader = {
	el:'.app-loader',
	show:function(){
		$(this.el).addClass('show');
	},
	hide:function(){
		$(this.el).removeClass('show');
	},
	getJSON:function (url , data, callback){		
		interface.loader.show();
		if($.isFunction(data)){
			callback = data;
			data = undefined;
		}					
		return $.ajax({
				'url':  url, 
				'type': 'GET',
				'dataType': 'JSON',	
				data: data,
				success: function (data, textStatus) {
					if(data.debug){
						$.each(data.debug, function(i,val){
							//$('<div class="debug"><strong>'+ i +'</strong><br />'+ val +'</div>').appendTo('body');
							console.log(i + ' = ', val);
						});						
					} 
					if($.isFunction(callback)){
						callback(data, textStatus);	
					}
					interface.loader.hide();
				},
				error:function (xhr, ajaxOptions, thrownError){
					//alert(ajaxOptions.url + "\n" + thrownError );               		
			   }			
		});			
	}

};

interface.start = (function(self, $){
	var _popularyData;
	var _callBack = {
		c:'#content',
		summaryLog:function(){			
			$('.pagination','.summary-log').click(function(){				
				return self.loadLogs(this.name);				
			});			
			interface.paging.keyboardBinds(".summary-log", this.c, self.loadLogs);
		},
		summaryErrors:function(){
			$('.pagination','.summary-errors').click(function(){		
				return self.loadErrors(this.name);				
			});			
			interface.paging.keyboardBinds(".summary-errors", this.c, self.loadErrors);
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
				interface.dialog(interface.tmpl("#indexGetLinksTpl",{checked:checked}));
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
			interface.loader.getJSON('/admin/summary_logs/?page='+page, function(data){				
				$(".summary-log",'#content').html(interface.tmpl("#indexSummaryLogTpl",data.success));
				_callBack.summaryLog();
			});
			return false;
		},
		loadPageQueries:function(page,text){
			interface.loader.getJSON('/admin/populary/?page='+page, function(data){
				self._popularyData = data.success;															 
				$(".summary-queries",'#content').html(interface.tmpl("#indexPopularyQueriesTpl",data.success));					
			});
		},
		loadStartPage:function(){
			interface.loader.getJSON('/admin/summary/?page=0', function(data){				
				$("#content").html($( "#indexTpl").tmpl(data.success).html());
				_callBack.summaryLog();
				_callBack.summaryErrors();				
			});	
		}

		
	}
	
	var binds = function (){
		var highlightMenu = function(my){
			$('.fs-side-menu li>a').removeClass('on');
			$(my).addClass('on');	
		}
		$('.menu-summary').click(function(){
			highlightMenu(this);
			interface.loader.getJSON(this.href, function(data){				
				$("#content").html($( "#commentsTableTpl").tmpl(data.success).html());
				_callBack.summaryLog();
				_callBack.summaryErrors();
			});
			return false;
		});
		
		$('#menu-populary').click(function(){
			highlightMenu(this);			
			interface.loader.getJSON(this.href, function(data){		
				self._popularyData = data.success;	
				$("#content").html($("#indexPopularyTpl").tmpl(data.success).html());
				_callBack.populary();
			});
			//interface.loadModule('logs',{'scripts':['/pub/js/plugins/module.logs.js'],'tpls':['/pub/js/views/logs.html']});
			return false;
		});
		$('#menu-comments').click(function(){
			highlightMenu(this);			
			//self.loadComments(0);			
			interface.loadModule('comments',{'scripts':['/pub/js/plugins/module.comments.js']});
			return false;
		});/*
		$('.menu-calc').click(function(){
			highlightMenu(this);			
			interface.loadModule('calc',{'scripts':['/pub/js/plugins/module.calc.js'],'tpls':['/pub/js/views/calc.html']});
			return false;
		});
		*/
		
	}

	$(document).ready(function(){		
		self.loadStartPage();
		binds();
	});
	return self;
})(interface.start || {}, jQuery);


