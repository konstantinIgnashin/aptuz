
var T = (function(self, $){		
	_modules = {};
	_scripts = ['/pub/js/jquery/tmpl.pack.js',	'/pub/js/jquery/modalbox.js', '/pub/js/jquery/mousewheel.js', '/pub/js/plugins/paging.js',				
				'/pub/js/user.js',
				/*'/pub/js/plugins/jscalendar-1.0/calendar.js',
				'/pub/js/plugins/jscalendar-1.0/lang/calendar-en.js',
				'/pub/js/plugins/jscalendar-1.0/calendar-setup.js',*/				
				'/pub/js/plugins/module.start.js'];	
	_css     = [/*'/pub/js/plugins/jscalendar-1.0/calendar-win2k-cold-1.css'*/ '/pub/css/modalbox.css'];
	_tpl     = ['/pub/js/views/index.html'];
	_sprites = [];
	self.location = window.location.pathname.replace(/\//g,'');
	self.loadScript = function(url){		
		var script = document.createElement('SCRIPT');
		script.src = url;
		document.head.appendChild(script);		
	}
	self.loadCss = function(url){
		$('head').append( $('<link rel="stylesheet" type="text/css" />').attr('href', url) );
	}
	self.loadTpl = function(url){		
		$.ajax({dataType:'html', cache:true, url:url, async:false, success:function(d){$('head').append(d);}});				
	}
	self.loadAPP = function(scripts, css, tpls){		
		if(tpls instanceof Object){
			$.each(tpls, function(i,val){
				self.loadTpl(val);					 
			});	
		}
		if(scripts instanceof Object){ // Array
			$.each(scripts, function(i,val){
				self.loadScript(val);					 
			});	
		}
		if(css instanceof Object){
			$.each(css, function(i,val){
				self.loadCss(val);					 
			});	
		}
	};
	self.loadModule = function(name, data, force){	 	
		if(force!==undefined || _modules[name]===undefined){
			self.loadAPP(data.scripts, data.css, data.tpls);
			_modules[name] = 1;
		}
		else{			
			T[name].start();	
		}		
	}	
	self.loadAPP(_scripts, _css, _tpl);
	return self;
})(T || {}, jQuery);

/*kernel modules*/
	// template wrapper
	T.tmpl = function(el, data){
		return $(el).tmpl(data).html();
	}
	// modal popup window
	T.dialog = function(content, callback){
		$('.body', '#modalbox').html(content);
		$('#modalbox').reveal({revealId:'modalbox'});
		if($.isFunction(callback)){
			callback();
		}
	}
	// transport for json queries
	T.loader = {
		el:'.app-loader',
		show:function(){
			$(this.el).addClass('show');
		},
		hide:function(){
			$(this.el).removeClass('show');
		},
		getJSON:function (url , data, callback){		
			T.loader.show();
			if($.isFunction(data)){
				callback = data;
				data = undefined;
			}					
			return $.ajax({
					'url':  url, 
					'type': 'GET',
					'dataType': 'JSON',	
					data: data,
					success: function (data) {
						if(data.debug){
							$.each(data.debug, function(i,val){
								//$('<div class="debug"><strong>'+ i +'</strong><br />'+ val +'</div>').appendTo('body');
								console.log(i + ' = ', val);
							});						
						}
						if(data.error){								
							if(data.error=='auth'){								
								return document.location='/admin/login';
							}
						}
						if($.isFunction(callback)){
							callback(data);	
						}
						T.loader.hide();
					},
					error:function (xhr, ajaxOptions, thrownError){
						//alert(ajaxOptions.url + "\n" + thrownError );               		
				   }			
			});			
		}
	};