interface.user = (function(self, $){
	 self.settings = {
		 lang:'en',
		 location:'index',
		 isAuth:false		 
	 };
	 self.lang = {};
	 self.user = {};
	 _construct = function(){		
	 	interface.loadScript('/pub/js/lang/'+ self.settings.lang + '.js');		
	 }	
	_construct();	
	return self;
})(interface.user || {}, jQuery);
