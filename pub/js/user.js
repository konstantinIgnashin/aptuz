T.user = (function(self, $){
	 self.settings = {
		 lang:'en',
		 location:'index',
		 isAuth:false		 
	 };
	 self.lang = {};
	 self.user = {};
	 _construct = function(){		
	 	T.loadScript('/pub/js/lang/'+ self.settings.lang + '.js');		
	 }	
	_construct();	
	return self;
})(T.user || {}, jQuery);
