
var interface = (function(self, $){		
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
			interface[name].start();	
		}		
	}	
	self.loadAPP(_scripts, _css, _tpl);
	return self;
})(interface || {}, jQuery);


